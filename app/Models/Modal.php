<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    use HasFactory;

    // Specify the table if it's different from the plural form of the model name
    protected $table = 'models';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'modal_no', 
        'title',// Add other fields here as necessary
    ];

    public static function getModalNumbers()
    {
        return Modal::pluck('title', 'id','modal_no')
                    ->where("status",0)
                    ->toArray();
    }

    // Optionally, you can define relationships here if needed
}
