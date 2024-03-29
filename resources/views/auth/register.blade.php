@extends('layouts.app')
@section('title', 'Sign Up | ' . config('app.name'))
@section('description', '新規登録ページです。')

@section('content')
    <div class="text-center">
        <h1>Sign up</h1>
    </div>
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            {!! Form::open(['route' => 'signup.post']) !!}
            <div class="form-group">
                {!! Form::label('name', 'Name') !!}
                {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('email', 'Email') !!}
                {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Password') !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Password Confirmation') !!}
                {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
            </div>
            {!! Form::submit('作成', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
