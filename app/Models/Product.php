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

    protected $guarded = [
//       "id","owner_id", 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
//        "name"     => "required|string|max:255",
//        "price"    => "required|integer|max:9999999999|min:0",
//        "owner_id" => "required|string|max:36|exists:users,id",
//        "image"    => "image",
//        "tray_size" => "required|integer|max:9999999999|min:0",
//        "category" => "required|string|in:drink,food,ticket,other",
    ];

    // Relations
    public function owner(){
        return $this->belongsTo('App\Models\User','owner_id');
    }
}
