<?php

namespace App\Models;

use App\Models\Price;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'printing_shop_id',
        'service_name',
    ];

    public function price()
    {
        return $this->hasOne(Price::class);
    }
}
