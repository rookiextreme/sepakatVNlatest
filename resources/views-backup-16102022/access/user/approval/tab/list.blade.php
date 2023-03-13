<div class="btn-group">
    <button id="approveAll" class="btn cux-btn bigger" type="button" data-bs-toggle="modal" disabled data-bs-target="#approvalModal" onclick="showPrompt('approval', 'gov')"><i class="fal fa-check text-primary"></i> Sah</button>
    <button id="rejectAll" class="btn cux-btn bigger" type="button" data-bs-toggle="modal" disabled data-bs-target="#rejectModal" onclick="showPrompt('reject', 'gov')"><i class="fal fa-ban text-danger"></i> Batal</button>
</div>

<div class="table-responsive">
    <table id="ls-pub" class="table table-bordered table-hover">
        <thead>
            <tr>
                <th style="width: 30px">
                    <input name="chkall" id="chkall" type="checkbox"/>
                </th>
                <th style="width:94px" class="text-center">&nbsp;</th>
                <th>Emel</th>
                <th>Tarikh Daftar</th>
            </tr>
        </thead>
        <tbody id="sortable">
        @foreach ($users as $user)
            <tr>
                <td>
                    <input name="chkdel" id="chkdel" type="checkbox" value="{{$user->id}}"/>
                </td>
                <td class="approve reject">
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn cux-btn" type="button" onclick="showPrompt('approval', 'gov'); selectOneUser({{$user->id}});" data-bs-toggle="modal" data-bs-target="#approvalModal"><i class="fa fa-check text-primary"></i></button>
                        <button class="btn cux-btn" type="button" onclick="showPrompt('reject', 'gov'); selectOneUser({{$user->id}});" data-bs-toggle="modal" data-bs-target="#rejectModal"><i class="fa fa-ban text-danger"></i></button>
                    </div>
                </td>
                <td class="key leftline"><a href="#" data-bs-toggle="modal"  data-bs-target="#userDetail" onclick="getUserDetail({{$user->id}})" >{{$user->email}}</a></td>
                <td class="key leftline"><a href="#">{{\Carbon\Carbon::parse($user->created_at)->format('d/m/Y h:m:s A')}}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{$users->links('pagination.user-approval', ['register_purpose' => $register_purpose])}}

<script type="text/javascript">

    $(document).ready(function(){
        $('#users_{{$register_purpose}} #chkall').on('change', function(e){
            e.preventDefault();

            let isChecked = $(this).is(':checked');
            $('#users_{{$register_purpose}} [name="chkdel"]').prop('checked', isChecked);

            if(isChecked){
                selectedGovUsersId = $('#users_{{$register_purpose}} #chkdel:checked').map(function() {
                    return this.value;
                }).get();
            } else {
                selectedGovUsersId = [];
            }

            let approvalAll = $('#users_{{$register_purpose}} #approveAll');
            let rejectAll = $('#users_{{$register_purpose}} #rejectAll');

            if(selectedGovUsersId.length > 0){
                approvalAll.prop('disabled', false);
                rejectAll.prop('disabled', false);
            } else {
                approvalAll.prop('disabled', true);
                rejectAll.prop('disabled', true);
            }

        });

        $('#users_{{$register_purpose}} [name="chkdel"]').on('click', function(){

            selectedGovUsersId = $('#users_{{$register_purpose}} #chkdel:checked').map(function() {
                return this.value;
            }).get();

            let approvalAll = $('#users_{{$register_purpose}} #approveAll');
            let rejectAll = $('#users_{{$register_purpose}} #rejectAll');

            if(selectedGovUsersId.length > 0){
                approvalAll.prop('disabled', false);
                rejectAll.prop('disabled', false);
            } else {
                approvalAll.prop('disabled', true);
                rejectAll.prop('disabled', true);
            }

        });
    })
</script>
