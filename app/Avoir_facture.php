<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Avoir_facture extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_af';
    protected $dates = ['deleted_at'];
}
