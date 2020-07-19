<?php

namespace App\Http\Middleware;

use Closure;
use App\Appointment;
use Illuminate\Support\Facades\Auth;

class StoreAppointmentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::User();
        $count = Appointment::where('patient_id', $user->profilable->id)->count();
        if($count >= 1){
            return back()->withError('You cant make more than one appointmnet!');
        }
        return $next($request);
    }
}
