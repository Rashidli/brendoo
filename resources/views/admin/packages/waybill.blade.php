<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Накладная - {{ $barcode }}</title>
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            font-style: normal;
            font-weight: normal;
            src: url({{ storage_path('fonts/DejaVuSans.ttf') }}) format('truetype');
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 10px;
        }
        .waybill {
            border: 2px solid #000;
            padding: 15px;
            max-width: 400px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        .barcode {
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 10px 0;
        }
        .section {
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }
        .product-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        .product-table tr:not(:last-child) td {
            border-bottom: 1px dotted #eee;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="waybill">
    <div class="header">
        <h2>ТОВАРНАЯ НАКЛАДНАЯ</h2>
        <div class="barcode">{{ $barcode }}</div>
    </div>

    <div class="section">
        <div class="info-row">
            <span><strong>Дата:</strong> {{ $createdAt }}</span>
            <span><strong>Вес:</strong> {{ $weight ?? '—' }} кг</span>
            <span><strong>Кол-во:</strong> {{ $itemCount }} шт.</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">ПОЛУЧАТЕЛЬ:</div>
        <div>{{ $customerName }}</div>
    </div>

    <div class="section">
        <div class="section-title">ТОВАРЫ:</div>
        <table class="product-table">
            @foreach($productsWithCategories as $item)
                <tr>
                    <td width="60%"><strong>{{ $item['product'] ?? '—' }}</strong></td>
                    <td width="40%">Категория: {{ $item['category'] ?? '—' }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="footer">
        <div class="text-center">Отсканируйте штрих-код для отслеживания</div>
        <div class="text-center">Осторожно, хрупкое!</div>
    </div>
</div>
</body>
</html>
