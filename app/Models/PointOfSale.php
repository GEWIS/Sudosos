<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointOfSale extends BaseModel
{
    protected $table = "pointsofsales";

    protected $fillable = [
        "name", "owner_id",
    ];

    protected $guarded = [
        "id", 'owner_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "name"     => "required|string|max:255",
        "owner_id" => "required|string|max:36|exists:users,id"
    ];

    // Relations
}