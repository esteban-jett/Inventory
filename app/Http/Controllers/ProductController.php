<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer',
            'sold' => 'required|integer',
            'status' => 'required|string|max:255',
            'expDate' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048', // Validate the file input
        ]);

        $product = new Product($request->except('image'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return response()->json(['message' => 'Product added successfully', 'product' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer',
            'sold' => 'required|integer',
            'status' => 'required|string|max:255',
            'expDate' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $product->update($validated);

        if ($request->hasFile('image')) {
            // Handle image upload
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
            $product->save();
        }

        return response()->json(['product' => $product], 200);
    }



    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to delete product'], 500);
        }
    }
}
