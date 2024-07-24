<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['section_name', 'section_slug', 'section_description', 'section_status'];
    protected $primaryKey = 'section_id';
    protected $table = 'tbl_section';

    public function product()
    {
        return $this->hasMany(Product::class, 'section_id');
    }
}
