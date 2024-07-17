<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceCity extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'shipping_cost', 'type'];
    protected $primaryKey = 'matp';
    protected $table = 'tbl_tinhthanhpho';

    public function shippings()
    {
        return $this->hasMany(Shipping::class, 'matp', 'matp');
    }
}
