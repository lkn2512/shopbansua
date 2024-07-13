<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['product_code', 'product_name', 'product_slug', 'product_cost', 'product_quantity', 'category_id', 'brand_id',  'product_content', 'product_price', 'promotional_price', 'product_image', 'product_condition', 'product_status', 'product_sold', 'product_view', 'video_id'];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id');
    }

    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }
    // Phương thức scope để lấy sản phẩm nổi bật dựa trên đánh giá sao
    public function scopeFeatured($query)
    {
        return $query->with('ratings')
            ->withAvg('ratings', 'rating')
            ->orderByDesc('ratings_avg_rating');
    }
    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }
    public function sliders()
    {
        return $this->hasMany(Slider::class, 'product_id', 'product_id');
    }
    public function holidayEvents()
    {
        return $this->belongsToMany(HolidayEvent::class, 'tbl_event_product', 'product_id', 'holiday_event_id');
    }
}
