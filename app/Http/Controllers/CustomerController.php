<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardEntryRequest;
use App\Http\Requests\ShoppingCartViewRequest;
use App\Models\Bill;
use App\Models\Offer;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $offers = Offer::where('state', '!=', false)
            ->whereDate('end_date', '>=', now())
            ->with('companies')
            ->withCount('coupons as purchased_coupons_count')
            ->get();

        $availableOffers = $offers->filter(function ($offer) {
            if (is_null($offer->amount)) {
                $offer->available_quantity = '∞';
                return true;
            }

            $available = $offer->amount - $offer->purchased_coupons_count;

            $offer->available_quantity = max(0, $available);

            return $offer->available_quantity > 0;
        });

        return view('costumer.landing', compact('availableOffers'));
    }

    public function offerDetails($id)
    {
        $offer = Offer::where('offer_uuid', $id)
            ->with('companies')
            ->withCount('coupons as purchased_coupons_count')
            ->first();

        if (!$offer) {
            abort(404, 'Offer not found.');
        }
        if (is_null($offer->amount)) {
            $offer->available_quantity = '∞';
        } else {
            $available = $offer->amount - $offer->purchased_coupons_count;
            $offer->available_quantity = max(0, $available);
        }

        return view('costumer.offer-detail', compact('id', 'offer'));
    }


    public function addCart(Request $request)
    {
        $validated = $request->validate([
            'offer_uuid' => 'required|string|uuid',
            'quantity' => 'required|integer|min:1',
        ]);

        $offerUuid = $validated['offer_uuid'];
        $quantity = $validated['quantity'];

        $cart = session()->get('cart_items', []);

        $offer = Offer::where('offer_uuid', $offerUuid)->first();
        if (!$offer) {
            return response()->json(['message' => 'La oferta no existe.'], 404);
        }

        $currentQuantity = $cart[$offerUuid] ?? 0;
        $newTotalQuantity = $currentQuantity + $quantity;

        if ($newTotalQuantity > 5) {
            return response()->json(['message' => 'No puedes llevar más de 5 cupones de esta oferta.'], 400);
        }

        $cart[$offerUuid] = $newTotalQuantity;

        session()->put('cart_items', $cart);

        return response()->json(['message' => 'Producto añadido al carrito exitosamente.']);
    }

    private function calculateCartTotals(array $cartItems)
    {
        $totalCents = 0;
        $discountsCents = 0;
        $offerUuids = array_keys($cartItems);

        $offers = Offer::whereIn('offer_uuid', $offerUuids)->get()->keyBy('offer_uuid');

        foreach ($cartItems as $uuid => $quantity) {
            if (isset($offers[$uuid])) {
                $offer = $offers[$uuid];

                $offerPriceInCents = (int) round($offer->offer_price * 100);
                $regularPriceInCents = (int) round($offer->regular_price * 100);

                $totalCents += ($offerPriceInCents * $quantity);

                $discountsCents += ($regularPriceInCents - $offerPriceInCents) * $quantity;
            }
        }
        return [
            'total_cents' => $totalCents,
            'discounts_cents' => $discountsCents,
            'total_items_count' => array_sum($cartItems)
        ];
    }

    public function increaseQuantity(Request $request, $uuid)
    {
        $cart = session()->get('cart_items', []);

        if (!isset($cart[$uuid])) {
            return response()->json(['message' => 'Producto no encontrado en el carrito.'], 404);
        }

        $currentQuantity = $cart[$uuid];
        $newQuantity = $currentQuantity + 1;

        $maxQuantity = 5;
        if ($newQuantity > $maxQuantity) {
            return response()->json(['message' => 'No puedes tener más de ' . $maxQuantity . ' de esta oferta.'], 400);
        }

        $cart[$uuid] = $newQuantity;
        session()->put('cart_items', $cart);

        $totals = $this->calculateCartTotals($cart);

        return response()->json([
            'message' => 'Cantidad aumentada éxitosamente.',
            'new_quantity' => $newQuantity,
            'cart_totals' => $totals
        ]);
    }

    public function decreaseQuantity(Request $request, $uuid)
    {
        $cart = session()->get('cart_items', []);

        if (!isset($cart[$uuid])) {
            return response()->json(['message' => 'Producto no encontrado en el carrito.'], 404);
        }

        $currentQuantity = $cart[$uuid];
        $newQuantity = $currentQuantity - 1;

        if ($newQuantity <= 0) {
            return response()->json(['message' => 'No puedes tener menos de 1 cupón'], 400);
        } else {
            $cart[$uuid] = $newQuantity;
            $message = 'Cantidad disminuida éxitosamente.';
        }

        session()->put('cart_items', $cart);

        $totals = $this->calculateCartTotals($cart);

        return response()->json([
            'message' => $message,
            'new_quantity' => $newQuantity > 0 ? $newQuantity : 0,
            'cart_totals' => $totals,
        ]);
    }

    public function removeProduct(Request $request, $uuid)
    {
        $cart = session()->get('cart_items', []);

        if (!isset($cart[$uuid])) {
            return response()->json(['message' => 'Producto no encontrado en el carrito.'], 404);
        }

        unset($cart[$uuid]);
        session()->put('cart_items', $cart);

        $totals = $this->calculateCartTotals($cart);

        return response()->json([
            'message' => 'Producto eliminado del carrito.',
            'cart_totals' => $totals,
        ]);
    }

    public function cart(Request $request)
    {
        $cartItems = session()->get('cart_items', []);

        $offerUuids = array_keys($cartItems);

        $offers = Offer::whereIn('offer_uuid', $offerUuids)->get()->keyBy('offer_uuid');

        $cartDetails = [];
        $totalCents = 0;
        $discountsCents = 0;
        $totalCoupons = 0;
        foreach ($cartItems as $uuid => $quantity) {
            if (isset($offers[$uuid])) {
                $offer = $offers[$uuid];
                $offerPriceInCents = (int) round($offer->offer_price * 100);
                $regularPriceInCents = (int) round($offer->regular_price * 100);

                $subtotalOfferCents = $offerPriceInCents * $quantity;

                $totalCents += $subtotalOfferCents;
                $singleOfferDiscountCents = $regularPriceInCents - $offerPriceInCents;
                $totalDiscountCentsForOffer = $singleOfferDiscountCents * $quantity;
                $discountsCents += $totalDiscountCentsForOffer;

                $offer->quantity = $quantity;
                $totalCoupons += $quantity;
                $cartDetails[] = $offer;
            }
        }
        return view('costumer.shop-cart', compact('cartDetails', 'totalCents', 'discountsCents', 'totalCoupons'));
    }

    public function pay()
    {
        $cartItems = session()->get('cart_items', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.view')->with('error', 'Tu carrito está vacío.');
        }
        $cartData = $this->calculateCartTotals($cartItems);

        $cartDetails = [];
        $offers = Offer::whereIn('offer_uuid', array_keys($cartItems))->get()->keyBy('offer_uuid');

        foreach ($cartItems as $uuid => $quantity) {
            if (isset($offers[$uuid])) {
                $offer = $offers[$uuid];
                $cartDetails[] = (object)[
                    'quantity' => $quantity,
                    'title' => $offer->title,
                    'price' => $offer->offer_price * $quantity
                ];
            }
        }
        return view('costumer.pay', [
            'cartDetails' => $cartDetails,
            'totalCents' => $cartData['total_cents'],
            'totalCoupons' => $cartData['total_items_count']
        ]);
    }

    public function purchaseHistory()
    {
        $user = Auth::user()->user_uuid;
        $bills = Bill::where('user_uuid', '=', $user)->with('coupons.offers')->get();

        foreach ($bills as $bill) {
            foreach ($bill->coupons as $coupon) {
                $options = new QROptions([
                    'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                    'outputBase64' => true,
                    'scale' => 5,
                    'eccLevel' => QRCode::ECC_L,
                ]);
                $qrcodeGenerator = new QRCode($options);
                $coupon->qr_image_base64 = $qrcodeGenerator->render($coupon->code);
            }
        }

        return view('costumer.purchase-history', compact('bills'));
    }
}
