<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['customer_name', 'customer_image', 'customer_email', 'customer_phone', 'customer_address', 'customer_password'];
    protected $primaryKey = 'customer_id';
    protected $table = 'tbl_customers';

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id', 'customer_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'customer_id', 'customer_id');
    }
}
