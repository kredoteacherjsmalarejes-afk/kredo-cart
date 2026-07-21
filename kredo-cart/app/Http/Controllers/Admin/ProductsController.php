<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 1);

        // Filter by product name if provided
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($productQuery) use ($search) {
                $productQuery
                    ->where('product_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category if provided
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::withCount([
            'products' => function ($productQuery) {
                $productQuery->where('status', '1');
            }
        ])->orderBy('category_name')->get();

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Do not display discontinued products to general users
        abort_if($product->status !== '1', 404);

        $product->load('category');

        $relatedProducts = Product::with('category')
            ->where('status', '1')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();

        return view('products.show', compact(
            'product',
            'relatedProducts'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
