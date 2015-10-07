@extends('master')
@section('content')

<form method="POST" action="/auth/register">
    {!! csrf_field() !!}

    <div>
       First Name
        <input type="text" name="first_name" value="{{ old('first_name') }}">
    </div>

    <div>
       Middle Name
        <input type="text" name="middle_name" value="{{ old('middle_name') }}">
    </div>

    <div>
       Last Name
        <input type="text" name="last_name" value="{{ old('last_name') }}">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>

@stop