<?php

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\OrderService;

// test('example', function () {
//     $response = $this->get('/');

//     $response->assertStatus(200);
// });

uses(RefreshDatabase::class);

// order services test
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


//flash sale
test('flash sale order test', function() {
    
    $product = Product::create([
        'name' => 'Flash Sale Iphone 17',
        'description' => 'Sale 7.7!',
        'price' => 1000,
        'stock' => 3,
    ]);

    $totalCheckoutRequest = 10;
    $successCount = 0;
    $failedCount = 0;

    for ($i = 0; $i < $totalCheckoutRequest; $i++) {
        try {
            $response = $this->postJson('/api/orders', [
                'items' => [
                    [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    ]
                ]
                ]);

                if ($response->status() === 201) {
                    $successCount++;
                }
        } catch (\Exception $e) {
            $failedCount++;
        }
    }

    $this->assertEquals(3, $successCount);
    $this->assertEquals(0, $product->fresh()->stock);
});