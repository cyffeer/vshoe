<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('shoe')->where('user_id', Auth::id())->get();
        return Inertia::render('Shoes/Cart', ['cartItems' => $cartItems]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shoe_id' => 'required|exists:shoes,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'shoe_id' => $request->shoe_id],
            ['quantity' => $request->quantity]
        );

        return redirect()->back()->with('success', 'Shoe added to cart successfully!');
    }

    public function destroy($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cartItem->delete();

        return redirect()->back()->with('success', 'Shoe removed from cart successfully!');
    }
}