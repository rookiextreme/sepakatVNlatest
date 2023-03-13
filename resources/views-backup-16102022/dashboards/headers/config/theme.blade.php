
{{-- Pentadbir Sistem --}}
{{-- {{asset('my-assets/img/logo.png')}} --}}
@hasanyrole('01') 
@php
    $bgcolor = "#49575c";
    $applogo = "{{asset('my-assets/img/spakat-admin-min.png')}}";
@endphp
@endhasanyrole

{{-- Pengurusan --}}
@hasanyrole('02')
    <style style="text/css">
        body {
            background-color:  #4e7064;
        }
        .applogo {
            background: url('{{asset('my-assets/img/spakat-business-min.png')}}');
            width: 0px;
            height: 148px;
            background-size: contain;
            background-repeat: no-repeat;
            right: -28px;
        }
        .spakat-small {
            display: none;
        }
    </style>
@endhasanyrole

{{-- Jurutera dan Penolong Jurutera --}}
@hasanyrole('03|04')
    <style style="text/css">
        body {
            background-color:  #6f6c65;
        }

        .applogo {
            background: url('{{asset('my-assets/img/spakat.png')}}');
            width: 0px;
            height: 148px;
            background-size: contain;
            background-repeat: no-repeat;
            right: -28px;
        }
        .spakat-small {
            display: none;
        }
    </style>
@endhasanyrole

{{-- Orang Awam --}}
@hasanyrole('05')
    <style style="text/css">
        /* body {
            background-color:  #4e7064;
        } */
        .applogo {
            background: url('{{asset('my-assets/img/spakat.png')}}');
            width: 0px;
            height: 148px;
            background-size: contain;
            background-repeat: no-repeat;
            right: -28px;
        }
        .spakat-small {
            display: none;
        }
    </style>
@endhasanyrole