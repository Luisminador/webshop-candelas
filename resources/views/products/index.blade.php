<!DOCTYPE html>
<html>
<head>
    <title>Alla produkter</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <h1>Alla produkter</h1>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    <div class="top-actions">
        <a href="{{ route('products.create') }}" class="btn add">➕ Lägg till ny produkt</a>
    </div>

    <div class="category-filter">
        <form method="GET" action="">
            <label for="category">Filtrera efter kategori:</label>
            <select id="category" onchange="location = this.value;">
                <option value="{{ route('products.index') }}">Alla</option>
                @foreach($categories as $category)
                    <option value="{{ route('products.byCategory', $category->id) }}"
                        @if(isset($selectedCategory) && $selectedCategory->id == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    <form method="GET" action="{{ route('products.index') }}" class="search-form">
        <input type="text" name="search" placeholder="Sök efter produkt..." value="{{ request('search') }}">
        <button type="submit">Filtrera</button>
    </form>

    <div class="products">
        @if($products->count() > 0)
            @foreach ($products as $product)
                <div class="product-card">
                @if ($product->images->count() > 0)
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="{{ $product->name }}" class="product-img">
                @else
                    <div class="no-img">Ingen bild</div>
                @endif
                    <h2>{{ $product->name }}</h2>
                    <div class="price">{{ $product->price }} kr</div>
                    <div class="category">{{ $product->category->name }}</div>
                    <div class="actions">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn edit">✏️ Redigera</a>

                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn delete" onclick="return confirm('Är du säker på att du vill ta bort produkten?')">🗑️ Ta bort</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert">
                ❗ Inga produkter hittades.
            </div>
        @endif
    </div>

    <div class="pagination-wrapper">
        {{ $products->links('pagination::bootstrap-4') }}
    </div>
</body>
</html>
