<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'long_size',
        'short_size',
        'black_and_white',
        'colored',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
