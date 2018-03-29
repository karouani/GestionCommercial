<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_cmd';
    protected $dates = ['deleted_at'];
}
