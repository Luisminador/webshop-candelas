<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('store.index')->with('error', 'Din varukorg är tom.');
        }

        // Skapa order
        $order = Order::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // Skapa orderrader
        foreach ($cart as $item) {
            $order->items()->create([
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('store.index')->with('success', 'Tack! Din beställning är mottagen.');
    }
}
