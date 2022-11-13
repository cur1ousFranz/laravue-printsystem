<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Application;
use App\Models\BusinessOwner;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_owner_id',
        'application_id',
        'status',
        'image',
    ];

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
