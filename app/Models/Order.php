<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    protected $fillable = [
        'total_price',
        'status',
    ];

    protected function casts(): array {
        return [
            'status' => OrderStatus::class,
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
