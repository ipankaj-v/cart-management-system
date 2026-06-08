<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::with('user')->latest()->paginate(10),
            'statuses' => Order::STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES,
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order->load(['user', 'items']),
            'statuses' => Order::STATUSES,
            'paymentStatuses' => Order::PAYMENT_STATUSES,
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', Order::STATUSES)],
            'payment_status' => ['required', 'in:'.implode(',', Order::PAYMENT_STATUSES)],
        ]);

        $order->update($data);

        return back()->with('success', 'Order updated.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }
}
