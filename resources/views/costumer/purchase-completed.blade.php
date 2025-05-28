@extends('costumer.app')

@section('content')
    <div class="grid grid-cols-2 min-h-[61vh] py-20 gap-y-5 w-2/5 mx-[30%]">
        <span class="material-symbols-outlined !text-[102px] text-blue-600 col-span-2 text-center">
            task_alt
        </span>
        <h1 class="font-bold text-5xl col-span-2 text-center">Gracias por tu compra</h1>
        <p class="font-medium col-span-2 text-center">Tu compra ha sido procesada correctamente, puedes descargar tu factura junto con
            tus códigos acá, o revisarlos en
            el
            historial de compras.</p>
        <a id="download-button"
            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out max-w-max max-h-max flex justify-center items-center place-self-center hover:cursor-pointer">
            Descargar factura
        </a>
        <a href="{{ url('/') }}"
            class="bg-gray-600 text-white hover:bg-gray-700 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out max-w-max flex justify-center items-center place-self-center hover:cursor-pointer">
            Volver al inicio
        </a>
    </div>

    <script>
        document.getElementById('download-button').addEventListener('click', function() {
            const billUuid = @json(session('bill'));

            if (billUuid) {
                const pdfUrl = "{{ route('bill.download', ['billUuid' => 'REPLACE_UUID']) }}".replace(
                    'REPLACE_UUID', billUuid);

                const link = document.createElement('a');
                link.href = pdfUrl;
                link.download = `factura-${billUuid}.pdf`;

                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                console.error('UUID de factura no encontrado para la descarga.');
            }
        });
    </script>
@endsection
