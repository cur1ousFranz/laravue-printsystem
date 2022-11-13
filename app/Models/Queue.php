<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'customer_id',
        'control_number',
        'document',
        'size',
        'color',
        'pages',
        'amount',
        'pickup',
        'status',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
