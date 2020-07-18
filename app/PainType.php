<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PainType extends Model
{
    protected $fillable = [
        'type', 'speciality'
    ];

    public function patient()
    {
      return $this->hasOne('App\Patient');
    }
}
