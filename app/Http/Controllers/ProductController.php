<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(3)->withQueryString();
        $categories = Category::all();
        $selectedCategory = $request->filled('category') ? Category::find($request->category) : null;

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'category_id']);

        // Om minst en bild finns, spara första som huvudbild
        if ($request->hasFile('images') && count($request->file('images')) > 0) {
            $firstImage = $request->file('images')[0];
            $data['image'] = $firstImage->store('products', 'public');
        }

        $product = Product::create($data);

        // Spara alla bilder i product_images-tabellen
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('products', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Produkten har sparats!');
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        return view('products.show', compact('product'));
    }
    

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
    
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Produkten har uppdaterats!');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produkten har raderats!');
    }

    public function filterByCategory($id)
    {
        $products = Product::with('category')->where('category_id', $id)->paginate(16); // Här fixad
        $categories = Category::all();
        $selectedCategory = Category::findOrFail($id);

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }
}
