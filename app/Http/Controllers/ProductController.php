<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Show all products

    public function rolePermission($role){
        if (!in_array($role, ['manager', 'admin'])) {
            abort(403, 'Access Denied');
        }
   }
    public function index()
    {   
        $this->rolePermission(Auth::user()->role);
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Show the form to create a new product
    public function create()
    {
        $this->rolePermission(Auth::user()->role);
        return view('admin.products.create');
    }

    // Store a new product
    public function store(Request $request)
    {
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'Qnty' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    // Show the form to edit an existing product
    public function edit($id)
    {
        $this->rolePermission(Auth::user()->role);
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // Update an existing product
    public function update(Request $request, $id)
    {
        $this->rolePermission(Auth::user()->role);
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'Qnty' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}
