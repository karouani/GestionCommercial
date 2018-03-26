<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Famille_article extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'id_famille';
    protected $dates = ['deleted_at'];
}
