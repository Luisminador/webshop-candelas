<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body class="store-show">
    <h1>{{ $product->name }}</h1>

    <div class="product-info">
        <p><strong>Pris:</strong> {{ $product->price }} kr</p>
        <p><strong>Kategori:</strong> {{ $product->category->name }}</p>
    </div>

    <form method="POST" action="{{ route('cart.add', $product->id) }}">
        @csrf
        <button type="submit" class="btn add-to-cart">
            🛒 Lägg till i varukorg
        </button>
    </form>

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
