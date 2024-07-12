<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritesList extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['product_id', 'customer_id'];
    protected $primaryKey = 'favorite_id';
    protected $table = 'tbl_favorites_list';
}
