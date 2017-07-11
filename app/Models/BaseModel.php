<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Uuid;
use Watson\Validating\ValidatingTrait;

class BaseModel extends Model {

    use ValidatingTrait;
    use SoftDeletes;

    protected $rules = [];

    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    protected static function boot() {
        parent::boot();

        static::creating(function ($baseModel) {
            $baseModel->{$baseModel->getKeyName()} = (string)Uuid::generate();
        }, 10000000);
    }
}