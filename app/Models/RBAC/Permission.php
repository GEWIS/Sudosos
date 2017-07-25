<?php

namespace App\Models\RBAC;
use App\Models\BaseModel;

class Permission extends BaseModel
{
    protected $fillable=['name'];

    protected $guarded=['id'];

    public function roles()
    {
        return $this->belongsToMany('App\Models\RBAC\Role', 'permission_role');
    }
}
