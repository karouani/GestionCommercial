<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition_facture extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_condition';
    protected $dates = ['deleted_at'];
}
