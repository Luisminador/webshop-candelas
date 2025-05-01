<!DOCTYPE html>
<html>
<head>
    <title>Våra produkter</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            padding: 2rem;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .product-card {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s ease;
        }
        .product-card:hover {
            transform: scale(1.02);
        }
        .product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .product-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-price {
            color: #27ae60;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .product-category {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 10px;
        }
        .view-button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .view-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center; margin-bottom: 2rem;">Våra produkter</h1>

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
