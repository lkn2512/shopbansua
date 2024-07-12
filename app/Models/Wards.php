<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'type', 'maqh'];
    protected $primaryKey = 'xaid';
    protected $table = 'tbl_xaphuongthitran';

    // Liên kết với District (tbl_quanhuyen)
    public function district()
    {
        return $this->belongsTo(District::class, 'maqh', 'maqh');
    }
    public function shippings()
    {
        return $this->hasMany(Shipping::class, 'xaid', 'xaid');
    }
}
