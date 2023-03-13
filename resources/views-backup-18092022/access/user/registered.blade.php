@php

$role_id = Request('role_id') ? Request('role_id') : null;
$search = Request('search') ? Request('search') : null;
$page = Request('page') ? Request('page') : 1;
$register_purpose = Request('register_purpose') ? Request('register_purpose') : null;
$sort_field = Request('sort_field') ? Request('sort_field') : 'name';
$sort_by = Request('sort_by') ? Request('sort_by') : 'desc';
$acc_unverified = Request('acc_unverified') ? Request('acc_unverified') : 0;

@endphp

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
    <link rel="shortcut icon" href="{{ asset('my-assets/favicon/favicon.png') }}">

    <!--Universal Cubixi styling including Admin, ESS, Mobile and Public.-->
    <link href="{{asset('my-assets/css/cubixi.css')}}" rel="stylesheet" type="text/css">

    <script src="{{ asset('my-assets/bootstrap/js/popper.js') }}" type="text/javascript"></script>

    <!--importing bootstrap-->
    <link href="{{asset('my-assets/bootstrap/css/bootstrap.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('my-assets/fontawesome-pro/css/light.min.css')}}" rel="stylesheet">
    <script src="{{asset('my-assets/fontawesome-pro/js/all.js')}}"></script>
    <!--Importing Icons-->

    <link href="{{asset('my-assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet" />

    <script type="text/javascript" src="{{asset('my-assets/jquery/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('my-assets/bootstrap/js/bootstrap.min.js')}}"></script>

    <link rel="stylesheet" href="{{ asset('my-assets/plugins/datepicker/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

    <link href="{{ asset('my-assets/css/forms.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('my-assets/css/admin-menu.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/cubixi.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/admin-list.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/manager.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('my-assets/css/datacustom.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('my-assets/spakat/spakat.js') }}" type="text/javascript"></script>

    <style type="text/css">
        body {
            background-color: #f4f5f2;
        }

        .lcal-2 {
            width: 50px;
        }

        .lcal-3 {
            width: 100px;
        }

        .lcal-4 {
            width: 150px;
        }

        .cux-box {
            min-width: 400px;
            min-height: 300px;
            width: 60%;
            height: 50%;
        }

        .select2-results__option[aria-selected="true"] {
            background: #e4e4e4;
            color: #1f1f1f;
        }

        .cursor-pointer {
            cursor: pointer !important;
        }

        .is_sorted {
            background-color: #7b8e6d !important;
            color: white !important;
        }

        .editable:hover::before {
            display: block;
            font-weight: 900;
            color: #7b8e6d;
            font-family: 'Arial';
            content: "Kemaskini \A";
        }

        /* .editable:hover {
            font-weight: 900;
            color: #7b8e6d;
            font-family: 'Arial';
        } */

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
        $(document).ready(function() {});

    </script>
</head>

