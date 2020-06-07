@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-4">
        @include('users.card')
    </div>
    <div class="col-sm-8">
        @include('users.navtabs')
        @include('microposts.microposts')
    </div>
</div>
@endsection
