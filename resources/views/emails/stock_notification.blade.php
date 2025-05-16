<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Stok Bildirişi</title>
</head>
<body>
<h2>Salam, {{ $customer->name }}!</h2>

<p>
    Artıq <strong>{{ $product->title }}</strong> məhsulunun
    <strong>{{ $option->filter->title }}: {{ $option->title }}</strong> seçimi stokdadır.
</p>

<p>Sifariş vermək üçün veb saytımıza daxil olun.</p>

<p>Əgər sualınız varsa, bizimlə əlaqə saxlaya bilərsiniz.</p>

<br>
<p>Hörmətlə,<br>Brendoo komandası</p>
</body>
</html>
