<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 2rem;
            background-color: #f8f8f8;
            max-width: 1000px;
            margin: auto;
        }

        .main-image {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .thumbnail-gallery {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .thumbnail-gallery img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 6px;
            transition: transform 0.2s;
        }

        .thumbnail-gallery img:hover {
            transform: scale(1.05);
        }

        h1 {
            margin-bottom: 10px;
        }

        .product-info {
            margin-bottom: 30px;
        }

        .back-link {
            display: inline-block;
            margin-top: 30px;
            color: #3498db;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>{{ $product->name }}</h1>

    <div class="product-info">
        <p><strong>Pris:</strong> {{ $product->price }} kr</p>
        <p><strong>Kategori:</strong> {{ $product->category->name }}</p>
    </div>

    @if($product->images->count())
        <img id="mainImage" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="main-image" alt="Produktbild">

        @if($product->images->count() > 1)
            <div class="thumbnail-gallery">
                @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" onclick="changeMainImage(this)">
                @endforeach
            </div>
        @endif
    @else
        <p>Inga produktbilder tillgängliga.</p>
    @endif

    <a href="{{ route('store.index') }}" class="back-link">← Tillbaka till produkter</a>

    <script>
        function changeMainImage(thumbnail) {
            document.getElementById('mainImage').src = thumbnail.src;
        }
    </script>
</body>
</html>
