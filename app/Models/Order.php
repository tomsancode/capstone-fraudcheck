<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    public $incrementing = false; // Because order_id is varchar

    protected $fillable = [
        'customer_id', 'order_date', 'status', 'total_amount', 'user_id', 'point_id', // Add other necessary fields
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function point()
    {
        return $this->belongsTo(Point::class, 'point_id', 'point_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
