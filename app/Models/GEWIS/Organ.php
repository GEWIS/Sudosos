<?php
namespace App\Models\GEWIS;

use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    protected $connection = 'mysql_gewisdb';
    protected $table = 'Organ';
    protected $primaryKey = 'id';
}