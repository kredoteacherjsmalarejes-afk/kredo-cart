<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    private $product;

    private $category;

    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    public function index()
    {
        $products = $this->product->with('category')->get();

        return view('admin.products.index')->with('products', $products);
    }

    public function create()
    {
        $categories = $this->category->all();

        return view('admin.products.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $this->product->category_id = $request->category_id;
        $this->product->product_name = $request->product_name;
        $this->product->description = $request->description;
        $this->product->price = $request->price;
        $this->product->stock = $request->stock;
        $this->product->status = 1;

        if ($request->hasFile('image')) {
            $this->product->image = $request
                ->file('image')
                ->store('products', 'public');
        }

        $this->product->save();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = $this->category->all();

        return view('admin.products.edit')->with([
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:1,2',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $product->category_id = $request->category_id;
        $product->product_name = $request->product_name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->save();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function deactivate($id)
    {
        $product = $this->product->findOrFail($id);
        $product->status = 2; // Set status to inactive
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product deactivated successfully.');
    }

    public function activate($id)
    {
        $product = $this->product->findOrFail($id);
        $product->status = 1; // Set status to active
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product activated successfully.');
    }


}
