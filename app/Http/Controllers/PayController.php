<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardEntryRequest;
use App\Models\Bill;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\OfferCoupon;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{
    private function calculateCartTotals(array $cartItems)
    {
        $totalCents = 0;
        $totalItemsCount = 0; // Este será el 'amount' de tu Bill
        $offerUuids = array_keys($cartItems);

        $offers = Offer::whereIn('offer_uuid', $offerUuids)->get()->keyBy('offer_uuid');

        foreach ($cartItems as $uuid => $quantity) {
            if (isset($offers[$uuid])) {
                $offer = $offers[$uuid];
                $offerPriceInCents = (int) round($offer->offer_price * 100);

                $totalCents += ($offerPriceInCents * $quantity);
                $totalItemsCount += $quantity;
            }
        }

        return [
            'total_cents' => $totalCents,
            'total_items_count' => $totalItemsCount,
            'offers_data' => $offers
        ];
    }

    public function payCoupons(CardEntryRequest $request)
    {
        $request->validated();

        $cartItems = session()->get('cart_items', []);

        if (empty($cartItems)) {
            return response()->json(['message' => 'Tu carrito está vacío. No se puede completar la compra.'], 400);
        }

        $cartData = $this->calculateCartTotals($cartItems);
        $totalCents = $cartData['total_cents'];
        $totalItemsCount = $cartData['total_items_count'];
        $offersData = $cartData['offers_data'];

        DB::beginTransaction();

        try {
            $bill = Bill::create([
                'user_uuid' => Auth::check() ? Auth::user()->user_uuid : null,
                'total' => $totalCents / 100,
                'amount' => $totalItemsCount,
            ]);

            $generatedCouponsDetails = [];

            $options = new QROptions([
                'outputType' => QRCode::OUTPUT_IMAGE_PNG,
                'outputBase64' => true,
                'scale' => 5,
                'eccLevel' => QRCode::ECC_L
            ]);

            $qrcodeGenerator = new QRCode($options);

            foreach ($cartItems as $offerUuid => $quantity) {
                $offer = $offersData[$offerUuid];
                $couponCost = (int) round($offer->offer_price * 100);

                for ($i = 0; $i < $quantity; $i++) {
                    $coupon = Coupon::create([
                        'cost' => $couponCost,
                        'bill_uuid' => $bill->bill_uuid,
                    ]);

                    OfferCoupon::create([
                        'offer_uuid' => $offerUuid,
                        'coupon_uuid' => $coupon->coupon_uuid
                    ]);

                    $qrImageBase64WithPrefix = $qrcodeGenerator->render($coupon->code);

                    $generatedCouponsDetails[] = [
                        'coupon_uuid' => $coupon->coupon_uuid,
                        'coupon_code' => $coupon->code,
                        'offer_title' => $offer->title,
                        'cost_paid_cents' => $coupon->cost,
                        'qr_image_base64' => $qrImageBase64WithPrefix,
                    ];
                 }
            }
            DB::commit();
            session()->forget('cart_items');

            return response()->json([
                'message' => 'Compra completada exitosamente. Aquí están tus cupones.',
                'bill_uuid' => $bill->bill_uuid,
                'total_paid_cents' => $totalCents,
                'total_coupons_bought' => $totalItemsCount,
                'coupons' => $generatedCouponsDetails,
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al procesar la compra. Por favor, inténtalo de nuevo.', 'error_details' => $e->getMessage()], 500);
        }
    }
}
