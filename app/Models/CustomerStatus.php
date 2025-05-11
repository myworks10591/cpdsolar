<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'customer_id',
        'invoice_no',
        'invoice_date',
        'material_dispatch_date_first',
        'material_dispatch_date_second',
        'installer_name',
        'installation_date',
        'dcr_certificate',
        'installation_indent',
        'meter_installation',
        'meter_configuration',
        'installation_submission_operator_name',
        'subsidy_receive_status_first',
        'subsidy_receive_status_second',
        'warranty_certificate_download',
        'warranty_certificate_delivery_operator_name',
        'warranty_certificate_delivery_date',
        'updates_remarks'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}

?>