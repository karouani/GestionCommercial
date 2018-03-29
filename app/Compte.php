<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compte extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_compte';
    protected $dates = ['deleted_at'];
}


