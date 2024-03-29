@extends('layouts.app')
@section('title', 'Login | ' . config('app.name'))
@section('description', 'ログインページです。')

@section('content')
    <div class="text-center">
        <h1>Login</h1>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::open(['route' => 'login.post']) !!}
            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
            {!! Form::submit('Login', ['class' => 'btn btn-light']) !!}
            {!! Form::close() !!}

            <p class="mt-4">{{ link_to_route('signup.get', 'New User?', [], ['class' => 'btn btn-primary']) }}</p>
        </div>
    </div>
@endsection
