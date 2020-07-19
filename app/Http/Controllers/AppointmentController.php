<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Doctor;
use App\Notifications\AppointmentNotification;
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
            $appointments = Appointment::whereNull('date')
                ->orwhere('is_doctor_accept', 0)
                ->orwhere('is_patient_accept', 0)->get(); //appointment that needed to be assigned by admin
        } else if ($user->hasRole('doctor')) {
            $appointments = Appointment::where('doctor_id', $user->profilable->id)->get(); //doctors appointment that has been assgined to him
        } else if ($user->hasRole('patient')) {
            $appointments = Appointment::where('patient_id', $user->profilable->id)->get(); //patient appointement
        }

        return view('appointments.index', [
            'appointments' => $appointments,
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
        if (Auth::User()->hasRole('super-admin')) {
            $data = $request->only('date', 'doctor_id');
            $appointment->update($data);
            $this->sendNotification($appointment);
            return redirect()->route('appointments.index');
        } else {
            return back()->withError('Unauthorize!');
        }
    }

    public function reject(Appointment $appointment)
    {
        $user = Auth::user();
        $appointment->update([
            $user->hasRole('doctor') ? 'is_doctor_accept' : 'is_patient_accept' => false,
        ]);
        return redirect()->route('appointments.index')->withSuccess('Rejected Successfully!');
    }

    public function accept(Appointment $appointment)
    {
        $user = Auth::user();
        $appointment->update([
            $user->hasRole('doctor') ? 'is_doctor_accept' : 'is_patient_accept' => true,
        ]);
        return redirect()->route('appointments.index')->withSuccess('Accepted Successfully!');
    }

    private function sendNotification($appointment)
    {
        $doctor = $appointment->doctor->user;
        $patient = $appointment->patient->user;
        dd($patient->notify(new AppointmentNotification($appointment, 'patient')));
        $doctor->notify(new AppointmentNotification($appointment, 'doctor'));
        $patient->notify(new AppointmentNotification($appointment, 'patient'));
    }
}
