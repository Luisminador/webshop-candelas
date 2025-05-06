<!DOCTYPE html>
<html>
<head>
    <title>Våra produkter</title>
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body>
    <h1>Våra produkter</h1>

    <div class="product-grid">
        @foreach($products as $product)
            <div class="product-card">
                @if($product->images->first())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="product-img" alt="{{ $product->name }}">
                @else
                    <div class="product-img" style="background-color:#ddd; display:flex; align-items:center; justify-content:center; color:#666; font-style:italic;">Ingen bild</div>
                @endif
                <div class="product-name">{{ $product->name }}</div>
                <div class="product-price">{{ $product->price }} kr</div>
                <div class="product-category">{{ $product->category->name }}</div>
                <a href="{{ route('store.show', $product->id) }}" class="view-button">Visa produkt</a>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 30px; text-align: center;">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</body>
</html>
