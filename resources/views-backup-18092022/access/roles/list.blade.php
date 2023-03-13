@php
   $search = Request('search') ? Request('search') : null;
   $offset = request('offset');
   $limit = 5;
@endphp
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
    body {
        background-color: #f4f5f2;
    }
    .lcal-2 {
        width:50px;
    }
    .lcal-3 {
        width:100px;
    }
    .lcal-4 {
        width:200px;
        min-width: 140px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
    }

    .form-control.search {
        width: 260px;
    }
    @media (max-width: 1399.98px) {
		/*X-Large devices (large desktops, less than 1400px)*/
		/*X-Large*/
	}
	@media (max-width: 1199.98px) {
		/*Large devices (desktops, less than 1200px)*/
		/*Large*/
	}
	@media (max-width: 991.98px) {
		/* Medium devices (tablets, less than 992px)*/
		/*medium*/
	}
	@media (max-width: 767.98px) {
		/* Small devices (landscape phones, less than 768px)
		/*small*/
	}
	@media (max-width: 575.98px) {
		/*X-Small devices (portrait phones, less than 576px)*/
		/*x-small*/
	}
</style>
<script>
    $(document).ready(function() {
    });
</script>
</head>

<body class="content">
<div class="mytitle">Peranan</div>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('access.admin.dashboard')}}')"><i class="fal fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="#">Pengurusan Akses</a></li>
      <li class="breadcrumb-item active" aria-current="page">Senarai Peranan</li>
    </ol>
</nav>
<div class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group">
                <a href="javascript:openPgInFrame('{{route('access.roles.register')}}')" class="btn cux-btn bigger" type="button" value="Edit"><i class="fal fa-plus"></i> Peranan</a>
                {{-- <button class="btn cux-btn bigger" type="button" id="delete_all"><i class="fal fa-trash-alt"></i> Hapus</button> --}}
            </div>
            <div class="float-end">
                <div class="input-group">
                    <input type="search" onkeyup="searching(this.value)" class="form-control search" placeholder="Carian Peranan / Keterangan" value="{{$search}}">
                    <span class="input-group-text" style="border-width:1px;"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
<form class="form-submit" id="the_form">
    <div class="table-responsive">
    <table id="ls-gov">
        <thead>
            <tr>
                <th class="lcal-2 text-center" style="width: 50px;"><input name="chkall" id="chkall" type="checkbox"/></th>
                <th class="lcal-2">&nbsp;</th>
                <th class="lcal-4">Peranan</th>
                <th class="lcal-4">Jumlah</th>
                <th class="lcal-4">Had Woksyop</th>
                <th>Keterangan</th>
                <th class="lcal-3">Akses</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @php
                $mapRegType = [
                    'is_jkr' => [
                        'done' => false,
                        'target' => 'is_jkr',
                        'name' => 'JKR',
                        'total' => 0
                    ],
                    'is_gover_agency' => [
                        'done' => false,
                        'target' => 'is_gover_agency',
                        'name' => 'Agensi Kerajaan (Selain JKR)',
                        'total' => 0
                    ],
                    'is_contractor' => [
                        'done' => false,
                        'target' => 'is_contractor',
                        'name' => 'Kontraktor',
                        'total' => 0
                    ],
                    'is_public' => [
                        'done' => false,
                        'target' => 'is_public',
                        'name' => 'Orang Awam',
                        'total' => 0
                    ],
                    'is_public_jkr' => [
                        'done' => false,
                        'target' => 'is_public_jkr',
                        'name' => 'Orang Awam (JKR)',
                        'total' => 0
                    ]
                ];
            @endphp
            @foreach ($roles as $role)
                <tr>
                    <td class="del text-center" style="width: 50px;">
                        <input name="chkdel" id="chkdel" type="checkbox" value="{{$role->id}}" style="display:{{$role->can_delete ? 'block': 'none'}}"/>
                    </td>

                    <td class="text-center">
                        <div class="btn-group">
                            {{-- <a class="btn cux-btn" type="button" value="Edit" href="#"><i class="fa fa-plus"></i></a> --}}
                            <a class="btn cux-btn" type="button" value="Edit" href="javascript:openPgInFrame('{{route('access.roles.detail', ['id' => $role->id])}}')"><i class="fa fa-pencil-alt"></i></a>
                            <a class="btn cux-btn" type="button" value="Edit" href="javascript:openPgInFrame('{{route('access.user.registered', ['role_id' => $role->id])}}')"><i class="fa fa-user"></i></a>
                        </div>
                    </td>

                    <td class="key"><a href="javascript:openPgInFrame('{{route('access.roles.detail', ['id' => $role->id])}}')">{{$role->desc_bm}}</a></td>
                    <td class="edit">
                        @if($role->roleAccess->code == '04')
                            @foreach ($role->hasManyRoles as $role2)
                                @if(isset($mapRegType[$role2->hasUser->detail->register_purpose]))
                                    @php
                                        $mapRegType[$role2->hasUser->detail->register_purpose]['total']++;
                                        if(!$mapRegType[$role2->hasUser->detail->register_purpose]['done']){
                                            $mapRegType[$role2->hasUser->detail->register_purpose]['done'] = true;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                            @foreach ($mapRegType as $index => $item)
                                <a class="d-flex text-decoration-none text-white mt-1 bg-spakat p-1 border-2" href="{{route('access.user.registered', ['role_id' => $role->id, 'tab' =>  $item['target'] ])}}">({{$item['total']}}) {{$item['name']}} </a>
                            @endforeach
                            @else
                            {{$role->hasManyRoles->count()}}
                        @endif
                    </td>
                    <td>
                        {{-- <textarea name="" class="form-control" id="" cols="30" rows="10">@json($role->moduleAccess)</textarea> --}}
                        {{-- @if($role->moduleAccess->fleet_has_limit)
                            {{$role->hasWorkshop->desc}}
                            @else
                            Semua
                        @endif --}}

                        <div class="" style="height: 200px; overflow:auto">
                            <ul>
                                @foreach ($role->hasManyModuleAccess as $roleModuleAccess)
                                    <li>
                                        {{$roleModuleAccess->underModuleSub->name_bm}}
                                        <div class="mb-2">
                                            @if($roleModuleAccess->fleet_has_limit)
                                                {{$role->hasWorkshop->desc}}
                                                @else
                                                Semua
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                    <td>{{$role->task_desc_bm}}</td>
                    <td>{{isset($role->roleAccess) ? $role->roleAccess->desc_bm : ''}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</form>
{{ $roles->links('pagination.default') }}
</div>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>

<script>

    function searching(value){
        let keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode ==  13 || !value){
            parent.openPgInFrame("{{route('access.roles.list')}}?search="+value);
        }
    }

    jQuery(document).ready(function() {
        initTab();

        $('select').select2({
			width: '60px',
			theme: "classic",
			minimumResultsForSearch: -1
        });
    })
</script>
</body>
</html>
