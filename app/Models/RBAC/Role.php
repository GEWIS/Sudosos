<?php

namespace App\Models\RBAC;
use App\Models\BaseModel;

class Role extends BaseModel
{

    protected $fillable = ['name'];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function owner()
    {
        return $this->belongsTo(GEWIS\Organ::class);
    }
}
