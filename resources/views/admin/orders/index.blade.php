<!DOCTYPE html>
<html>
<head>
    <title>Ordrar - Adminpanel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <h1>📦 Inkomna ordrar</h1>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <p style="text-align: center;">Det finns inga ordrar än.</p>
    @else
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Namn</th>
                    <th>E-post</th>
                    <th>Adress</th>
                    <th>Beställda produkter</th>
                    <th>Skapad</th>
                    <th>Ta bort</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->address }}</td>
                        <td>
                            <ul class="order-items">
                                @foreach($order->products as $product)
                                    <li>
                                        {{ $product->name }} × {{ $product->pivot->quantity }} –
                                        {{ $product->price * $product->pivot->quantity }} kr
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Är du säker på att du vill ta bort denna order?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn delete">Ta bort</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p><a href="{{ route('dashboard') }}" class="back-link">← Till dashboard</a></p>
</body>
</html>
