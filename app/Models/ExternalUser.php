<?php

namespace App\Models;

class ExternalUser extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password',
        'legacy_password',
        'first_name',
        'last_name',
        'email',
    ];

    protected $guarded=[
        "id", 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','legacy_password'
    ];

    // Relations
    public function user()
    {
        return $this->hasOne('User');
    }
}
