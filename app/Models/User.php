<?php

namespace App\Models;

use Faker\Provider\Base;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
//class User extends Authenticatable
class User extends BaseModel implements Authenticatable
{
    use Notifiable, HasApiTokens;

    const TYPE_GEWIS = 0;
    const TYPE_EXTERNAL = 1;
    const TYPE_INTERNAL = 2;
    const TYPE_BARCODE = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_code',
        'pincode',
        'card_id',
        'type',
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

    //protected $appends = ['first_name', 'last_name', 'email'];

    // Relations
    public function externalUserData()
    {
        return $this->hasOne('App\Models\ExternalUser');
    }

    public function GEWISMember()
    {
        return $this->hasOne('App\Models\GEWIS\Member', 'lidnr', 'user_code');
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

    public function getFirstNameAttribute()
    {
        if ($this->type === self::TYPE_GEWIS) {

        }
    }
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->pincode;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
