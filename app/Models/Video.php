<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['video_title', 'video_link', 'video_code_link', 'video_iframe', 'video_description', 'video_status'];
    protected $primaryKey = 'video_id';
    protected $table = 'tbl_video';

    public function product()
    {
        return $this->belongsTo(Product::class, 'video_id');
    }
}
