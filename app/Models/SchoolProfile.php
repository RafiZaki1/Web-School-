<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'school_logo',
        'principal_name',
        'principal_position',
        'principal_photo',
        'welcome_message',
        'background_image',
        'established_year',
    ];

    protected $casts = [
        'established_year' => 'integer',
    ];
}
