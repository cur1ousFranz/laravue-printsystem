<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'document',
        'size',
        'color',
        'pages',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
