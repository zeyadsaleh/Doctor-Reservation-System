<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'mobile', 'birth_date', 'gender','country', 'occupation'
    ];

    public function user()
    {
      return $this->morphOne('App\User', 'profilable');
    }
}