<body class="content">
    {{--  @json($workshops)  --}}
    <div class="mytitle">Pengguna Berdaftar</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('access.admin.dashboard')}}');"><i
                        class="fal fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('access.roles.list')}}');">Pengurusan Akses</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengguna Berdaftar</li>
        </ol>
    </nav>
    <div class="main-content">
        <div class="dropdown inline" style="display: inline;">
            <span class="btn cux-btn bigger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fal fa-folder"></i>
                @switch($acc_unverified)
                    @case(1)
                        Belum Aktif
                        @break;
                    @case(0)
                        Aktif
                        @break
                @endswitch
            </span>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item {{$acc_unverified == 0 ? 'active': ''}}" data-acc-unverified = "0" href="{{route('access.user.registered', ['acc_unverified' => 0])}}">Aktif</a></li>
                <li><a class="dropdown-item {{$acc_unverified == 1 ? 'active': ''}}" data-acc-unverified = "1" href="{{route('access.user.registered', ['acc_unverified' => 1])}}">Belum Aktif</a></li>
            </ul>
    
        </div>
        <div class="quick-navigation" data-fixed-after-touch="">
            <div class="wrapper" style="position: relative">
                <ul id="tabActive">
                    <li xtarget="is_jkr" class="cub-tab {{ ($tab == 'users_is_jkr') ? 'active' : 'active' }}" onClick="goTab(this, 'users_is_jkr'); loadUserPage(1, 'is_jkr')" id="tab1">JKR</li>
                    <li xtarget="is_gover_agency" class="cub-tab {{ ($tab == 'is_gover_agency') ? 'active' : '' }}" onClick="goTab(this, 'users_is_gover_agency'); loadUserPage(1, 'is_gover_agency')" id="tab2">Agensi Kerajaan (Selain JKR)</li>
                    <li xtarget="is_contractor" class="cub-tab {{ ($tab == 'is_contractor') ? 'active' : '' }}" onClick="goTab(this, 'users_is_contractor'); loadUserPage(1, 'is_contractor')" id="tab3">Kontraktor</li>
                    <li xtarget="is_public" class="cub-tab {{ ($tab == 'is_public') ? 'active' : '' }}" onClick="goTab(this, 'users_is_public'); loadUserPage(1, 'is_public')" id="tab4">Awam</li>
                    <li xtarget="is_public_jkr" class="cub-tab {{ ($tab == 'is_public_jkr') ? 'active' : '' }}" onClick="goTab(this, 'users_is_public_jkr'); loadUserPage(1, 'is_public_jkr')" id="tab5">Awam (JKR)</li>
                </ul>
                <div class="under-active">&nbsp;</div>
            </div>
        </div>
        <section id="users_is_jkr" class="tab-content"></section>
        <section id="users_is_gover_agency" class="tab-content"></section>
        <section id="users_is_contractor" class="tab-content"></section>
        <section id="users_is_public" class="tab-content"></section>
        <section id="users_is_public_jkr" class="tab-content"></section>
    </div>

    <div class="modal fade modal-dialog-scrollable" id="userDetail" tabindex="-1" aria-labelledby="userDetailLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="position: relative;height:100%;">
                <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:15px;top:15px;z-index:10"></button>
                <br>
                <div class="modal-body" id="user-detail" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="setRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="setRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-body">

                    <div id="setrole-container-res">
                        <div id="promp" class="row">
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Tetapan Peranan</label>
                                <div class="form-group">
                                    <select id="selectRole" multiple="multiple">
                                        @foreach ($roles as $role)
                                            <option data-code="{{$role->code}}" value="{{ $role->detail($role->code)->id }}">{{ $role->desc_bm }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="hasErr" id="user_registered_role_id"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="form-label text-dark">Jenis Akses</label>
                                <div class="form-group">
                                    <select class="form-select" id="purpose_type" name="purpose_type">
                                        <option value="" selected>Pilih Jenis Akses</option>
                                        <option value="is_jkr">JKR</option>
                                        <option value="is_gover_agency">Agensi Kerajaan (Selain JKR)</option>
                                        <option value="is_contractor">Kontraktor</option>
                                        <option value="is_public">Awam</option>
                                    </select>
                                </div>
                                <div class="hasErr" id="user_registered_purpose_type"></div>
                            </div>
                        </div>
                        <div id="process" class="text-center" style="display: none;">
                            Sila tunggu....
                        </div>
                        <div class="alert alert-warning text-center" style="display: none;" id="message"></div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                  {{-- sini --}}
                    <button type="button" class="btn btn-secondary" id="btn-close" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
                  <a  class="btn btn-primary text-white" id="btn-setrole"  onclick="setRole(this)">
                    Pasti
                  </a>
                </div>
              </div>
        </div>
    </div>

    <div class="modal fade" id="setWorkshopModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="setWorkshopModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">

                    <div id="setworkshop-container-res">
                        <div id="promp">
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">Tetapan Woksyop</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" name="" id="selectWorkshop" onchange="selectedWorkshop(this)">
                                        <option value="" selected>Pilih Woksyop</option>
                                        @foreach ($workshops as $workshop)
                                            <option data-state-id="{{$workshop->state_id}}" value="{{$workshop->id}}">{{ $workshop->desc }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">Tetapan Cawangan/Bahagian</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" name="" id="selectBranch" onchange="selectedBranch(this)">
                                        <option value="" selected>Semua</option>
                                        @foreach ($branches as $branch)
                                            <option data-branch-id="{{$branch->id}}" value="{{$branch->id}}">{{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="" class="form-label text-dark">Tetapan Lokasi Penempatan</label>
                                <div class="input-group mb-3">
                                    <select class="form-select" name="" id="selectPlacement" onchange="selectedPlacement(this)">
                                        <option value="" selected>Semua</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="process" class="text-center" style="display: none;">
                            Sila tunggu....
                        </div>
                        <div class="alert alert-warning text-center" style="display: none;" id="message"></div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" id="btn-close" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
                  <a  class="btn btn-primary text-white" id="btn-setworkshop"  onclick="setWorkshop(this)">
                    Pasti
                  </a>
                </div>
              </div>
        </div>
    </div>

    <div class="modal fade" id="revokeUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="revokeUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">

                    <div id="revokeuser-container-res">
                        <div id="promp">
                            <div class="col-md-12 text-center">
                                Adakah anda ingin membuang pengguna ini?
                            </div>
                        </div>
                        <div id="process" class="text-center" style="display: none;">
                            Sila tunggu....
                        </div>
                        <div class="alert alert-warning text-center" style="display: none;" id="message"></div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" id="btn-close" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
                  <a  class="btn btn-primary text-white" id="btn-revokeuser"  onclick="revokeUser(this)">
                    Pasti
                  </a>
                </div>
              </div>
        </div>
    </div>

    <div class="modal fade" id="resendLinkVerifyModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="resendLinkVerifyModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-body">

                    <div id="resendlinkverifyuser-container-res">
                        <div id="promp">
                            <div class="col-md-12 text-center">
                                Adakah anda ingin menghantar kembali pautan verifikasi?
                            </div>
                        </div>
                        <div id="process" class="text-center" style="display: none;">
                            Sila tunggu....
                        </div>
                        <div class="alert alert-warning text-center" style="display: none;" id="message"></div>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" id="btn-close" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
                  <a  class="btn btn-primary text-white" id="btn-resendlinkverifyuser"  onclick="resendLinkVerifyUser(this)">
                    Pasti
                  </a>
                </div>
              </div>
        </div>
    </div>

    <script type="text/javascript">
        var triggeredUpdate = 0;
        var currentTab = '{{ $tab }}';
        var selectedUserId = -1;
        var selectedRoleId = -1;
        var selectedWorkshopId = null;
        var selectedPlacementId = null;
        var selectedBranchId = null;
        var selectedUsersId = [];
        var selectedGovUsersId = [];
        var selectedNonGovUsersId = [];
        var is_gov = true;
        let currentPage = 1;
        let currentTabList = 'is_jkr';
        let currentSearch = null;


        function getUserDetail(user_id){
            $.get("{{route('access.user.ajax.getModalUserDetail')}}", {
                'user_id': user_id,
            }, function(res){
                $('#user-detail').html(res);
            });
        }

        function loadUserPage(page, register_purpose, self, trigger){

            let acc_unverified = '{{Request('acc_unverified') ? Request('acc_unverified') : 0}}';

            if(trigger == 'click'){
                currentSearch = $('#searching').val();
                $('#users_'+register_purpose).html('');
            } else {
                if(self){
                    currentSearch = self.value;
                }
            }
            
            currentTabList = register_purpose;
            currentPage = page;
            
            let sort_field = $(self).data('sort-field') ? $(self).data('sort-field') : 'name';
            let sort_by = $(self).data('sort-by') ? $(self).data('sort-by') : 'asc';

            let params = {page:page, register_purpose: register_purpose, search:currentSearch, sort_by: sort_by, sort_field:sort_field};

            @if ($role_id)
                params['role_id'] = {{$role_id}};
            @endif

            params['acc_unverified'] = acc_unverified;

            let mode = $(self).data('mode');

            if(mode == 'searching'){
                let keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode ==  13 || !currentSearch || (trigger == 'click')){
                    params['search'] = currentSearch;
                    parent.startLoading();
                    $.get("{{route('access.user.registered.list')}}",params, function(result){
                        $('#users_'+register_purpose).html(result);
                        parent.stopLoading();
                    })
                }
            } else {
                    parent.startLoading();
                $.get("{{route('access.user.registered.list')}}",params, function(result){
                    $('#users_'+register_purpose).html(result);
                    parent.stopLoading();
                })
            }
        }

        function hideButton(target) {
            $(target).hide();
        }

        function showButton(target) {
            $(target).show();
        }

        function showPrompt(target, content) {

            if (content == 'gov') {
                is_gov = true;
            } else {
                is_gov = false;
            }

            if (target == 'approval') {
                $('#setrole-container-res #promp').show();
            } else if (target == 'reject') {
                $('#reject-container-res #promp').show();
            }
        }

        function selectOneUser(user_id) {
            selectedUserId = user_id;
        }

        function selectedRole() {
            var selectedRoleId = document.getElementById("selectRole").value;
            return selectedRoleId;
        }

        function selectedWorkshop(self) {
            selectedPlacementId = null;
            selectedWorkshopId = self.value;
            let stateId = $(self).find(':selected').data('state-id');
            getPlacement(stateId);
        }

        const getPlacement = function(stateId){
            let target = $('#selectPlacement');
            target.html('<option value="">Semula Lokasi</option>');
            $.get('{{route('access.user.ajax.getPlacement')}}', {
                'state_id': stateId
            }, function(res){
                res.forEach(placement => {
                    target.append('<option value='+placement.id+'>'+placement.desc+'</option>');
                });
                
            })
        }

        function selectedPlacement(self) {
            selectedPlacementId = self.value;
        }

        function selectedBranch(self) {
            selectedBranchId = self.value;
        }

        function addMoreRole(self){

            let page = $(self).data('page');
            let currentId = $(self).data('id');
            let roles = $(self).data('roles');
            let purposeTypeId = $(self).data('purpose_type');
            let rolesId = [];
            roles.forEach(role => {
                rolesId.push(role.id);
            });

            selectedUsersId = [currentId];

            $('#selectRole').val(rolesId).trigger("change");
            $('#purpose_type').val(purposeTypeId).trigger("change");
           
            currentPage = page;

        }

        // todo set role
        function setRole(self) {

            hideButton('#setRoleModal #btn-close');
            hideButton('#btn-setrole');

            $('#setrole-container-res #promp').hide();
            $('#setrole-container-res #process').show();

            var role_id = -1;
            //selectedRoleId = selectedRole();

            switch (is_gov) {
                case true:

                    break;
                case false:

                    break;
                default:
                    break;
            }

            // if (selectedRoleId != -1) {
            //     role_id = selectedRoleId;
            // }

            let purpose_type = $('#purpose_type').val();
            let selectedRole = $("#selectRole :selected").map(function(i, el) {
                return $(el).data('code');
            }).get();

            $.post("{{ route('access.user.registered.setRole') }}", {
                'users_id': selectedUsersId,
                'role_id': selectedRole.join(","),
                'purpose_type': purpose_type,
                "_token": "{{ csrf_token() }}"
            }).done(function(res){ 
                triggeredUpdate = 1;
                $('#setrole-container-res #process').hide();
                showButton('#setRoleModal #btn-close');
                $('#setrole-container-res #message').text(res['message']).show();
            })
            .fail(function(xhr, status, error) {

                showButton('#setRoleModal #btn-close');
                showButton('#btn-setrole');

            $('#setrole-container-res #promp').show();
            $('#setrole-container-res #process').hide();

                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('.hasErr#user_registered_'+key).html(value[0]);
                });
            });
    }

        const setWorkshop = function(self){

            hideButton('#setWorkshopModal #btn-close');
            hideButton('#btn-setworkshop');

            $('#setworkshop-container-res #promp').hide();
            $('#setworkshop-container-res #process').show();

            $.post("{{ route('access.user.registered.setWorkshop') }}", {
                'users_id': selectedUsersId,
                'workshop_id': selectedWorkshopId,
                'placement_id': selectedPlacementId,
                'branch_id': selectedBranchId,
                "_token": "{{ csrf_token() }}"
            }, function(result) {
                triggeredUpdate = 1;
                $('#setworkshop-container-res #process').hide();
                showButton('#setWorkshopModal #btn-close');
                $('#setworkshop-container-res #message').text(result['message']).show();
            });
        }

        const revokeUser = function(self){

            hideButton('#revokeUserModal #btn-close');
            hideButton('#btn-revokeuser');

            $('#revokeuser-container-res #promp').hide();
            $('#revokeuser-container-res #process').show();

            $.post("{{ route('access.user.registered.revoke') }}", {
                'users_id': selectedUsersId,
                "_token": "{{ csrf_token() }}"
            }, function(result) {
                triggeredUpdate = 1;
                $('#revokeuser-container-res #process').hide();
                showButton('#revokeUserModal #btn-close');
                $('#revokeuser-container-res #message').text(result['message']).show();
            });
        }

        const resendLinkVerifyUser = function(self){

            hideButton('#resendLinkVerifyModal #btn-close');
            hideButton('#resendLinkVerifyModal #btn-resendlinkverifyuser');

            $('#resendlinkverifyuser-container-res #promp').hide();
            $('#resendlinkverifyuser-container-res #process').show();

            $.post("{{ route('access.user.registered.resendLinkVerifyUser') }}", {
                'users_id': selectedUsersId,
                "_token": "{{ csrf_token() }}"
            }, function(result) {
                triggeredUpdate = 1;
                $('#resendlinkverifyuser-container-res #process').hide();
                showButton('#resendLinkVerifyModal #btn-close');
                $('#resendlinkverifyuser-container-res #message').text(result['message']).show();
            });
        }

        function refreshPage() {
            selectedUserId = -1;
            if (triggeredUpdate == 1) {

                showButton('#btn-close');
                showButton('#btn-setrole');
                showButton('#btn-setworkshop');
                showButton('#btn-revokeuser');
                showButton('#btn-resendlinkverifyuser');

                $('#selectRole').val(null).trigger('change');
                $('#selectWorkshop').val(null).trigger('change');
                $('#purpose_type').val(null).trigger('change');
                

                $('#setrole-container-res #message').hide();
                $('#setrole-container-res #promp').show();
                $('#setrole-container-res #process').hide();

                $('#setworkshop-container-res #message').hide();
                $('#setworkshop-container-res #promp').show();

                $('#revokeuser-container-res #message').hide();
                $('#revokeuser-container-res #promp').show();
                $('#revokeuser-container-res #process').hide();

                $('#resendlinkverifyuser-container-res #message').hide();
                $('#resendlinkverifyuser-container-res #promp').show();
                $('#resendlinkverifyuser-container-res #process').hide();

                $('.hasErr').html('');
                loadUserPage(currentPage, currentTabList);
            }
        }

        const loginAS = function(self){
            let username = $(self).data('username');

            if(!username){
                alert('Tiada Nama Pengguna. sila semak');
                return false;
            }
            $.post('{{route('switch.user.post')}}', {
                'username': username,
                "_token": "{{ csrf_token() }}"
            }, function(res){
                window.parent.location.href = res;
            });
        }

        const loadDetail = function(self){
            user_id = $(self).parent().data('user-id');
            workshop_id = $(self).parent().data('workshop-id');
            placement_id = $(self).parent().data('placement-id');
            branch_id = $(self).parent().data('branch-id');

            selectedUsersId = [user_id];

            console.log(workshop_id, placement_id, branch_id);

            if(workshop_id > 0){
                $('#selectWorkshop').val(workshop_id).trigger('change');
            }
            if(placement_id > 0){
                setTimeout(() => {
                    $('#selectPlacement').val(placement_id).trigger('change');
                }, 300);
            }
            if(branch_id > 0){
                $('#selectBranch').val(branch_id).trigger('change');
            }
        }

        const editWorkshop = function(self){
            loadDetail(self);
        }

        const editPlacement = function(self){
            loadDetail(self);
        }

        const editBranch = function(self){
            loadDetail(self);
        }

    </script>

    <script src="{{ asset('my-assets/plugins/select2/dist/js/select2.js') }}"></script>

    <script>
        jQuery(document).ready(function() {
            
            initTab();

            @if($tab)
            $('[xtarget={{$tab}}]').click();
            @else
            loadUserPage(currentPage, 'is_jkr');
            @endif

            //$('#selectRole').val([3,2]).trigger("change");

            $('#selectRole').select2({
                tags: true,
                tokenSeparators: [","],
                width: '100%',
                theme: "classic",
                dropdownParent: $("#setRoleModal"),
                insertTag: function (data, tag) {
                    // Insert the tag at the end of the results
                    console.log(tag);
                    data.push(tag);
                }
            });

            $('#purpose_type').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#setRoleModal")
            });

            $('#selectWorkshop').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#setWorkshopModal")
            });

            $('#selectPlacement').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#setWorkshopModal")
            });

            $('#selectBranch').select2({
                width: '100%',
                theme: "classic",
                dropdownParent: $("#setWorkshopModal")
            });

        })

    </script>
</body>

</html>
