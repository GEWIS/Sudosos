<?php

namespace App\Models;

class UserRole extends BaseModel
{
    protected $table= 'user_roles';

    protected $fillable = [
        "user_id",
        "abbr",
        "function",
    ];

    protected $protected = [
        'id','created_at', 'updated_at', 'deleted_at'
    ];

    protected $rules = [
        "user_id" => "required|exists:users,id",
        "abbr" => "required|string",
        "function" => "required|string",
    ];

    // Relations
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
