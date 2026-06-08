<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        return view('front.cart.index', [
            'cart' => $this->cart($request)->load('items.product'),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock],
        ]);

        $cart = $this->cart($request);
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = min($product->stock, ($item->quantity ?: 0) + $data['quantity']);
        $item->save();

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($request, $cartItem);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$cartItem->product->stock],
        ]);

        $cartItem->update($data);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->authorizeCartItem($request, $cartItem);
        $cartItem->delete();

        return back()->with('success', 'Item removed.');
    }

    private function cart(Request $request): Cart
    {
        return Cart::firstOrCreate(['user_id' => $request->user()->id]);
    }

    private function authorizeCartItem(Request $request, CartItem $cartItem): void
    {
        abort_unless($cartItem->cart->user_id === $request->user()->id, 403);
    }
}
