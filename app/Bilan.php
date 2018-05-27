<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bilan extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_bilan';
    protected $dates = ['deleted_at'];
}
