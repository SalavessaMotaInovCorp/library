<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->orderby('created_at', 'desc')->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cartItems = CartItem::where('user_id', Auth::id())->with('book')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty!');
        }

        $total = 0;
        $bookIds = [];

        foreach ($cartItems as $cartItem) {
            $total += $cartItem->book->price;
            $bookIds[] = $cartItem->book_id;
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'status'  => 'Pending',
            'total'   => $total,
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id'  => $cartItem->book_id,
                'price'    => $cartItem->book->price,
            ]);
        }

        $affectedUsers = CartItem::whereIn('book_id', $bookIds)
            ->where('user_id', '!=', Auth::id())
            ->pluck('user_id')
            ->unique();

        foreach ($affectedUsers as $userId) {
            Notification::create([
                'user_id' => $userId,
                'message' => 'Some books in your cart are no longer available and were removed. Sorry for the inconvenience.',
            ]);
        }

        CartItem::whereIn('book_id', $bookIds)->delete();

        return redirect()->route('orders.index')->with('success', 'Order created successfully!');
    }



    public function proceedToPayment($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->with('orderItems.book')
            ->firstOrFail();

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $lineItems = [];

        foreach ($order->orderItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->book->name,
                    ],
                    'unit_amount' => $item->book->price * 100,
                ],
                'quantity' => 1,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => route('orders.paymentSuccess', ['order' => $order->id]),
            'cancel_url'           => route('orders.index'),
            'shipping_address_collection'     => [
                'allowed_countries' => ['PT','ES', 'FR', 'DE', 'GR', 'IE', 'IT', 'LU', 'NL', 'NO','PL', 'SE', 'CH', 'GB'],
            ],
        ]);

        return redirect($session->url);
    }

    public function paymentSuccess($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update(['status' => 'Completed']);

        foreach ($order->orderItems as $orderItem) {
            $book = Book::find($orderItem->book_id);
            if ($book) {
                $book->update(['in_stock' => false]);
            }
        }

        return redirect()->route('orders.index')->with('success', 'Payment successful! Thank you.');
    }
}
