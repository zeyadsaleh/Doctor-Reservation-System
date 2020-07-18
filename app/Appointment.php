<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PDO;

class Appointment extends Model
{
    protected $fillable = [
        'date', 'is_patient_accept', 'is_doctor_accept', 'patient_id', 'doctor_id'
    ];

    public function doctor()
    {
        return $this->belongsTo('App\Doctor');
    }

    public function patient()
    {
      return $this->belongsTo('App\Patient');
    }

    public function confirmed(){
        return $this->where('is_doctor_accept', 1)->where('is_patient_accept', 1);
    }

    public function notAssigned(){
        return $this->where('doctor_id', null);
    }

}
