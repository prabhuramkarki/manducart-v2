<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Method for form submission (Blade form)
    public function addproduct(Request $req)
    {
        DB::beginTransaction();

        try {
            $admin_id = 1; // Replace with Auth::id() if using authentication

            // Create product category
            $category = ProductCategories::create([
                'product_category' => $req->product_category,
                'product_color' => $req->product_color,
                'product_size' => $req->product_size,
                'created_by' => $admin_id,
            ]);

            // Create product entry
            $product = new Product();
            $product->category_id = $category->category_id;
            $product->product_name = $req->product_name;
            $product->product_details = $req->product_details;
            $product->product_price = (string) $req->product_price;
            $product->product_quantity = (string) $req->product_quantity;
            $product->created_by = $admin_id;
            $product->rating = 0;
            $product->save();

            DB::commit();

            // After adding, go to product list page
            return redirect('/products')->with('success', 'Product added successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error adding product: ' . $e->getMessage());
        }
    }

    // Method for API request (Postman / JSON)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:100',
            'product_details' => 'required|string',
            'product_color' => 'required|string|max:50',
            'product_size' => 'required|string|max:10',
            'product_price' => 'required|numeric|min:0',
            'product_quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $admin_id = 1; // Replace with Auth::id() if needed

            // Create category
            $category = ProductCategories::create([
                'product_category' => $validated['product_category'],
                'product_color' => $validated['product_color'],
                'product_size' => $validated['product_size'],
                'created_by' => $admin_id,
            ]);

            // Create product
            $product = Product::create([
                'category_id' => $category->category_id,
                'product_name' => $validated['product_name'],
                'product_details' => $validated['product_details'],
                'product_quantity' => $validated['product_quantity'],
                'product_price' => $validated['product_price'],
                'created_by' => $admin_id,
                'rating' => 0,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Product added successfully',
                'data' => $product,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error adding product: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Method for showing all products in Blade
    // public function listproduct()
    // {
    //     $products = Product::with('category')->latest()->get();
    //     return view('products', compact('products'));
    // }

    // Method for API - Get all products
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return response()->json([
            'message' => 'Products retrieved successfully',
            'count' => $products->count(),
            'data' => $products,
        ], 200);
    }
}
