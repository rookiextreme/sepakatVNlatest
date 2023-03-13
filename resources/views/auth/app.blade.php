<!DOCTYPE html>
<html lang="en">
<head>

    <meta http-equiv="Content-Type" content="text/html; charscreatePwordet=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="https://spakat.jkr.gov.my/" rel="alternate" hreflang="x-default">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Aplikasi pengurusan kenderaan JKR dalam menguruskan rekod kenderaan, penilaian, penyenggaraan dan kemudahan logistik untuk JKR seluruh Malaysia"><link rel="canonical" href="https://spakat.jkr.gov.my/">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> <meta http-equiv="Pragma" content="no-cache" /> <meta http-equiv="Expires" content="0" />
    <meta property="og:site_name" content="SPaKAT">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://spakat.jkr.gov.my">
    <meta property="og:title" content="JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian">
    <meta property="og:description" content="Aplikasi pengurusan kenderaan JKR dalam menguruskan rekod kenderaan, penilaian, penyenggaraan dan kemudahan logistik untuk JKR seluruh Malaysia">
    <meta property="og:image" content="//spakat.cubixi.com/img/mod-spakat.jpg">
    <title>JKR SPaKAT :: Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <!-- import area for frequently used files-->
    <link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

    <link href="{{ asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('my-assets/css/side-menu.css') }}" rel="stylesheet">
    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('my-assets/css/login.css') }}" rel="stylesheet"> --}}

    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <!-- Font Awesome pro -->
    <link href="{{ asset('my-assets/fontawesome-pro/css/light.css')}}" rel="stylesheet">
    <script src="{{ asset('my-assets/fontawesome-pro/js/all.min.js')}}" type="text/javascript"></script>
    <link href="{{ asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

    <style>
        .select2-small .select2-selection__rendered {
            margin-right: 10px;
        }
        .select2-small .select2-container {
            margin-top: 0px;
            margin-bottom: 0px;
        }

        .select2-small .select2-container--classic .select2-selection--single {
            height: 32px;
        }

        .select2-small .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 30px;
        }

        .select2-small .select2-container--classic .select2-selection--single .select2-selection__rendered {
            line-height: 29px;
        }
        body {
            background-color: #4e3f2e;
            display: none;
        }

        .cursor-pointer{
            cursor: pointer;
        }
    </style>

    @livewireStyles
</head>
<body>
    <div class="top-apps-menu">
        <img src="my-assets/img/spakat-small-min.png" id="menu-logo"/>
        <div class="full">Sistem Aplikasi<br/>Pengurusan Kenderaan<br/>Atas Talian </div>
        <ul class="bunch-menu">
            <li class="row-menu"><i class="fal fa-home"></i> <a href="/">Laman Utama</a></li>
            <li class="row-menu"><i class="fal fa-sign-in"></i> <a href="/login">Log Masuk</a></li>
        </ul>
        <p>&nbsp;</p>
        <div style="font-size:0.7em;color:#999999">&copy; 2021 Jabatan Kerja Raya Malaysia</div>
    </div>
    @livewireScripts
    <div class="container-fluid" style="padding: 0 !important">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>

    <script type="text/javascript">

        function checkSite(){
            $.get(window.location.href, function(res, o, u){ 

                if(u.status !== 200){
                    alert('Something went wrong. Please contact administator');
                }

            }).done(function() {
                //alert( "second success" );
            })
            .fail(function() {
                alert('Something went wrong. Please contact administator');
            })
            .always(function() {
                //alert( "finished" );
            });
        }

        $(document).ready(function(){

            @if (env('APP_ENV') == 'production')
                setInterval(() => {
                    checkSite();
                }, 10000);
            @endif

            $('.flag-list').select2({
                width : 'resolver',
                theme : "classic"
            }).on('change', function(e){
                var lang = e.target.value;
                window.location = "{{route('register')}}?lang="+lang;
            });

            $("body").fadeIn(1000);
        })
    </script>

<img style="visibility:hidden" id='check_pic' src="/images/powered_by.gif" onabort="alert('interrupted')" onload="check_success('http://10.0.0.1/redirect/me/here')" onerror="check_available('10.17.71.150')"/>

</body>
</html>
