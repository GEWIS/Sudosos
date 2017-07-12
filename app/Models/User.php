<?php

namespace App\Models;

use Faker\Provider\Base;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//class User extends Authenticatable
class User extends BaseModel
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_code',
        'pincode',
        'card_id',
    ];

    protected $guarded=[
        "id",'balance', 'type',
    ];

    protected $rules = [
        "user_code"     => "required|digits:5",
        "pincode"    => "required|string|max:336",
        "card_id" => "required|string|max:336",
        "balance"    => "required|integer",
        "type" => "required|digits:1|in:0,1,2,3",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pincode'
    ];

    // Relations
    public function externalUserData()
    {
        return $this->hasOne('App\Models\ExternalUser');
    }

    public function products(){
        return $this->hasMany('App\Models\Product','owner_id');
    }

    public function storages(){
        return $this->hasMany('App\Models\Storage','owner_id');
    }

    public function pointsOfSale(){
        return $this->hasMany('App\Models\PointOfSale','owner_id');
    }
}
