<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
<link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">

<!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
<link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

<!--importing bootstrap-->
<link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

<link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
<script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
<!--Importing Icons-->

<link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />
<script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

<link href="{{asset('my-assets/css/forms.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('my-assets/css/admin-menu.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/admin-list.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('my-assets/css/manager.css')}}" rel="stylesheet" type="text/css">
<script src="{{asset('my-assets/spakat/spakat.js')}}" type="text/javascript"></script>
<style type="text/css">
</style>
<link rel="stylesheet" type="text/css" href="{{asset('my-assets/plugins/slick/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('my-assets/plugins/slick/slick-theme.css')}}">
<script src="{{asset('my-assets/plugins/highcharts/code/highcharts.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/variable-pie.js')}}"></script>
<script src="{{asset('my-assets/plugins/highcharts/code/modules/accessibility.js')}}"></script>
<script>
    $(document).ready(function() {
    });
</script>
</head>
<body class="content">
<div class="main-content">
    <div class="container-fluid">
        <select name="type" id="type" class="mt-3" onchange="changeSysLog(this)">
            @foreach ($dropdown_list as $item)
                <option value="{{$item}}" {{$type == $item ? 'selected':''}}>{{$item}}</option>
            @endforeach
        </select>
        <table class="table table-bordered table-custom" style="width: 100%;">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $index => $key)
                    <tr>
                        <td>{{$index + 1}}</td>
                        <td>
                            @php
                                $manage = json_decode($key->content);
                            @endphp

                            @switch($type)
                                @case('exception')
                                    @json($manage->trace)
                                    @json($manage->hostname)
                                    @json($manage->user)
                                    @break
                                @case('log')
                                    {{$key->content}}
                                    @break
                                @case('request')
                                    @json($manage->uri)
                                    @json($manage->payload)
                                    @json($manage->user)
                                    {{$key->created_at}}
                                    @break
                                @case('view')
                                    @json($manage->name)
                                    @json($manage->path)
                                    @json($manage->user)
                                @break
                                @default
                                {{$key->content}}
                                    
                            @endswitch
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">

    changeSysLog = function(self){

        let limit = {{$limit}};
        window.location.href = "{{route('access.admin.syslog')}}?type="+self.value+"&limit="+limit;
        
    }
    
</script>
</body>
</html>
