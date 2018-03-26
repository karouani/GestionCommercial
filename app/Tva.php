<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Tva extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_tva';
    protected $dates = ['deleted_at'];
}
