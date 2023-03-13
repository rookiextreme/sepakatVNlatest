@extends('auth.app')
@section('content')
    <div class="row">
        <div class="col-md-4 offset-md-4 mt-5" >
            <img src="{{asset('img/spakat-full-logo.png')}}" class="img-fluid  mx-auto"/>
        </div>
    </div>
    <div class="row">
        @livewire('auth.signin')
    </div>
@endsection
