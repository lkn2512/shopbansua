<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['info_note', 'info_address', 'info_email', 'info_phone', 'info_map', 'info_image', 'info_fanpage', 'slogan_image'];
    protected $primaryKey = 'info_id';
    protected $table = 'tbl_information';
}
