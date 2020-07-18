<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'speciality'
    ];

    public function user()
    {
      return $this->morphOne('App\User', 'profilable');
    }
}
