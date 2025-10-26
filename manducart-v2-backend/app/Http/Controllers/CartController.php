<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    // Get all cart items for a user
    public function index(Request $request)
    {
        $userId = $request->query('user_id', 1); // Default to user 1 for testing
        $cartItems = Cart::with('product.category')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'message' => 'Cart items retrieved successfully',
            'count' => $cartItems->count(),
            'data' => $cartItems,
        ], 200);
    }

    // Add item to cart
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if item already exists in cart
        $existingCart = Cart::where('user_id', $validated['user_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingCart) {
            // Update quantity if item exists
            $existingCart->quantity += $validated['quantity'];
            $existingCart->save();

            return response()->json([
                'message' => 'Cart item quantity updated',
                'data' => $existingCart->load('product.category'),
            ], 200);
        }

        // Create new cart item
        $cart = Cart::create($validated);

        return response()->json([
            'message' => 'Item added to cart successfully',
            'data' => $cart->load('product.category'),
        ], 201);
    }

    // Update cart item quantity
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($id);
        $cart->update($validated);

        return response()->json([
            'message' => 'Cart item updated successfully',
            'data' => $cart->load('product.category'),
        ], 200);
    }

    // Remove item from cart
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();

        return response()->json([
            'message' => 'Item removed from cart successfully',
        ], 200);
    }

    // Clear all cart items for a user
    public function clear(Request $request)
    {
        $userId = $request->input('user_id');
        
        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'message' => 'Cart cleared successfully',
        ], 200);
    }
}
