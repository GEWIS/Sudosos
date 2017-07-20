<?php
namespace App\Models\GEWIS;

use Illuminate\Database\Eloquent\Model;

class OrganMember extends Model
{
    protected $connection = 'mysql_gewisdb';
    protected $table = 'OrganMember';
    protected $primaryKey = 'id';

    public $timestamps = false;

    public function organ()
    {
        return $this->hasOne('App\Models\GEWIS\Organ','id','organ_id');
    }
}