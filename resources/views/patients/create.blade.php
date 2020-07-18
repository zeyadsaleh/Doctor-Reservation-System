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
    <form method="POST" action="{{ route('patients.store') }}">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" required class="form-control">
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" required class="form-control">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" required email class="form-control">
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" required class="form-control">
        </div>
        <div class="form-group">
            <label for="birth_date">Birthdate</label>
            <input type="date" name="birth_date" required class="form-control">
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" required class="form-control">
        </div>
        <div class="form-group">
            <label for="occupation">Occupation</label>
            <input type="text" name="occupation" required class="form-control">
        </div>
        <select name="painType_id" required class="form-control mb-3">
            @foreach ($pains as $pain)
                <option value="{{$pain->id}}">{{$pain->type}}</option>
            @endforeach
        </select>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="male" checked>
            <label class="form-check-label mr-3" for="male">
                Male
            </label>
            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
            <label class="form-check-label" for="female">
                Female
            </label>
        </div>

        <br>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </form>
</div>
@endsection