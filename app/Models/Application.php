<?php

namespace App\Models;

use App\Models\BusinessOwner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_owner_id',
        'status',
        'shop_name',
        'address',
        'barangay',
        'city',
        'zipcode',
    ];

    public function businessOwner()
    {
        return $this->belongsTo(BusinessOwner::class);
    }
}
