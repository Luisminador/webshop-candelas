<!DOCTYPE html>
<html>
<head>
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .main-image {
            width: 400px;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
            cursor: pointer;
        }

        .thumbnail-gallery {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .thumbnail-gallery img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 6px;
            transition: transform 0.2s;
        }

        .thumbnail-gallery img:hover {
            transform: scale(1.05);
        }

        #lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        #lightbox img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }

        #prevBtn, #nextBtn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2rem;
            color: white;
            background: none;
            border: none;
            cursor: pointer;
            z-index: 10000;
        }

        #prevBtn { left: 20px; }
        #nextBtn { right: 20px; }
    </style>
</head>
<body>
    <h1>{{ $product->name }}</h1>

    <p><strong>Pris:</strong> {{ $product->price }} kr</p>
    <p><strong>Kategori:</strong> {{ $product->category->name }}</p>

    <div>
        @if($product->images->count())
            <div>
                {{-- Huvudbild --}}
                <img id="mainImage" src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="main-image" alt="Huvudbild">
            </div>

            {{-- Miniatyrbilder --}}
            @if($product->images->count() > 1)
                <div class="thumbnail-gallery">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" onclick="changeMainImage(this)">
                    @endforeach
                </div>
            @endif
        @else
            <p>Inga bilder uppladdade.</p>
        @endif
    </div>

    <p style="margin-top: 30px;">
        <a href="{{ route('products.index') }}">← Tillbaka till produkter</a>
    </p>

    <!-- Lightbox HTML -->
    <div id="lightbox">
        <button id="prevBtn">←</button>
        <img id="lightboxImage" src="">
        <button id="nextBtn">→</button>
    </div>

    <script>
        const thumbnails = Array.from(document.querySelectorAll('.thumbnail-gallery img'));
        const mainImage = document.getElementById('mainImage');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        function changeMainImage(thumbnail) {
            mainImage.src = thumbnail.src;
        }

        mainImage.addEventListener('click', function () {
            currentIndex = thumbnails.findIndex(img => img.src === mainImage.src);
            lightboxImage.src = mainImage.src;
            lightbox.style.display = 'flex';
        });

        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) {
                lightbox.style.display = 'none';
            }
        });

        prevBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            currentIndex = (currentIndex - 1 + thumbnails.length) % thumbnails.length;
            updateLightboxImage();
        });

        nextBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            currentIndex = (currentIndex + 1) % thumbnails.length;
            updateLightboxImage();
        });

        function updateLightboxImage() {
            lightboxImage.src = thumbnails[currentIndex].src;
        }
    </script>
</body>
</html>
