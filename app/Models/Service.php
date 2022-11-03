<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\ServicePrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'service_name',
    ];

    protected $with = ['servicePrice'];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function servicePrice()
    {
        return $this->hasOne(ServicePrice::class);
    }

}
