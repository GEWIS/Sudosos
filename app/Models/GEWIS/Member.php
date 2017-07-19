<?php
namespace App\Models\GEWIS;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $connection = 'mysql_gewisdb';
    protected $table = 'Member';
    protected $primaryKey = 'lidnr';

    public $timestamps = false;

    public function organMemberships()
    {
        return $this->hasMany('App\Models\GEWIS\OrganMember', 'lidnr', 'lidnr');
    }
}