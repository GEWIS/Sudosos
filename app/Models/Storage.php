<?php

namespace App\Models;


class Storage extends BaseModel
{
    protected $fillable = [
        "name", "owner_id"
    ];

    protected $protected = [
        "id", 'owner_id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "name"     => "required|string|max:255",
        "owner_id" => "required|string|max:36|exists:users,id"
    ];

    // Relations

}
