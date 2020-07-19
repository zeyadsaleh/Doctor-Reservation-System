<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  protected $fillable = [
    'first_name', 'last_name', 'mobile', 'birth_date', 'gender', 'country', 'occupation', 'paintype_id'
  ];

  public function user()
  {
    return $this->morphOne('App\User', 'profilable');
  }

  public function appointments()
  {

    return $this->hasOne('App\Appointment');
  }

  public function paintype()
  {

    return $this->belongsTo('App\PainType');
  }

  public function fullName()
  {
    return $this->first_name . ' ' . $this->last_name;
  }
}
