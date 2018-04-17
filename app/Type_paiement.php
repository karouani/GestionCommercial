<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Type_paiement extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_type_paiement';
    protected $dates = ['deleted_at'];
}
