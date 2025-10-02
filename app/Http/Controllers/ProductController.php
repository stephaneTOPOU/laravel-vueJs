<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index () 
    {
        $products = Product::latest()->get();
        return Inertia::render('products/Index', compact('products'));
    }

    public function create () 
    {
        return Inertia::render('products/Add',[]);
    }

    public function store (Request $request) 
    {
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        Product::create($request->only('name', 'price', 'description'));

        return redirect()->route('products.index')->with('message', 'Produit créé avec succès.');
    }

    public function edit (Product $product) 
    {
        return Inertia::render('products/Edit', compact('product'));
    }

    public function update (Request $request, Product $product) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $product->update($request->only('name', 'price', 'description'));

        return redirect()->route('products.index')->with('message', 'Produit mis à jour avec succès.');
    }

    public function destroy (Product $product) 
    {
        $product->delete();
        return redirect()->route('products.index')->with('message', 'Produit supprimé avec succès.');
    }
}
