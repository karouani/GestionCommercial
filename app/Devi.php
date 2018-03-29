<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Devi extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_devis';
    protected $dates = ['deleted_at'];
}
