<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
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

    public function store(Request $request, Product $product): RedirectResponse|JsonResponse
    {
        abort_unless($product->is_active, 404);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$product->stock],
        ]);

        $cart = $this->cart($request);
        // Add cart flow: find the customer's current cart item for this product,
        // then increase quantity instead of creating duplicate product rows.
        $item = $cart->items()->firstOrNew(['product_id' => $product->id]);
        $item->quantity = min($product->stock, ($item->quantity ?: 0) + $data['quantity']);
        $item->save();

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload($cart->fresh('items.product'), 'Product added to cart.'));
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse|JsonResponse
    {
        $this->authorizeCartItem($request, $cartItem);

        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$cartItem->product->stock],
        ]);

        // Update quantity flow: customer can change only their own cart item;
        // validation also prevents setting quantity above available stock.
        $cartItem->update($data);

        if ($request->expectsJson()) {
            $cart = $cartItem->cart->fresh('items.product');

            return response()->json($this->cartPayload($cart, 'Cart updated.', $cartItem->fresh('product')));
        }

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse|JsonResponse
    {
        $this->authorizeCartItem($request, $cartItem);
        $cart = $cartItem->cart;
        $deletedItemId = $cartItem->id;
        $cartItem->delete();

        if ($request->expectsJson()) {
            return response()->json($this->cartPayload($cart->fresh('items.product'), 'Item removed.', null, $deletedItemId));
        }

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

    private function cartPayload(Cart $cart, string $message, ?CartItem $item = null, ?int $deletedItemId = null): array
    {
        return [
            'message' => $message,
            'cart_count' => $cart->items->sum('quantity'),
            'cart_total' => number_format($cart->total(), 2),
            'is_empty' => $cart->items->isEmpty(),
            'deleted_item_id' => $deletedItemId,
            'item' => $item ? [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'line_total' => number_format($item->quantity * $item->product->price, 2),
            ] : null,
        ];
    }
}
