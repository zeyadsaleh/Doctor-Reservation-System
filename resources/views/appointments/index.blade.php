@extends('layouts.app')

@section('content')

<div class="container">

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    @hasrole('patient')

    @if($appointmentCount < 1)
    <div class="m-2">
        <form action="appointments" method="POST">
            @csrf
            <button class="btn btn-info">Make Reservation!</button>
        </form>
    </div>
    @endif
    @endhasrole


    @hasrole('patient')
    <h2 class="mt-3">Your Appointment</h2>
    @endhasrole
    @hasrole('doctor')
    <h2 class="mt-3">Your Assigned Appointments</h2>
    @endhasrole
    @hasrole('super-admin')
    <h2 class="mt-3">Unassigned Cases</h2>
    @endhasrole

    <table class="table mt-4">

        <thead class="thead-dark">
            @hasanyrole('doctor|super-admin')
            <th scope="col">Patient's Name</th>
            @endhasanyrole
            @hasanyrole('patient|super-admin')
            <th scope="col">Doctor's Name</th>
            @endhasanyrole
            <th scope="col">Reservation Date</th>
            @hasrole('super-admin')
            <th scope="col">Assign</th>
            @endhasrole
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
            <tr>
                @hasrole('doctor')
                <td>{{ $appointment->patient->fullName() }}</td>
                <td>{{ $appointment->date ? $appointment->date : 'Not assigned yet' }}</td>
                @endhasrole
                @hasrole('patient')
                <td>{{ $appointment->doctor ? $appointment->doctor->full_name : 'Not assigned yet' }}</td>
                <td>{{ $appointment->date ? $appointment->date : 'Not assigned yet' }}</td>
                @endhasrole
                @hasrole('super-admin')
                <td>{{ $appointment->patient->fullName() }}</td>
                <td>{{ $appointment->doctor ? $appointment->doctor->full_name : 'Not assigned yet' }}</td>
                <td>{{ $appointment->date ? $appointment->date : 'Not assigned yet' }}</td>
                <td>
                    <a class="btn btn-success" href="{{ route('appointments.edit', ['appointment' => $appointment->id]) }}">Assign</a>
                </td>
                @endhasrole
            </tr>

            @empty
            <div class="alert alert-primary" role="alert">
                No Appointments!
            </div>

            @endforelse
        </tbody>

    </table>

</div>

@endsection