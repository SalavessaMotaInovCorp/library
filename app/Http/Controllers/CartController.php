<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('book')->get();

        $notifications = Notification::where('user_id', Auth::id())->where('read', false)->get();

        Notification::where('user_id', Auth::id())->where('read', false)->update(['read' => true]);

        return view('cart.index', compact('cartItems', 'notifications'));
    }

    public function addToCart(Request $request)
    {
        $bookId = $request->input('book_id');

        CartItem::create([
                'book_id' => $bookId,
                'user_id' => Auth::id(),
            ]);

        return redirect()->route('cart.index')->with('success', 'Book added to cart successfully!');
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::where('user_id', Auth::id())->where('id', $id)->first();

        if(!$cartItem){
            return redirect()->route('cart.index')->with('error', 'Book not found!');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Book removed from cart successfully!');
    }

}
