@extends('costumer.app')

@section('content')
    <div class="min-h-[61vh] py-20 flex justify-center">
        <div class="w-[70%] relative flex flex-col">
            <a href="{{ url('/') }}" class="absolute top-0 -left-20 hover:cursor-pointer">
                <span class="material-symbols-outlined !text-3xl">
                    arrow_back
                </span>
            </a>
            <h2 class="font-bold text-3xl">Historial de compras</h2>
            <div class="grid grid-cols-[45%_55%] gap-x-5">
                <div>
                    @forelse ($bills as $bill)
                        <div data-items="{{ json_encode($bill->coupons) }}" onclick="setDetail(this)"
                            class="grid grid-cols-2 gap-y-2 my-3 border border-slate-400 rounded-md p-4 hover:cursor-pointer">
                            <div class="col-span-2 -mt-4 -mx-4 bg-slate-600 text-white px-4 py-3">
                                <h6 class="text-lg">Orden <span class="font-bold"># {{ $bill->bill_uuid }}</span></h6>
                            </div>

                            <span>Cantidad de cupones: <strong>{{ $bill->amount }}</strong></span>
                            <span>Total: <strong>${{ $bill->total }}</strong></span>
                            <hr class="col-span-2 text-slate-400">
                            <span class="col-span-2">Orden realizada {{ $bill->created_at }}</span>
                        </div>
                    @empty
                        <p class="text-xl font-bold">No has realizado compras</p>
                    @endforelse
                </div>
                <div id="detail-list" class="grid gap-y-2">
                    <span class="font-semibold text-lg w-full text-center">Seleccionar una compra para mostrar el detalle</span>
                </div>
            </div>
        </div>
    </div>
    <script>
        const list = document.getElementById('detail-list');

        const setDetail = (couponArray) => {
            list.innerHTML = '';
            const mainDiv = document.createElement('div');
            mainDiv.classList.add('grid', 'gap-y-2');

            const data = JSON.parse(couponArray.getAttribute('data-items'));
            data.forEach((coupon) => {
                const containerDiv = document.createElement('div')
                containerDiv.classList.add('grid', 'grid-cols-[40%_60%]', 'grid-rows-[repeat(3,auto)]',
                    'border', 'border-slate-400', 'h-[200px]', 'rounded-md', 'overflow-hidden', 'max-h-max');
                // QR image
                const qrImage = document.createElement('img');
                qrImage.src = coupon.qr_image_base64;
                qrImage.classList.add('row-span-3')
                containerDiv.appendChild(qrImage);

                // Coupon data
                const title = document.createElement('h6');
                title.textContent = coupon.offers[0].title;
                title.classList.add('text-xl', 'font-semibold', 'mt-3');
                containerDiv.appendChild(title);

                const description = document.createElement('p');
                description.textContent = coupon.offers[0].description;
                description.classList.add('line-clamp-3')
                containerDiv.appendChild(description);

                const price = document.createElement('span');
                price.textContent = `$${(coupon.cost/100).toFixed(2)}`;
                price.classList.add('font-medium', 'col-start-2', 'text-lg')
                containerDiv.appendChild(price)


                mainDiv.appendChild(containerDiv);
            });
            list.appendChild(mainDiv);
        }
    </script>
@endsection
