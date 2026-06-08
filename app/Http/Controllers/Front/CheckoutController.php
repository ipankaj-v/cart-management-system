<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Request $request): View|RedirectResponse
    {
        $cart = $this->cart($request)->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        return view('front.checkout.show', compact('cart'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:30'],
            'shipping_address' => ['required', 'string'],
            'payment_method' => ['required', 'in:cash_on_delivery'],
        ]);

        $cart = $this->cart($request)->load('items.product');

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Your cart is empty.']);
        }

        try {
            $order = DB::transaction(function () use ($cart, $data, $request) {
                foreach ($cart->items as $item) {
                    if ($item->quantity > $item->product->stock) {
                        throw new \RuntimeException($item->product->name.' does not have enough stock.');
                    }
                }

                $subtotal = $cart->total();
                $order = Order::create([
                    'user_id' => $request->user()->id,
                    'order_number' => 'ORD-'.now()->format('YmdHis').'-'.$request->user()->id,
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'payment_method' => $data['payment_method'],
                    'shipping_name' => $data['shipping_name'],
                    'shipping_phone' => $data['shipping_phone'],
                    'shipping_address' => $data['shipping_address'],
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                ]);

                foreach ($cart->items as $item) {
                    $lineTotal = $item->quantity * $item->product->price;
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'total' => $lineTotal,
                    ]);
                    $item->product->decrement('stock', $item->quantity);
                }

                $cart->items()->delete();

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return back()->withErrors(['cart' => $exception->getMessage()]);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully.');
    }

    private function cart(Request $request): Cart
    {
        return Cart::firstOrCreate(['user_id' => $request->user()->id]);
    }
}
