<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Macompagnie extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_compagnie';
    protected $dates = ['deleted_at'];}
