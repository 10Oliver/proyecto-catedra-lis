<!DOCTYPE html>
<html>
<head>
    <title>Factura de Compra - {{ $bill->bill_uuid }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #f9fafb;
            color: #1f2937;
        }
        .container {
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
            background-color: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 32px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        .header h2 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin: 0;
            margin-bottom: 8px;
        }
        .header p {
            color: #4b5563;
            margin: 0;
            line-height: 1.5;
        }
        .header span {
            font-weight: 600;
            color: #2563eb;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .details-table th, .details-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }
        .details-table th {
            background-color: #f3f4f6;
            font-weight: 600;
        }
        .details-table tr:last-child th, .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-table .text-right {
            text-align: right;
        }
        .details-table .text-lg {
            font-size: 18px;
        }
        .details-table .font-bold {
            font-weight: bold;
            color: #111827;
        }

        .coupon-section {
            background-color: #f9fafb;
            padding: 24px;
            margin-bottom: 24px;
            margin-top: 24px;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .coupon-grid-container:after {
            content: "";
            display: table;
            clear: both;
        }

        .coupon-left-column {
            float: left;
            width: 65%;
            box-sizing: border-box;
            padding-right: 20px;
        }

        .coupon-right-column {
            float: right;
            width: 35%;
            text-align: center;
            box-sizing: border-box;
            padding-top: 20px;
            height: auto;
        }

        .coupon-title-row {
            text-align: left;
            margin-bottom: 10px;
        }
        .coupon-title-row h4 {
            margin-top: 0;
            margin-bottom: 0;
        }

        .coupon-table th {
            width: 30%;
            white-space: nowrap;
        }
        .coupon-table td {
            width: 70%;
        }

        .coupon-table {
            width: 100%;
        }


        .qr-code-img {
            display: inline-block;
            width: 120px;
            height: 120px;
            padding: 8px;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            margin-top: -15px;
        }
        .text-center {
            text-align: center;
        }
        .text-red-500 {
            color: #ef4444;
        }
        .font-medium {
            font-weight: 500;
        }

        .footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .footer p {
            margin-bottom: 4px;
            margin-top: 0;
        }

        h3 {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Detalle de Compra y Cupones</h2>
            <p><strong>Factura #:</strong> <span class="font-semibold">{{ $bill->bill_uuid }}</span></p>
            <p><strong>Fecha de Compra:</strong> {{ $bill->created_at->format('d/m/Y H:i:s') }}</p>
        </div>

        <div class="mb-8">
            <table class="details-table">
                <tbody>
                    <tr>
                        <th>Total Pagado:</th>
                        <td class="text-right text-lg font-bold">${{ number_format($bill->total, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Cantidad Total de Cupones:</th>
                        <td class="text-right text-lg font-bold">{{ $bill->amount }}</td>
                    </tr>
                    @if ($bill->user_uuid)
                    <tr>
                        <th>Usuario:</th>
                        <td class="text-right">{{ auth()->user()->names }} {{ auth()->user()->surnames }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <h3>Cupones Adquiridos:</h3>
        @foreach ($bill->coupons as $coupon)
            <div class="coupon-section">
                <div class="coupon-grid-container">
                    <div class="coupon-left-column">
                        <div class="coupon-title-row">
                            <h4>Cupón #{{ $loop->iteration }}</h4>
                        </div>
                        <div class="coupon-table-row">
                            <table class="details-table coupon-table">
                                <tbody>
                                    <tr>
                                        <th>Oferta:</th>
                                        <td class="text-right">{{ $coupon->offers->first()->title ?? 'Oferta no disponible' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Costo por Cupón:</th>
                                        <td class="text-right">${{ number_format($coupon->cost / 100, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="coupon-right-column">
                        @if ($coupon->qr_image_base64)
                            <img src="{{ $coupon->qr_image_base64 }}" class="qr-code-img" alt="QR Code for {{ $coupon->code }}">
                        @else
                            <p class="text-center text-red-500 font-medium">Código QR no disponible.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        <div class="footer">
            <p class="mb-1">¡Gracias por tu compra!</p>
            <p>Este documento es tu comprobante de compra y detalle de cupones.</p>
            <p>Generado por tu aplicación el {{ now()->format('d/m/Y H:i:s') }}.</p>
        </div>
    </div>
</body>
</html>
