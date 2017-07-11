<?php

namespace App\Models;


class Storage extends BaseModel
{
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
