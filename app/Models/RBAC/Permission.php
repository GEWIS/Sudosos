<?php

namespace App\Models\RBAC;
use App\Models\BaseModel;

class Permission extends BaseModel
{
    protected $fillable=['name'];

    protected $guarded=['id'];

}
