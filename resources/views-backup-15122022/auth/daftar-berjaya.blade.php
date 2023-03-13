@extends('layouts.guest-2')
@section('content')

    {{-- @livewire('auth.forgot-request-success') --}}

@php
    use App\Http\Controllers\ApplicationDAO;

    $ApplicationDAO = new ApplicationDAO();
    $ApplicationDAO->mount();

    $lblRequestRS = $ApplicationDAO->lblRequestRS;
    $lblRequestRSMsg = $ApplicationDAO->lblRequestRSMsg;
    $lblDashboard = $ApplicationDAO->lblDashboard;
    $lblOtherOptions = $ApplicationDAO->lblOtherOptions;
    $lblBtnNewUser = $ApplicationDAO->lblBtnNewUser;
    $lblBtnForgotPass = $ApplicationDAO->lblBtnForgotPass;

@endphp
    <div>
        <div class="login-box">
            <div class="top-title pb-2">{{$lblRequestRS}}</div>

                <div class="row">
                    <div class="col-md-12">

                            <div class="form-group">
                                <label for="ttl_196">{{$lblRequestRSMsg}} [{{$email}}]</label>
                            </div>

                    </div>
                </div>


                <div class="form-group center">
                    <button type="button" class="btn btn-module" onclick="location.replace('/')">{{$lblDashboard}}</button>
                </div>

            <hr/>
            <div class="mini-title mt-5">{{$lblOtherOptions}} <i class="fal fa-caret-down"></i></div>
            <ul class="bunch-menu">
                <li class="row-menu"><a href="{{route('register')}}">{{$lblBtnNewUser}}</a></li>
                <li class="row-menu"><a href="{{route('forgot')}}">{{$lblBtnForgotPass}}</a></li>
            </ul>
        </div>

        <p>&nbsp;</p>
    </div>



@endsection



