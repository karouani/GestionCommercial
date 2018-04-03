<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BonCommande extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_bc';
    protected $dates = ['deleted_at'];
}
