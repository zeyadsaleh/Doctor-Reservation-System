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

    public function scopeConfirmed($q){
        return $q->where('is_doctor_accept', true)->where('is_patient_accept', true);
    }

    public function scopeUnconfirmed($q){
        return $q->orwhere('is_doctor_accept', false)->orwhere('is_patient_accept', false);
    }

}
