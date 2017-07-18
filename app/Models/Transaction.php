<?php

namespace App\Models;

class Transaction extends BaseModel
{
    protected $fillable = [
        "sold_to_id",
        "authorized_id",
        "total_price",
        "activity_id",
        "comment",
    ];

    protected $protected = [
        "id", 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "sold_to_id" => "required|exists:users,id",
        "authorized_id" => "required|exists:users,id",
        "total_price" => "required|integer|min:0|max:9999999999",
        "activity_id" => "exists:activities",
        "comment" => "required|string",
    ];

    // Relations
    public function subtransactions(){
        return $this->belongsToMany('App\Models\Subtransaction');
    }
}
