<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    protected $fillable = [
        'dispatch_number', 'customer_id', 'product_id', 'dispatch_date',
        'driver_name', 'van_number', 'driver_mobile', 'status',
        'dispatched_by', 'remarks'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function product() {
        return $this->belongsTo(ProductName::class, 'product_id');
    }

    public function dispatcher() {
        return $this->belongsTo(User::class, 'dispatched_by');
    }

    public function products()
    {
        return $this->hasMany(DispatchProduct::class);
    }
}
