<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointOfSale extends BaseModel
{
    protected $table = "pointsofsales";

    protected $fillable = [
        "name", "owner_id"
    ];

    protected $protected = [
        "id", 'owner_id'
    ];

    protected $rules = [
        "name"     => "required|string|max:255",
        "owner_id" => "required|string|max:36"
    ];
}