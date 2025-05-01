<!DOCTYPE html>
<html>
<head>
    <title>Redigera produkt</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <h1>Redigera produkt</h1>

    <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="name">Namn:</label><br>
        <input type="text" name="name" id="name" value="{{ $product->name }}" required><br><br>

        <label for="price">Pris:</label><br>
        <input type="number" name="price" id="price" value="{{ $product->price }}" required><br><br>

        <label for="category_id">Kategori:</label><br>
        <select name="category_id" id="category_id" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if ($product->category_id == $category->id) selected @endif>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br><br>

        <label for="image">Bild:</label><br>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="150"><br>
        @endif
        <input type="file" name="image" id="image"><br><br>

        <button type="submit">Uppdatera</button>
    </form>

    <p><a href="{{ route('products.index') }}">← Tillbaka</a></p>
</body>
</html>
