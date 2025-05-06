<!DOCTYPE html>
<html>
<head>
    <title>Din varukorg</title>
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body>
    <h1>🛒 Din varukorg</h1>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) === 0)
        <p class="empty-cart-message">Din varukorg är tom.</p>
    @else
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Bild</th>
                    <th>Produkt</th>
                    <th>Pris</th>
                    <th>Antal</th>
                    <th>Ta bort</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <tr>
                        <td>
                            @if($item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="Produktbild" class="cart-img">
                            @else
                                <div class="no-cart-img">Ingen bild</div>
                            @endif
                        </td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price'] }} kr</td>
                        <td>
                            <form method="POST" action="{{ route('cart.update', $id) }}" class="quantity-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" name="action" value="decrease" class="qty-btn">−</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-input">
                                <button type="submit" name="action" value="increase" class="qty-btn">＋</button>
                            </form>
                        </td>

                        <td>
                            <form method="POST" action="{{ route('cart.remove', $id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="remove-btn" onclick="return confirm('Ta bort denna produkt?')">❌</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <strong>Totalt:</strong> {{ $total }} kr
        </div>

        <div class="checkout-btn-wrapper">
            <a href="{{ route('checkout.index') }}" class="btn checkout-btn">Gå till kassan</a>
        </div>
    @endif

    <a href="{{ route('store.index') }}" class="back-link">← Fortsätt handla</a>
</body>
</html>
