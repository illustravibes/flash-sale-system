<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\OrderService;

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });

uses(RefreshDatabase::class);

test('order services test', function () {
    $product = Product::create([
        'name' => 'HP Gaming',
        'description' => 'HP keren',
        'price' => 10000000,
        'stock' => 10,
    ]);

    $service = new OrderService();
    $order = $service->checkout([
        'items' => [
            [
            'product_id' => $product->id,
            'quantity' => 2,
            ]
        ]
    ]);

    $this->assertDatabaseHas('orders', [
        'id' => $order->id,
        'total_price' => 20000000,
    ]);

    $this->assertEquals(8, $product->fresh()->stock);
});