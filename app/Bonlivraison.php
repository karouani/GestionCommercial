<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonlivraison extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_bl';
    protected $dates = ['deleted_at'];
}
