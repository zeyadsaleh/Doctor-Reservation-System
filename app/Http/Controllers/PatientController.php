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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
        $patient = $request->only(['first_name', 'last_name', 'email', 'gender','birth_date','country','mobile','occupation','painType_id']);
        $patient = Patient::create($patient);
        
        //assigning the patient to his credentials in users table by polymorfic relation        
        $user = Auth::User();
        $patient->user()->save($user);
        return redirect()->route('patients.create');
    }

  
}
