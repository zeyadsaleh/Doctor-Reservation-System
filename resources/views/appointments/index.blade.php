@extends('layouts.app')

@section('content')

<div class="container">

    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    @hasrole('patient')

    @if((count($confirmedAppointments) < 1) && (count($unconfirmedAppointments) < 1)) <div class="m-2">
        <form action="appointments" method="POST">
            @csrf
            <button class="btn btn-info">Make Reservation!</button>
        </form>
</div>
@endif
@endhasrole


<!--################################ For confirmed appointments #########################-->
@hasrole('patient')
<h2 class="mt-3">Your Confirmed Appointment</h2>
@endhasrole
@hasrole('doctor')
<h2 class="mt-3">Your Assigned Appointments</h2>
@endhasrole
@hasrole('super-admin')
<h2 class="mt-3">Assigned Cases</h2>
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
    </thead>
    <tbody>
        @forelse($confirmedAppointments as $confirmedAppointments)
        <tr>
            @hasrole('doctor')
            <td>{{ $confirmedAppointments->patient->fullName() }}</td>
            <td>{{ $confirmedAppointments->date  }}</td>
            @endhasrole
            @hasrole('patient')
            <td>{{ $confirmedAppointments->doctor->full_name  }}</td>
            <td>{{ $confirmedAppointments->date  }}</td>
            @endhasrole
            @hasrole('super-admin')
            <td>{{ $confirmedAppointments->patient->fullName() }}</td>
            <td> '$confirmedAppointments->doctor->full_name'  }}</td>
            <td> $confirmedAppointments->date  }}</td>
            @endhasrole
        @empty
        <div class="alert alert-primary" role="alert">
            No Confirmed Appointments!
        </div>
        @endforelse
        </tr>

    </tbody>

</table>



<!--################################ For unconfirmed appointments #########################-->
@hasrole('patient')
<h2 class="mt-3">Your Pending Appointment</h2>
@endhasrole
@hasrole('doctor')
<h2 class="mt-3">Your Pending Appointments</h2>
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
        @forelse($unconfirmedAppointments as $unconfirmedAppointments)
        <tr>
            @hasrole('doctor')
            <td>{{ $unconfirmedAppointments->patient->fullName() }}</td>
            <td>{{ 'Not Determined yet'  }}</td>
            @endhasrole
            @hasrole('patient')
            <td>{{ 'Not Assigned yet'  }}</td>
            <td>{{ 'Not Determined yet'   }}</td>
            @endhasrole
            @hasrole('super-admin')
            <td>{{ $unconfirmedAppointments->patient->fullName() }}</td>
            <td>{{  'Not Assigned yet'  }}</td>
            <td>{{  'Not Determined yet'  }}</td>
            <td>
                <a class="btn btn-success" href="{{ route('appointments.edit', ['appointment' => $unconfirmedAppointments->id]) }}">Assign</a>
            </td>
            @endhasrole
        @empty
        <div class="alert alert-primary" role="alert">
            No Pending Appointments!
        </div>
        @endforelse
        </tr>

    </tbody>

</table>


</div>

@endsection