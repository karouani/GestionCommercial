<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mode_paiement extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_modeP';
    protected $dates = ['deleted_at'];
}
