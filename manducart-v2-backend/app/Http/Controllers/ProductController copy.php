<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategories;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // Add a new product
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:100',
            'product_details' => 'required|string',
            'product_color' => 'required|string|max:50',
            'product_size' => 'required|string|max:10',
            'product_price' => 'required|numeric|min:0',
            'product_quantity' => 'required|integer|min:1',
            'image1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3000',
        ]);

        DB::beginTransaction();

        try {
            $admin_id = 1; // Replace with Auth::id() if needed

            // Create category
            $category = ProductCategories::create([
                'product_category' => $request->product_category,
                'product_color' => $request->product_color,
                'product_size' => $request->product_size,
                'created_by' => $admin_id,
            ]);

            // Create product
            $product = Product::create([
                'category_id' => $category->category_id,
                'product_name' => $request->product_name,
                'product_details' => $request->product_details,
                'product_quantity' => $request->product_quantity,
                'product_price' => $request->product_price,
                'created_by' => $admin_id,
                'rating' => 0,
            ]);

            // Handle image uploads
            for ($i = 1; $i <= 4; $i++) {
                $imageKey = 'image' . $i;
                if ($request->hasFile($imageKey)) {
                    $file = $request->file($imageKey);
                    $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/products', $filename);

                    $column = $i == 1 ? 'product_image' : 'product_image' . $i;
                    $product->$column = 'storage/products/' . $filename;
                }
            }

            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product added successfully.',
                'product_id' => $product->product_id,
                'images' => [
                    'product_image' => $product->product_image,
                    'product_image2' => $product->product_image2,
                    'product_image3' => $product->product_image3,
                    'product_image4' => $product->product_image4,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error adding product: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Fetch all products with categories
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }
}
