<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mouvement extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_mouvement';
    protected $dates = ['deleted_at'];
}
