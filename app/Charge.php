<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_charge';
    protected $dates = ['deleted_at'];
}
