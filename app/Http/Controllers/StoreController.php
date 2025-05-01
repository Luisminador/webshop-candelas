<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StoreController extends Controller
{
    // Visa alla produkter i kundvyn med pagination
    public function index(Request $request)
    {
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(12)
            ->withQueryString(); // Bevara query-parametrar vid paginering

        return view('store.index', compact('products'));
    }

    // Visa enskild produktsida i kundvyn
    public function show(Product $product)
    {
        $product->load(['category', 'images']);
        return view('store.show', compact('product'));
    }
}
