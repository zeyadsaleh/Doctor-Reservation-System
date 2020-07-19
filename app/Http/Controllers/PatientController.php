<?php

namespace App\Http\Controllers;

use App\PainType;
use App\Patient;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePatientRequest;
class PatientController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pains = PainType::all();
        return view('patients.create', ['pains' => $pains]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePatientRequest $request)
    {
        $user = Auth::User();
        $user->update($request->only(['email']));
        $patient = $request->only(['first_name', 'last_name', 'gender','birth_date','country','mobile','occupation','paintype_id']);
        $patient = Patient::create($patient);
        
        //assigning the patient to his credentials in users table by polymorfic relation        
        $patient->user()->save($user);
        return redirect('/appointments');
    }

  
}
