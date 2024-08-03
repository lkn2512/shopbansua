<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['post_title', 'post_slug', 'post_desc', 'post_content', 'post_image', 'post_status', 'cate_post_id', 'post_view'];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_posts';

    public function category_post()
    {
        return $this->belongsTo(CategoryPost::class, 'cate_post_id', 'cate_post_id');
    }
}
