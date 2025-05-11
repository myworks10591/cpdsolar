<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'operator_id',
        'group_id',
        'district',
        'name',
        'mobile_no',
        'email',
        'account_no',
        'jan_samarth_bank_branch',
        'jan_samarth_ifsc_code',
        'division',
        'electric_account_id',
        'address',
        'registration_date',
        'application_reference_no',
        'kw',
        'total_amount',
        'payment_mode',
        'jan_samarth_date',
        'document_submission_date',
        'jan_samarth_bank_name',
        'pincode',
        'remarks',
        'modal_no'
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    // Relationship with User
    
    public function user()
    {
        return $this->belongsTo(User::class,'operator_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'customer_id');
    }
}
