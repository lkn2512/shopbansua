<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'type', 'matp'];
    protected $primaryKey = 'maqh';
    protected $table = 'tbl_quanhuyen';

    // Liên kết với ProvinceCity (tbl_tinhthanhpho)
    public function provinceCity()
    {
        return $this->belongsTo(ProvinceCity::class, 'matp', 'matp');
    }

    // Liên kết với Wards (tbl_xaphuongthitran)
    public function wards()
    {
        return $this->hasMany(Wards::class, 'maqh', 'maqh');
    }

    public function shippings()
    {
        return $this->hasMany(Shipping::class, 'maph', 'maph');
    }
}
