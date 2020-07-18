@extends('layouts.app')

@section('content')

<div class="container">

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reservation Form') }}</div>

                <div class="card-body">

                    <div class="form-group row">
                        <div class="col-md-4 text-md-right">{{ __('Patient Name') }}</div>

                        <div class="col-md-6">
                            {{ $appointment->patient->fullName() }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('appointments.update', ['appointment' => $appointment]) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="doctor" class="col-md-4 col-form-label text-md-right">{{ __('Specialized Doctors') }}</label>

                            <div class="col-md-6">
                                <select class="custom-select @error('doctor') is-invalid @enderror" name="doctor_id" id="doctor" autofocus>
                                    <option selected disabled>Open this select menu</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id  }}">{{ $doctor->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="reservation_date" class="col-md-4 col-form-label text-md-right">{{ __('Reservation Date') }}</label>

                            <div class="col-md-6">
                                <input id="reservation_date" type="datetime-local" class="form-control @error('reservation_date') is-invalid @enderror" name="date" value="{{ old('reservation_date') }}" required autocomplete="reservation_date" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reserve') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection