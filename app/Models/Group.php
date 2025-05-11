<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Specify the table if it's different from the plural form of the model name
    protected $table = 'groups';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'name', // Add other fields here as necessary
    ];

    // Optionally, you can define relationships here if needed
}
