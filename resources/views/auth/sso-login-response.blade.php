@extends('layouts.guest-2')
@section('content')

    <div>
        <div class="login-box">
            <div class="top-title pb-2"></div>

                <div class="row">
                    <div class="col-md-12">

                        @php
                            $res_method = Request('res_method') ? Request('res_method') : null;
                            $resMap = [
                                'username_duplicate' => 'Nama pengguna anda telah digunakan di dalam sistem. Sila hubungi Admin spakat',
                                'email_duplicate' => 'Emel anda telah digunakan di dalam sistem. Sila hubungi Admin spakat'
                            ];
                        @endphp

                            <div class="form-group">
                               
                            <h5 class="text-danger">
                                @if(isset($resMap[$res_method]))
                                    {{$resMap[$res_method]}}
                                    @else
                                    Something went wrong
                                @endif
                            </h5>

                            </div>

                    </div>
                </div>

                <div class="form-group center">
                    Emel kepada <a class="" href="mailto:spakat@jkr.gov.my">spakat@jkr.gov.my</a><br/><br/>
                    <button type="button" class="btn btn-module" onclick="location.replace('/')">Halaman Utama</button>
                </div>

            <hr/>
        </div>

        <p>&nbsp;</p>
    </div>



@endsection



