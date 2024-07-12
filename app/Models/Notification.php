<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['customer_id', 'contact_id', 'order_code', 'message', 'read'];
    protected $primaryKey = 'id';
    protected $table = 'tbl_notifications';

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_code');
    }
    public function contactCustomer()
    {
        return $this->belongsTo(ContactCustomer::class, 'contact_id');
    }
}
