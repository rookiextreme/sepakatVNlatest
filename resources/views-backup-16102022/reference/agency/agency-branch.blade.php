<div class="col-md-11 ps-3 pe-0 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px" class="del">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionBranch(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#branchModal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Cawangan</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-branch-code" value="{{ $code }}">
            @foreach ($branches as $branch)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionBranch(this, 'update')"
                            data-id="{{ $branch->id }}" data-code="{{ $branch->code }}"
                            data-name="{{ $branch->desc }}" data-bs-toggle="modal"
                            data-bs-target="#branchModal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemBranch({{$branch->id}})" class="btn cux-btn small" xaction="delete_selected_branch" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $branch->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionBranch(this, 'update')"
                            data-id="{{ $branch->id }}" data-code="{{ $branch->code }}"
                            data-name="{{ $branch->desc }}" data-bs-toggle="modal"
                            data-bs-target="#branchModal">{{ $branch->desc }}</a></td>
                    <td style="width: 30px" class="text-end"
                        onclick="displayDivision(this, {{ $branch->sector_id }}, {{ $branch->id }},'{{ $branch->code }}', '{{ $branch->desc }}')">
                        <i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                </tr>
                <tr xdivisionlist="branch_id_{{$branch->id}}_division"></tr>
            @endforeach
            @if (count($branches) == 0)
                <tr>
                    <td colspan="4">
                        <div class="d-flex justify-content-center mt-1">
                
                            Tiada Rekod
                        
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<script type="text/javascript">
    // Start init branch

    function deleteItemBranch(id){
        branch_ids = [id];
    }

    $('#chkall_subcategory').change(function() {
        branch_ids = [];

        $('[name="chk_branch"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_branch"]:checked').map(function() {
            branch_ids.push(parseInt(this.value));
        });

        if (branch_ids.length > 0) {
            $('[xaction="delete_selected_branch"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_branch"]').prop('disabled', true);
        }
    });

    $('[name="chk_branch"]').change(function() {
        console.log(this);
        branch_ids = [];

        $('input[name="chk_branch"]:checked').map(function() {
            branch_ids.push(parseInt(this.value));
        });

        if (branch_ids.length > 0) {
            $('[xaction="delete_selected_branch"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_branch"]').prop('disabled', true);
        }

    });

    function modalActionBranch(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_branch"]');
        hide('#branchModal #message-container')

        switch (mode) {
            case 'insert':
                var branchCode = $('#current-branch-code').val();
                $('[name="branch-code"]').val(branchCode);
                show('[xaction="save_division"]');
                break;
            case 'update':
                $(modalTarget).find('#branch-id').val(id);
                $(modalTarget).find('#branch-code').val(code);
                $(modalTarget).find('#branch-desc').val(name);
                break;
        }
    }

    function displayDivision(self, sector_id, branch_id, branch_code, branch_name){

        $('[xdivisionlist]').slideUp('fast');
        $('[xdivisionlist]').html('');

        $('#divisionModal #branch-id').val(branch_id);
        $('#branchCode').text(branch_code);
        $('#branchName').text(branch_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('[xbranchlist="sector_id_'+sector_id+'_branch"]').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getDivision(branch_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
        }
    }

    function getDivision(branch_id){
        $('#sub_category_type').hide();
        $.ajax({
            url: "{{route('reference.getDivision')}}",
            data: {
                branch_id: branch_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('#sub_category_type').html(result);
                $('[xdivisionlist="branch_id_'+branch_id+'_division"]').html(result);
                $('[xdivisionlist="branch_id_'+branch_id+'_division"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function branchAction(action, sector_id, id, desc){

        hide('[xaction="save_branch"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.branch.action')}}", {
            '_token':crf,
            'sector_id': sector_id,
            'id': id,
            'desc':desc,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#branchModal #message-container #result').text(result.message);
            $('#branchModal #message-container').show();
            getBranch(sector_id);
            $('[xbranchlist="sector_id_'+sector_id+'_sub_category"]').slideDown('fast');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="subcategory-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="subcategory-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_division"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function save_branch(){
        let id = $('[name="branch-id"]').val();
        let sector_id = $('#branchModal #sector-id').val();
        let desc = $('[name="branch-desc"]').val();
        let action = $('#branchModal #action').val();
        console.log(action);
        branchAction(action, sector_id, id, desc);
    }

    function deleteBranch(){

        let sector_id = $('#branchModal #sector-id').val();

        $('input[name="chk_subcategory"]:checked').map(function () {
            branch_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.branch.action')}}", {
            'branch_ids': branch_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                getBranch(sector_id);
                $('[xbranchlist="sector_id_'+sector_id+'_sub_category"]').slideDown('fast');
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    $('[xaction="delete_selected_branch"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val('branch');
    });

    $('[xaction="close_branch"]').on('click', function(){
        $('#branchModal #message-container').hide();
    });

    // End init branch
</script>
