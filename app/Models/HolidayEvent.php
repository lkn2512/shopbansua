<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayEvent extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['event_name', 'event_date', 'event_end_date', 'event_image', 'event_status'];
    protected $primaryKey = 'holiday_event_id';
    protected $table = 'tbl_holiday_events';

    public function products()
    {
        return $this->belongsToMany(Product::class, 'tbl_event_product', 'holiday_event_id', 'product_id');
    }
}
