<?php
namespace App\Models\GEWIS;

use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    protected $connection = 'mysql_gewisdb';
    protected $table = 'OrganMember';
    protected $primaryKey = 'id';

    public function organ()
    {
        return $this->hasOne('App\Models\GEWIS\Organ');
    }
}