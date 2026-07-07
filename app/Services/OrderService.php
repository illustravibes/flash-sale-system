<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    public function checkout(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = $this->createOrder();

            $this->processItems($order, $data['items']);

            $this->updateTotalOrder($order);

            return $order;
        });
    }

    protected function createOrder(): Order
    {
        return Order::create([
            'total_price' => 0,
            'status' => 0,
        ]);
    }

    protected function processItems(Order $order, array $items): void {
        foreach ($items as $item) {
            $product = Product::lockForUpdate()->findOrFail($item['product_id']);

            if ($product->stock < $item['quantity']) {
                throw new \Exception("The product `{$product->name}` is out of stock.");
            }

            $product->decrement('stock', $item['quantity']);

            $subtotal = $product->price * $item['quantity'];

            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product->id;
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $product->price;
            $orderItem->save();
        }
    }

    protected function updateTotalOrder(Order $order): void {
        
        $totalPrice = $order->items()->sum(DB::raw('quantity * price'));
        
        $order->update([
            'total_price' => $totalPrice,
        ]);
    }
}
