<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solde_init extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_solde';
    protected $dates = ['deleted_at'];
}
