<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'printing_shop_id',
        'service_name',
        'price'
    ];

    public function servie()
    {
        $this->belongsTo(Shop::class);
    }

}
