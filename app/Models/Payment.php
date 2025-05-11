<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'received_amount',
        'payment_mode', 'due_amount', 'payment_received_date'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function group()
    {
        return $this->hasOneThrough(Group::class, Customer::class, 'id', 'id', 'customer_id', 'group_id');
    }
    public function setDueAmountAttribute()
    {
        $this->attributes['due_amount'] = $this->total_amount - $this->received_amount;
    }
}
