<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
</head>
<body>
    <h1>✅ Slutför beställning</h1>

    @if(count($cart) === 0)
        <p>Din varukorg är tom. <a href="{{ route('store.index') }}">Tillbaka till butiken</a></p>
    @else
        <form method="POST" action="{{ route('checkout.process') }}">
            @csrf

            <div class="form-group">
                <label for="name">Namn:</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">E-post:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="address">Adress:</label>
                <textarea name="address" required></textarea>
            </div>

            <h3>🧾 Orderöversikt:</h3>
            <ul class="checkout-summary">
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $total += $item['price'] * $item['quantity']; @endphp
                    <li>
                        {{ $item['name'] }} × {{ $item['quantity'] }} – {{ $item['price'] * $item['quantity'] }} kr
                    </li>
                @endforeach
            </ul>

            <div class="checkout-total">
                <strong>Totalt:</strong> {{ $total }} kr
            </div>

            <button type="submit" class="btn add-to-cart">Skicka beställning</button>
        </form>
    @endif
</body>
</html>
