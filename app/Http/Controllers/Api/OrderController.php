<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(\Illuminate\Http\Request $r)
    {
        $data = $r->validate([
            'customer_name' => ['nullable','string','max:255'],
            'phone' => ['nullable','string','max:50'],
            'delivery_address' => ['nullable','string','max:2000'],
            'comment' => ['nullable','string','max:2000'],
            'items' => ['required','array','min:1'],
            'items.*.product_slug' => ['required','string'],
            'items.*.qty' => ['required','integer','min:1'],
            'items.*.options' => ['nullable','array'],
        ]);

        $user = $r->user();

        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'status' => 'new',
            'total' => 0,
            'customer_name' => $data['customer_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'delivery_address' => $data['delivery_address'] ?? null,
            'comment' => $data['comment'] ?? null,
        ]);

        $total = 0;

        foreach ($data['items'] as $it) {
            $product = \App\Models\Product::where('slug', $it['product_slug'])->firstOrFail();

            $qty = (int) $it['qty'];
            $unit = (int) $product->price_from; // пока так (потом сделаем нормальный расчёт)
            $line = $unit * $qty;

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'qty' => $qty,
                'unit_price' => $unit,
                'line_total' => $line,
                'options' => $it['options'] ?? null,
            ]);

            $total += $line;
        }

        $order->update(['total' => $total]);

        return $order->load('items');
    }

}
