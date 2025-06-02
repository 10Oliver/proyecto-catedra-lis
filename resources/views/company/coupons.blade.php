@extends('company.app')

@section('content')
    @if (session('message') && session('state'))
        <div id="flash-message"
            class="flex py-3 px-5 fixed top-5 right-3 z-50 text-white transition-opacity duration-500 {{ session('state') ? 'bg-green-800' : 'bg-red-800' }}">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-2 gap-y-5">
        <h2 class="text-3xl font-bold text-gray-100 mb-6">Administración de cupones</h2>
        <a id="create-button"
            class="px-3 py-1 bg-[#155dfc] text-white max-w-max h-[40px] rounded-md flex items-center justify-self-end font-medium hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6">
                <title>plus</title>
                <path class="fill-white" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
            </svg>
            Crear cupón
        </a>

        <table class="col-span-2 border-gray-700 border">
            <thead class="bg-gray-800 border-gray-700 border-b">
                <tr class="font-medium text-white">
                    <td class="p-4">Nombre</td>
                    <td class="p-4">Precio oferta</td>
                    <td class="p-4">Cantidad ofertada</td>
                    <td class="p-4">Cantidad vendidos</td>
                    <td class="p-4">Estado</td>
                    <td class="p-4">Días restantes</td>
                    <td class="p-4">Acciones</td>
                </tr>
            </thead>
            <tbody class="bg-gray-900 divide-gray-700 text-white">
                @forelse ($offers as $offer)
                <tr>
                    <td class="p-4">
                        {{ $offer->title }}
                    </td>
                    <td class="p-4">
                        ${{ $offer->offer_price }}
                    </td>
                    <td class="p-4">
                        {{ $offer->amount ?? 'Ilimitados' }}
                    </td>
                    <td class="p-4">
                        {{ $offer->purchased_coupons_count }}
                    </td>
                    <td class="p-4">
                        {{ $offer->state ? 'Activo' : 'Inactivo' }}
                    </td>
                    <td class="p-4">
                        {{ $offer->days_left }}
                    </td>
                    <td class="p-4">
                        <div class="flex gap-x-3">
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6">
                                    <title>pencil-box-outline</title>
                                    <path class="fill-white"
                                        d="M19,19V5H5V19H19M19,3A2,2 0 0,1 21,5V19C21,20.11 20.1,21 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3H19M16.7,9.35L15.7,10.35L13.65,8.3L14.65,7.3C14.86,7.08 15.21,7.08 15.42,7.3L16.7,8.58C16.92,8.79 16.92,9.14 16.7,9.35M7,14.94L13.06,8.88L15.12,10.94L9.06,17H7V14.94Z" />
                                </svg>
                            </a>
                            <a href="">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6">
                                    <title>delete</title>
                                    <path class="fill-white"
                                        d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay oferas registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        @php
            $modalVisible = $errors->any() ? 'opacity-100' : 'opacity-0 pointer-events-none';
        @endphp
        <div class="fixed w-screen h-screen z-50 top-0 left-0 right-0 bottom-0 bg-gray-900/30 backdrop-blur-[2px] flex justify-center items-center  transition-opacity duration-300 {{ $modalVisible }}"
            role="dialog" aria-modal="true" aria-hidden="{{ $errors->any() ? 'false' : 'true' }}" id="create-modal">
            <form action="{{ route('coupon.save.request') }}" method="POST"
                class="grid grid-cols-2 bg-gray-800 p-6 rounded-xl w-[450px] gap-4 overflow-y-auto max-h-[90vh]">
                @csrf
                <h6 class="font-bold text-white text-xl">Nuevo cupón</h6>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 justify-self-end"
                    onclick="closeCreateModal()">
                    <title>close</title>
                    <path class="fill-gray-300"
                        d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" />
                </svg>

                <div class="relative col-span-2">
                    <label for="title" class="text-gray-300 font-medium text-sm block mb-2">Nombre del cupón</label>
                    <input type="text" name="title" id="title" placeholder="Example name"
                        value="{{ old('title') }}"
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white">
                    @error('title')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative col-span-2">
                    <label for="regular_price" class="text-gray-300 font-medium text-sm block mb-2">Precio regular</label>
                    <input type="text" name="regular_price" id="regular_price" placeholder="$0.00"
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white">
                    @error('regular_price')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative col-span-2">
                    <label for="offer_price" class="text-gray-300 font-medium text-sm block mb-2">Precio en oferta</label>
                    <input type="text" name="offer_price" id="offer_price" placeholder="$0.00"
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white">
                    @error('offer_price')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative">
                    <label for="start_date" class="text-gray-300 font-medium text-sm block mb-2">Fecha de inicio</label>
                    <input type="date" name="start_date" id="start_date" placeholder=""
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white">
                    @error('start_date')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative">
                    <label for="end_date" class="text-gray-300 font-medium text-sm block mb-2">Fecha de fin</label>
                    <input type="date" name="end_date" id="end_date" placeholder=""
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white">
                    @error('end_date')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="relative col-span-2">
                    <label for="description" class="text-gray-300 font-medium text-sm block mb-2">Descripción</label>
                    <textarea type="description" name="description" id="description" placeholder=""
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white resize-none">
                    </textarea>
                    @error('description')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="relative">
                    <label for="open-amount" class="text-gray-300 font-medium text-sm block mb-2">
                        ¿Cupones
                        ilimitados?</label>
                    <div class="max-w-max relative group">
                        <input type="hidden" name="open_amount" value="0">
                        <input type="checkbox" name="open_amount" id="open_amount" value="1"
                            {{ old('open_amount') ? 'checked' : '' }}
                            class="absolute top-0 right-0 left-0 bottom-0 z-10 peer opacity-0">
                        <div
                            class="w-[100px] max-w-[90px] rounded-2xl bg-gray-700 peer-checked:bg-slate-500 h-8 flex items-center px-0.5 py-0.5 transition-all duration-500 ease-in-out">
                        </div>
                        <div
                            class="h-[28px] w-[28px] rounded-full bg-gray-900 peer-checked:bg-slate-800 absolute top-1/2 -translate-y-1/2 left-0.5 peer-checked:left-[calc(100%-30px)] transition-all duration-500 ease-in-out">
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <label for="amount" class="text-gray-300 font-medium text-sm block mb-2">Cantidad</label>
                    <input type="text" name="amount" id="amount" placeholder=""
                        class="w-full p-3 border rounded-lg bg-gray-700 border-gray-600 ring-0 outline-none text-white">
                    @error('amount')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                    <span id="unlimited-text" class="text-md font-bold text-gray-200 hidden">Cupones ilimitados</span>
                </div>
                <div class="relative">
                    <label for="state" class="text-gray-300 font-medium text-sm block mb-2">Estado</label>
                    <div class="max-w-max relative group">
                        <input type="hidden" name="state" value="0">
                        <input type="checkbox" name="state" id="state" value="1"
                            {{ old('state') ? 'checked' : '' }}
                            class="absolute top-0 right-0 left-0 bottom-0 z-10 peer opacity-0">
                        <div
                            class="w-[100px] max-w-[90px] rounded-2xl bg-gray-700 peer-checked:bg-slate-500 h-8 flex items-center px-0.5 py-0.5 transition-all duration-500 ease-in-out">
                        </div>
                        <div
                            class="h-[28px] w-[28px] rounded-full bg-gray-900 peer-checked:bg-slate-800 absolute top-1/2 -translate-y-1/2 left-0.5 peer-checked:left-[calc(100%-30px)] transition-all duration-500 ease-in-out">
                        </div>
                    </div>
                </div>
                <hr class="col-span-2 opacity-0">
                <a class="bg-gray-700 text-white py-2 hover:cursor-pointer hover:bg-gray-600 rounded-lg text-center"
                    onclick="closeCreateModal()">Cancelar</a>
                <button type="submit"
                    class="py-2 bg-blue-600 text-white hover:bg-blue-500 rounded-lg hover:cursor-pointer">Crear</button>
            </form>
        </div>

        <script>
            const quantityInput = document.getElementById("amount");
            const unlimitedCoupons = document.getElementById("open_amount");
            const unlimitedText = document.getElementById("unlimited-text");
            const createModal = document.getElementById("create-modal");
            const createButton = document.getElementById("create-button");

            unlimitedCoupons.addEventListener('change', () => {
                if (unlimitedCoupons.checked) {
                    quantityInput.classList.add('hidden');
                    unlimitedText.classList.remove('hidden');
                } else {
                    quantityInput.classList.remove('hidden');
                    unlimitedText.classList.add('hidden');
                }
            });

            createButton.addEventListener("click", () => {
                createModal.classList.remove('opacity-0', 'pointer-events-none');
                createModal.classList.add('opacity-100');
                createModal.setAttribute('aria-hidden', 'false');
            });

            const closeCreateModal = () => {
                createModal.classList.remove('opacity-100');
                createModal.classList.add('opacity-0', 'pointer-events-none');

                setTimeout(() => {
                    createModal.setAttribute('aria-hidden', 'true');
                }, 300);
            }

            document.addEventListener('DOMContentLoaded', () => {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    setTimeout(() => {
                        flash.style.opacity = '0';
                        setTimeout(() => flash.remove(), 500);
                    }, 3000);
                }
            });
        </script>
    </div>
@endsection
