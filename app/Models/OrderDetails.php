<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetails extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['order_code', 'product_id',  'product_sales_quantity', 'price', 'product_feeship', 'product_coupon'];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_order_details';

    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_code', 'order_code');
    }
}
