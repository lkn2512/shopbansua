<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['customer_id', 'shipping_id', 'order_status', 'order_code', 'order_total', 'order_date', 'order_reason_cancle', 'created_at'];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class, 'shipping_id', 'shipping_id');
    }

    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetails::class, 'order_code', 'order_code');
    }
    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class, 'order_code', 'order_code');
    }
}
