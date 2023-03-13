@php

use App\Http\Controllers\User\Approval;
use App\Http\Livewire\Components\User\ModalApproval;

$approvalDAO = new Approval();
$tab = $approvalDAO->tab;

if(request('tab')!=''){
    $tab = request('tab');
}

// $usersJKR = $approvalDAO->getUsers('is_jkr');
// $usersGovAgency = $approvalDAO->getUsers('is_gover_agency');
// $usersContractor = $approvalDAO->getUsers('is_contractor');
// $usersPublic = $approvalDAO->getUsers('public');
$roles = $approvalDAO->userRoles;

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
        width:150px;
    }
    .cux-box {
        min-width:400px;
        min-height:300px;
        width:60%;
        height:50%;
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
    <div class="mytitle">Pengguna Baru</div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:openPgInFrame('{{route('access.admin.dashboard')}}');"><i class="fal fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Pengurusan Akses</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pengguna Baru</li>
        </ol>
    </nav>
    <div class="main-content">
        <form class="form-submit" id="the_form">
            <div class="quick-navigation" data-fixed-after-touch="">
                <div class="wrapper" style="position: relative">
                    <ul id="tabActive">
                        <li class="cub-tab {{ ($tab == 'users_is_jkr') ? 'active' : 'active' }}" onClick="goTab(this, 'users_is_jkr'); loadUserPage(1, 'is_jkr');" id="tab1">JKR</li>
                        <li class="cub-tab {{ ($tab == 'is_gover_agency') ? 'active' : '' }}" onClick="goTab(this, 'users_is_gover_agency'); loadUserPage(1, 'is_gover_agency');" id="tab2">Agensi Kerajaan (Selain JKR)</li>
                        <li class="cub-tab {{ ($tab == 'is_contractor') ? 'active' : '' }}" onClick="goTab(this, 'users_is_contractor'); loadUserPage(1, 'is_contractor');" id="tab3">Kontraktor</li>
                        <li class="cub-tab {{ ($tab == 'is_public') ? 'active' : '' }}" onClick="goTab(this, 'users_is_public'); loadUserPage(1, 'is_public');" id="tab4">Awam</li>
                    </ul>
                    <div class="under-active">&nbsp;</div>
                </div>
            </div>
            <section id="users_is_jkr" class="tab-content"></section>
            <section id="users_is_gover_agency" class="tab-content"></section>
            <section id="users_is_contractor" class="tab-content"></section>
            <section id="users_is_public" class="tab-content"></section>
        </form>
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

    <div class="modal fade"  id="setRoleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="setRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
                @if (empty($success))
                  <div class="col-md-6">
                      <label for="" class="form-label text-dark">Tetapan Peranan</label>
                      <div class="input-group mb-3" >
                        <select class="form-select" id="selectRole" onchange="selectedRole()">
                            <option selected>Pilih Peranan</option>
                            @foreach ($roles as $role )
                              <option value="{{$role->detail($role->code)->id}}">{{$role->desc_bm}}</option>
                            @endforeach
                        </select>
                        @error('user_role') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                  </div>
                @else
                    <div class="alert alert-warning text-center">{{$success}}</div>
                @endif

            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
              @empty($success)
                  <a  class="btn btn-primary text-white" id="btn-setrole" onclick="setrole(this)"s>Pasti</a>
              @endempty
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="approvalModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="approvalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">

                <div id="approval-container-res">
                    <div id="promp" style="display: none;">
                        <h5 class="modal-title mt-3 mb-3 text-dark">Maklumat pengguna ini telah disemak dan didapati <span class="fw-bold text-primary">MENEPATI</span> kriteria yang ditetapkan.</h5>
                        <p>
                        Adakah anda pasti untuk mengesahkan rekod pengguna ini?
                        </p>
                    </div>
                    <div id="process" class="text-center" style="display: none;">
                        Sila tunggu....Hantar email verifikasi kepada pengguna ini.
                    </div>
                    <div class="alert alert-warning text-center" style="display: none;" id="message"></div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" id="btn-close" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
              <a  class="btn btn-primary text-white" id="btn-approval"  onclick="approve(this)">
                Pasti
              </a>
            </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">

                <div id="reject-container-res">
                    <div id="promp" style="display: none;">
                        <h5 class="modal-title mt-3 mb-3 text-dark">Adakah anda ingin membatal pengguna ini?</h5>
                        <label class="label-control">Nyatakan Sebab</label>
                        <textarea style="resize: none;" class="form-control" id="reject-comment" rows="5"></textarea>
                    </div>
                    <div id="process" class="text-center" style="display: none;">
                        Sila tunggu....
                    </div>
                    <div class="alert alert-warning text-center" style="display: none;" id="message"></div>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" id="btn-close" onclick="refreshPage()" data-bs-dismiss="modal">Tutup</button>
              <a  class="btn btn-primary text-white" id="btn-reject"  onclick="reject(this)">
                Pasti
              </a>
            </div>
          </div>
        </div>
    </div>

    <script type="text/javascript">

        var triggeredUpdate = 0;
        var currentTab = '{{$tab}}';
        var selectedUserId = -1;
        var selectedRoleId = -1;
        var selectedGovUsersId = [];
        var selectedNonGovUsersId = [];
        var is_gov = true;

        $(document).ready(function(){

            loadUserPage(1, 'is_jkr');

        });

        function getUserDetail(user_id){
            $.get("{{route('access.user.ajax.getModalUserDetail')}}", {
                'user_id': user_id,
            }, function(res){
                console.log(res);
                $('#user-detail').html(res);
            });
        }

        function loadUserPage(page, register_purpose){
            $.get("{{route('access.user.approval.list')}}", {page:page, register_purpose: register_purpose}, function(result){

                console.log('#users_'+register_purpose);
                $('#users_'+register_purpose).html(result);
            })
        }

        function hideButton(target){
            $(target).hide();
        }

        function showButton(target){
            $(target).show();
        }

        function showPrompt(target, content){

            if(content == 'gov'){
                is_gov = true;
            } else {
                is_gov = false;
            }

            if(target == 'approval'){
                $('#approval-container-res #promp').show();
            } else if(target == 'reject'){
                $('#reject-container-res #promp').show();
            }
        }

        function selectOneUser(user_id){
            selectedUserId = user_id;
        }

        function selectedRole() {
            var selectedRoleId = document.getElementById("selectRole").value;
            return selectedRoleId;
        }

        // todo set role
        function setrole(self){

            hideButton('#btn-close');
            hideButton('#btn-approval');

            $('#approval-container-res #promp').hide();
            $('#approval-container-res #process').show();

            var users_id = [];
            var role_id = -1;
            selectedRoleId = selectedRole();

            switch (is_gov) {
                case true:
                users_id = selectedGovUsersId;
                    break;
                case false:
                users_id = selectedNonGovUsersId;
                    break;
                default:
                    break;
            }

            if(selectedUserId != -1){
                users_id.push(selectedUserId);
            }

            if(selectedRoleId != -1){
                role_id = selectedRoleId;
            }

            console.log(role_id);

            // $.post('/user/approval/setrole', {
            //     'users_id': users_id,
            //      'role_id' : role_id,
            //     "_token": "{{ csrf_token() }}"
            // }, function(result){
            //     triggeredUpdate = 1;
            //     $('#approval-container-res #process').hide();
            //     showButton('#btn-close');
            //     $('#approval-container-res #message').text(result['message']).show();
            // });
        }

        function approve(self){

            hideButton('#btn-close');
            hideButton('#btn-approval');

            $('#approval-container-res #promp').hide();
            $('#approval-container-res #process').show();

            var users_id = [];

            switch (is_gov) {
                case true:
                users_id = selectedGovUsersId;
                    break;
                case false:
                users_id = selectedNonGovUsersId;
                    break;

                default:
                    break;
            }

            if(selectedUserId != -1){
                users_id.push(selectedUserId);
            }

            $.post('{{route('access.user.approval.approve')}}', {
                'users_id': users_id,
                "_token": "{{ csrf_token() }}"
            }, function(result){
                triggeredUpdate = 1;
                $('#approval-container-res #process').hide();
                showButton('#btn-close');
                $('#approval-container-res #message').text(result['message']).show();
            });
        }

        function reject(self){

            hideButton('#btn-close');
            hideButton('#btn-reject');

            $('#reject-container-res #promp').hide();
            $('#reject-container-res #process').show();

            var users_id = [];

            switch (is_gov) {
                case true:
                users_id = selectedGovUsersId;
                    break;
                case false:
                users_id = selectedNonGovUsersId;
                    break;

                default:
                    break;
            }

            if(selectedUserId != -1){
                users_id.push(selectedUserId);
            }

            let rejectComment = $('#reject-comment').val();

            $.post('{{route('access.user.approval.reject')}}', {
                'users_id': users_id,
                'rejectComment': rejectComment,
                "_token": "{{ csrf_token() }}"
            }, function(result){
                triggeredUpdate = 1;
                $('#reject-container-res #process').hide();
                showButton('#btn-close');
                $('#reject-container-res #message').text(result['message']).show();
            });
        }

        function refreshPage(){
            selectedUserId = -1;
            if(triggeredUpdate == 1){
                window.location.reload();
            }
        }

    </script>

<script src="{{asset('my-assets/plugins/select2/dist/js/select2.js')}}"></script>

<script>
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
