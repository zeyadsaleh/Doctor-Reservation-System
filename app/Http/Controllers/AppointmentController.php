<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Doctor;
use App\PainType;
use App\Http\Requests\UpdateAppointmentRequest;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        if ($user->hasRole('super-admin')) {
            $appointments = Appointment::where('doctor_id', null)->get(); //appointment that needed to be assigned by admin
        } else if ($user->hasRole('doctor')) {
            $appointments = Appointment::where('doctor_id', $user->profilable->id)->get(); //doctors appointment that has been assgined to him
        } else if ($user->hasRole('patient')) {
            $appointments = Appointment::where('patient_id', $user->profilable->id)->get(); //patient appointement
            $appointmentCount = Appointment::where('patient_id', $user->profilable->id)->count(); //count the appointmnets for the patient
        }

        return view('appointments.index', [
            'appointments' => $appointments,
            'appointmentCount' => $appointmentCount
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $patient = Auth::User()->profilable;
        $patient->appointments()->create();
        return back()->withSuccess('Reservation sent!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        $doctors = Doctor::where('speciality', $appointment->patient->paintype->speciality)->get();
        return view('appointments.edit', [
            'doctors' => $doctors,
            'appointment' => $appointment
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->only('date', 'doctor_id');
        $appointment->update($data);
        return redirect()->route('appointments.index');
    }
}
