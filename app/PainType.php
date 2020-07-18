<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PainType extends Model
{
    protected $fillable = [
        'type', 'speciality'
    ];
}
