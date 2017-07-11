<?php

namespace App\Models;


class Product extends BaseModel
{
     protected $fillable = [
        "name",
        "owner_id",
        "price",
        "image",
        "tray_size",
        "category",
    ];

    protected $protected = [
       "id","owner_id",
    ];

    protected $rules = [
        "name"     => "required|string|max:255",
        "price"    => "required|integer|max:9999999999|min:0",
        "owner_id" => "required|string|max:36",
        "image"    => "image",
        "tray_size" => "required|integer|max:9999999999|min:0",
        "category" => "required|string|in:drink,food,ticket,other",
    ];
}
