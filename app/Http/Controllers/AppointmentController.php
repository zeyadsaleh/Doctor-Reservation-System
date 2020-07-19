<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Doctor;
use App\Notifications\AppointmentNotification;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{

    public function __construct()
    {
        $this->middleware('appointment.store')->only(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        if ($user->hasRole('super-admin')) {
            $confirmedAppointments = Appointment::whereNull('date')->confirmed()->get(); //already assigned appointments
            $unconfirmedAppointments = Appointment::whereNull('date')->unconfirmed()->get(); //appointment that needed to be assigned by admin
        } else if ($user->hasRole('doctor')) {
            $confirmedAppointments = Appointment::where('doctor_id', $user->profilable->id)->confirmed()->get(); //doctors appointment that has been assgined to him and confirmed by both doctor and patient
            $unconfirmedAppointments = Appointment::where('doctor_id', $user->profilable->id)->unconfirmed()->get(); //doctors pending appointments
        } else if ($user->hasRole('patient')) {
            $confirmedAppointments = Appointment::where('patient_id', $user->profilable->id)->confirmed()->get(); //patient appointement that has been confirmed by both doctor and patient
            $unconfirmedAppointments = Appointment::where('patient_id', $user->profilable->id)->unconfirmed()->get(); //patients pending appointments
        }

        return view('appointments.index', [
            'confirmedAppointments' => $confirmedAppointments,
            'unconfirmedAppointments' => $unconfirmedAppointments
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
            try {
                $this->sendNotification($appointment);
                return redirect()->route('appointments.index')->withSuccess('Email sent!');
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
                return back()->withError('Failed in sending the email, please try again!');
            }  
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
        $doctor->notify(new AppointmentNotification($appointment, 'doctor'));
        $patient->notify(new AppointmentNotification($appointment, 'patient'));
    }
}
