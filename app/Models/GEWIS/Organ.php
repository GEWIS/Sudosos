<?php
namespace App\Models\GEWIS;

use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    public $timestamps = false;

    protected $connection = 'mysql_gewisdb';
    protected $table = 'Organ';
    protected $primaryKey = 'id';

    public function hasMember()
    {
        return $this->belongsToMany(Role::class);
    }
}