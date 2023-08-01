@php
    $search = Request('search') ? Request('search') : null;
    $page = Request('page') ? Request('page') : 1;
    $register_purpose = Request('register_purpose') ? Request('register_purpose') : null;
    $sort_field = Request('sort_field') ? Request('sort_field') : 'name';
    $sort_by = Request('sort_by') ? Request('sort_by') : 'desc';
    $acc_unverified = Request('acc_unverified') ? Request('acc_unverified') : 0;

@endphp
<div class="row">
    <div class="col-md-8">
        <div class="btn-group">
            <button id="setRoleAll" class="btn cux-btn bigger" data-bs-toggle="modal" disabled data-bs-target="#setRoleModal" type="button"><i class="fal fa-ban text-danger"></i> Set/Tukar Peranan</button>
        </div>
        <div class="btn-group mt-0 mt-md-0">
            <button id="setWorkshopAll" class="btn cux-btn bigger" data-bs-toggle="modal" disabled data-bs-target="#setWorkshopModal"  type="button"><i class="fal fa-ban text-danger"></i> Set/Tukar Woksyop/Lokasi/Cawangan</button>
        </div>

        <div class="btn-group mt-2 mt-md-0 mt-sm-0">
            <button id="revokeAll" class="btn cux-btn bigger" data-bs-toggle="modal" disabled data-bs-target="#revokeUserModal" type="button" value="Edit"><i class="fal fa-trash-alt text-primary"></i> Buang</button>

            @if($acc_unverified == 1)
            <button id="resendLinkVerifyAll" class="btn cux-btn bigger" data-bs-toggle="modal" disabled data-bs-target="#resendLinkVerifyModal" type="button" value="Edit"><i class="fal fa-paper-plane text-primary"></i> Hantar Pautan Verifikasi</button>
            @endif
            {{-- <button id="lockAll" class="btn cux-btn bigger" data-bs-toggle="modal" disabled data-bs-target="#lockAllModal" onclick="showPrompt('lock')" type="button"><i class="fal fa-key text-danger"></i> Kunci Akses</button> --}}
        </div>
    </div>

    <div class="col-md-4 mt-2 mt-md-0 float-md-end">
        <div class="input-group">
            <input data-sort-by="{{$sort_by}}" data-sort-field="{{$sort_field}}" data-mode="searching" id="searching" type="search" onkeyup="loadUserPage(1, '{{$register_purpose}}', this);" class="form-control search" placeholder="Carian Nama/Kad Pengenalan" value="{{$search}}">
            <span data-sort-by="{{$sort_by}}" data-sort-field="{{$sort_field}}" data-mode="searching" onclick="loadUserPage(1, '{{$register_purpose}}', this, 'click');" class="input-group-text" style="border-width:1px;"><i class="fa fa-search"></i></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="table-responsive">
        <table id="ls-pub" style="width: 100%;">
            <thead>
            <tr>
                <th class="lcal-2" style="width: 50px;">
                    <input class="form-check-input" name="chkall" id="chkall" type="checkbox"/>
                </th>
                <th class="lcal-3">
                    <label class="pt-3">
                        Nama
                    </label>
                    <div class="btn-group-vertical float-end">
                        <a onclick="loadUserPage({{$page}}, '{{$register_purpose}}', this)" data-sort-by="asc" data-sort-field="name" class="btn btn-xs btn-link p-0 pe-1 ps-1 cursor-pointer {{$sort_by == 'asc' && $sort_field == 'name' ? 'is_sorted' : ''  }}">
                            a-z <i class="fas fa-sort-up"></i>
                        </a>
                        <a onclick="loadUserPage({{$page}}, '{{$register_purpose}}', this)" data-sort-by="desc" data-sort-field="name" class="btn btn-xs btn-link p-0 pe-1 ps-1 cursor-pointer {{$sort_by == 'desc' && $sort_field == 'name' ? 'is_sorted' : ''  }}">
                            z-a <i class="fas fa-sort-down"></i>
                        </a>
                    </div>
                </th>
                <th class="lcal-4">
                    <label class="pt-3">
                        Emel
                    </label>
                    <div class="btn-group-vertical float-end">
                        <a onclick="loadUserPage({{$page}}, '{{$register_purpose}}', this)" data-sort-by="asc" data-sort-field="email" class="btn btn-xs btn-link p-0 pe-1 ps-1 cursor-pointer {{$sort_by == 'asc' && $sort_field == 'email' ? 'is_sorted' : ''  }}">
                            a-z <i class="fas fa-sort-up"></i>
                        </a>
                        <a onclick="loadUserPage({{$page}}, '{{$register_purpose}}', this)" data-sort-by="desc" data-sort-field="email" class="btn btn-xs btn-link p-0 pe-1 ps-1 cursor-pointer {{$sort_by == 'desc' && $sort_field == 'email' ? 'is_sorted' : ''  }}">
                            z-a <i class="fas fa-sort-down"></i>
                        </a>
                    </div>
                </th>
                {{--  <th>ID Pengenalan</th>  --}}
                {{--  <th>Tujuan Mendaftar</th>  --}}
                <th>Peranan </th>
                <th>Woksyop</th>
                <th>Cawangan / Bahagian</th>
                <th>Lokasi</th>
            </tr>
            </thead>
            <tbody id="sortable">
                {{--  @php
                    $registerPurpose = [
                        'is_jkr' => 'JKR',
                        'is_gov_agency' => 'Agensi Kerajaan (Selain JKR)',
                        'is_contractor' => 'Kontraktor',
                        'is_public' => 'Orang Awam'
                    ]
                @endphp  --}}
            @foreach ($users as $user)
                <tr data-user-id="{{$user->id}}"
                @if($user->detail)
                    @if($user->detail->hasWorkshop)
                        data-workshop-id="{{$user->detail->hasWorkshop->id}}"
                    @endif
                    @if($user->detail->hasPlacement)
                        data-placement-id="{{$user->detail->hasPlacement->id}}"
                    @endif
                    @if($user->detail->hasBranch)
                        data-branch-id="{{$user->detail->hasBranch->id}}"
                    @endif
                @endif

                >
                    <td class="del" style="width: 50px;">
                        <input class="form-check-input" name="chkdel" id="chkdel" type="checkbox" value="{{$user->id}}"/>
                    </td>
                    <td class="key"><a >{{$user->name}}</a></td>
                    <td class="key leftline"><a href="#" data-bs-toggle="modal"  data-bs-target="#userDetail" onclick="getUserDetail({{$user->id}})" >{{$user->email}}</a></td>
                    {{--  <td>{{$user->detail->identity_no}}</td>  --}}
                    {{--  <td>{{$registerPurpose[$user->detail->register_purpose]}}</td>  --}}
                    <td class="text-left">

                        @if(count($user->roles))
                            @if(empty($user->getRoleDesc($user->roles[0]->name)))
                                Set Peranan
                                @else
                                <span class="btn cux-btn small"  data-bs-toggle="modal" data-bs-target="#setRoleModal" data-page="{{$page}}" data-id="{{$user->id}}" data-roles="{{$user->roles}}" data-purpose_type="{{$user->detail->register_purpose}}"  onclick="addMoreRole(this)"> <i class="fa fa-pen-nib"></i> Tetapan Peranan</span>
                                <ul>

                                    @foreach ($user->roles as $role)
                                    <li>{{$user->getRoleDesc($role->name)->desc_bm}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        @endif
                    </td>
                    <td data-bs-toggle="modal" class="cursor-pointer editable" data-bs-target="#setWorkshopModal" onclick="editWorkshop(this)">
                        {{$user->detail->hasWorkshop ? $user->detail->hasWorkshop->desc : '-'}}
                    </td>
                    <td data-bs-toggle="modal" class="cursor-pointer editable" data-bs-target="#setWorkshopModal" onclick="editBranch(this)">
                        {{$user->detail->hasBranch ? $user->detail->hasBranch->name : 'Semua'}}
                    </td>
                    <td data-bs-toggle="modal" class="cursor-pointer editable" data-bs-target="#setWorkshopModal" onclick="editPlacement(this)">
                        {{$user->detail->hasPlacement ? $user->detail->hasPlacement->desc : 'Semua'}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
{{$users->links('pagination.user-registered', ['register_purpose' => $register_purpose, 'sort_by' => $sort_by, 'sort_field' => $sort_field, 'page' => $page ])}}
{{-- {{$users->appends(request()->input())->links('pagination.user-registered')}} --}}

<script type="text/javascript">

    $(document).ready(function(){
        $('#users_{{$register_purpose}} #chkall').on('change', function(e){
            e.preventDefault();

            let isChecked = $(this).is(':checked');
            $('#users_{{$register_purpose}} [name="chkdel"]').prop('checked', isChecked);

            if(isChecked){
                selectedUsersId = $('#users_{{$register_purpose}} #chkdel:checked').map(function() {
                    return this.value;
                }).get();
            } else {
                selectedUsersId = [];
            }

            let revokeAll = $('#users_{{$register_purpose}} #revokeAll');
            let lockAll = $('#users_{{$register_purpose}} #lockAll');
            let setRoleAll = $('#users_{{$register_purpose}} #setRoleAll');
            let setWorkshopAll = $('#users_{{$register_purpose}} #setWorkshopAll');
            let resendLinkVerifyAll = $('#users_{{$register_purpose}} #resendLinkVerifyAll');

            if(selectedUsersId.length > 0){
                revokeAll.prop('disabled', false);
                lockAll.prop('disabled', false);
                setRoleAll.prop('disabled', false);
                setWorkshopAll.prop('disabled', false);
                resendLinkVerifyAll.prop('disabled', false);
            } else {
                revokeAll.prop('disabled', true);
                lockAll.prop('disabled', true);
                setRoleAll.prop('disabled', true);
                setWorkshopAll.prop('disabled', true);
                resendLinkVerifyAll.prop('disabled', true);
            }

        });

        $('#users_{{$register_purpose}} [name="chkdel"]').on('click', function(){

            selectedUsersId = $('#users_{{$register_purpose}} #chkdel:checked').map(function() {
                return this.value;
            }).get();

            let revokeAll = $('#users_{{$register_purpose}} #revokeAll');
            let lockAll = $('#users_{{$register_purpose}} #lockAll');
            let setRoleAll = $('#users_{{$register_purpose}} #setRoleAll');
            let setWorkshopAll = $('#users_{{$register_purpose}} #setWorkshopAll');
            let resendLinkVerifyAll = $('#users_{{$register_purpose}} #resendLinkVerifyAll');

            if(selectedUsersId.length > 0){
                revokeAll.prop('disabled', false);
                lockAll.prop('disabled', false);
                setRoleAll.prop('disabled', false);
                setWorkshopAll.prop('disabled', false);
                resendLinkVerifyAll.prop('disabled', false);
            } else {
                revokeAll.prop('disabled', true);
                lockAll.prop('disabled', true);
                setRoleAll.prop('disabled', true);
                setWorkshopAll.prop('disabled', true);
                resendLinkVerifyAll.prop('disabled', true);
            }

        });

        $('#searching').on('enter', function(e){
            e.preventDefault();
        })
    })
</script>
