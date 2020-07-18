<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'speciality', 'full_name', 'email'
    ];

    public function user()
    {
      return $this->morphOne('App\User', 'profilable');
    }

    public function appointments() {
      
        return $this->hasMany('App\Appointment');
      }
  
}
