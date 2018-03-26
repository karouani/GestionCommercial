<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Statu extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_status';
    protected $dates = ['deleted_at'];
}
