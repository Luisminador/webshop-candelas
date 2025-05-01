<!DOCTYPE html>
<html>
<head>
    <title>Skapa ny produkt</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Ny produkt</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <label for="name">Namn:</label><br>
        <input type="text" name="name" id="name" required><br><br>

        <label for="price">Pris:</label><br>
        <input type="number" name="price" id="price" required><br><br>

        <label for="category_id">Kategori:</label><br>
        <select name="category_id" id="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select><br><br>

        <label for="images">Produktbilder:</label><br>
        <input type="file" name="images[]" id="images" accept="image/*" multiple><br><br>

        <div id="imagePreviewContainer" style="display: flex; gap: 10px; flex-wrap: wrap;"></div>

        <br><br>

        <button type="submit">Spara produkt</button>
    </form>

    <p><a href="{{ route('products.index') }}">← Tillbaka till produkter</a></p>

    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const container = document.getElementById('imagePreviewContainer');
            container.innerHTML = ''; // Rensa gamla previews

            Array.from(e.target.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.style.maxWidth = '150px';
                    img.style.maxHeight = '150px';
                    img.style.borderRadius = '8px';
                    img.style.objectFit = 'cover';
                    container.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>
</html>
