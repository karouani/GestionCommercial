<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Historique_operation extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_historique_operation';
    protected $dates = ['deleted_at'];
}
