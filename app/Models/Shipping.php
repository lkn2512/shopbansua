<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipping extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['shipping_name', 'shipping_email', 'shipping_phone', 'matp', 'maqh', 'xaid', 'shipping_address', 'shipping_notes', 'shipping_method'];
    protected $primaryKey = 'shipping_id';
    protected $table = 'tbl_shipping';

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'shipping_id', 'shipping_id');
    }
    public function province()
    {
        return $this->belongsTo(ProvinceCity::class, 'matp', 'matp');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'maqh', 'maqh');
    }

    public function wards()
    {
        return $this->belongsTo(Wards::class, 'xaid', 'xaid');
    }
}
