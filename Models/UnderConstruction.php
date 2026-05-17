<?php

namespace Modules\UnderConstruction\Models;

use Illuminate\Database\Eloquent\Model;
use DataSDK\Tools\Traits\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnderConstruction extends Model
{
    // Use the Language and Factory traits
    use Language;
    use HasFactory;

    // Define the table associated with the model
    protected $table = "under_construction";

    // Mass assignable attributes
    protected $fillable = [
        "under_construction",
        "access_key",
        "title",
        "description"
    ];

    // Translatable fields
    protected $translatable = [
        'title',
        'description'
    ]; 
}
