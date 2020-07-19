@component('mail::message')

@if($type == 'patient')
<h2>Hello, {{ $appointment->patient->fullName() }}</h2>
<p>Your have been assigned to  <strong> DR. {{ $appointment->doctor->full_name }}</strong></p>
@elseif($type == 'doctor')
<h2>Hello, {{ $appointment->doctor->full_name }}</h2>
<p>You were asked by the admin for an appointment with <strong>{{ $appointment->patient->fullName() }}</strong></p>
@endif

<p>Appointment Date:  <strong>{{ $appointment->reservation_date }}</strong></p>

@component('mail::button', ['url' => $acceptUrl])
Accept
@endcomponent

@component('mail::button', ['url' => $rejectUrl])
Reject
@endcomponent

Thanks you
@endcomponent