<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['section_name', 'section_description', 'section_status'];
    protected $primaryKey = 'section_id';
    protected $table = 'tbl_section';

    public function products()
    {
        return $this->hasMany(Product::class, 'section_id');
    }
}
