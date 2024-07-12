<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['slider_name', 'slider_image', 'slider_status', 'slider_desc', 'product_id'];
    protected $primaryKey = 'slider_id';
    protected $table = 'tbl_slider';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
