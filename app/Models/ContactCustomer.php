<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactCustomer extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = ['contact_name', 'customer_id', 'contact_email', 'contact_subject', 'contact_message'];
    protected $primaryKey = 'contact_id';
    protected $table = 'tbl_contact_customer';

    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class, 'contact_id', 'contact_id');
    }
}
