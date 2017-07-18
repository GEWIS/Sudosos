<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

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
        'type',
    ];

    protected $guarded=[
        "id",'balance', 'type',
    ];

    protected $rules = [
        "user_code"     => "required|min:4|max:6",
        "pincode"    => "string|max:336",
        "card_id" => "string|max:336",
        "balance"    => "integer",
        "type" => "required|digits:1|in:0,1,2,3",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pincode',
        'GEWISMember',
        'externalUserData'
    ];

    protected $defaults = [
        'pincode' => '',
        'balance' => 0,
    ];

    protected $appends = ['first_name', 'last_name', 'email'];

    // Relations
    public function externalUserData()
    {
        return $this->hasOne('App\Models\ExternalUser', 'user_id', 'id');
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
        switch ($this->type) {
            case self::TYPE_GEWIS:
                return $this->GEWISMember->firstName;
            case self::TYPE_BARCODE:
                return 'Borrelkaart'; // TODO: translate
            default:
                return $this->externalUserData->first_name;
        }
    }

    public function getLastNameAttribute()
    {
        switch ($this->type) {
            case self::TYPE_GEWIS:
                $name = $this->GEWISMember->middleName;
                if (strlen($name) > 0) {
                    $name .= ' ';
                }
                $name .= $this->GEWISMember->lastName;
                return $name;
            case self::TYPE_BARCODE:
                return '';
            default:
                return $this->externalUserData->last_name;
        }
    }

    public function getEmailAttribute()
    {
        switch ($this->type) {
            case self::TYPE_GEWIS:
                return $this->GEWISMember->email;
            case self::TYPE_BARCODE:
                return 'sudosos@gewis.nl';
            default:
                return $this->externalUserData->email;
        }
    }

    public function getOrganRoles()
    {
        $organRoles = [];
        foreach ($this->GEWISMember->organMemberships as $om) {
            if ($om->dischargeDate === null) {
                $organRoles[$om->organ->abbr] = $om->function;
            }
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
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
