<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        return view('cart.index', [
            'items' => $user->items()->orderBy('created_at')->get()
        ]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|uuid|exists:items,id'
        ]);

        $user = auth()->user();
        $item = Item::find($request->item_id);

        // Check if the item is already in the user's cart...
        if ($user->items()->where('item_id', $item->id)->exists()) {
            return response()->json(['message' => 'Item is already in the cart.'], 400);
        }

        $user->items()->attach($item);

        return back()->with('success', 'Item added to the cart!');
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'item_id' => 'required|uuid|exists:items,id'
        ]);

        $user = auth()->user();
        $item = Item::find($request->item_id);

        // Check if the item is in the user's cart...
        if (!$user->items()->where('item_id', $item->id)->exists()) {
            return response()->json(['message' => 'Item is not in the cart.'], 400);
        }

        $user->items()->detach($item);
        return back()->with('success', 'Item removed from the cart!');
    }

    public function clearCart()
    {
        $user = auth()->user();
        $user->items()->detach();
        return back()->with('success', 'Cart cleared!');
    }
}
