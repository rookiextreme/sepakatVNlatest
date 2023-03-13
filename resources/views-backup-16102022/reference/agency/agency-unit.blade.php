<div class="col-md-11 ps-3 pe-0 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px;">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionUnit(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#divisionModal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Unit</th>
                <th style="width: 30px"></th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-division-code" value="{{ $code }}">
            @foreach ($units as $unit)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionUnit(this, 'update')"
                            data-id="{{ $unit->id }}" data-code="{{ $unit->code }}"
                            data-name="{{ $unit->desc }}" data-bs-toggle="modal"
                            data-bs-target="#divisionModal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemUnit({{$unit->id}})" class="btn cux-btn small" xaction="delete_selected_division" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $unit->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionUnit(this, 'update')"
                            data-id="{{ $unit->id }}" data-code="{{ $unit->code }}"
                            data-name="{{ $unit->desc }}" data-bs-toggle="modal"
                            data-bs-target="#divisionModal">{{ $unit->desc }}</a></td>
                    <td style="width: 30px" class="text-end" onclick="displayUnitSub(this, {{ $unit->division_id }}, {{ $unit->id }},'{{ $unit->code }}', '{{ $unit->desc }}')">
                    <i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                </tr>
                <tr xunitlist="division_id_{{$unit->division_id}}_division"></tr>
            @endforeach
            @if (count($units) == 0)
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
    // Start init 

    $('#chkall_division').change(function() {

        

        division_ids = [];

        $('[name="chk_division"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_division"]:checked').map(function() {
            division_ids.push(parseInt(this.value));
        });

        if (division_ids.length > 0) {
            $('[xaction="delete_selected_division"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_division"]').prop('disabled', true);
        }
    });

    $('[name="chk_division"]').change(function() {
        console.log(this);
        division_ids = [];

        $('input[name="chk_division"]:checked').map(function() {
            division_ids.push(parseInt(this.value));
        });

        if (division_ids.length > 0) {
            $('[xaction="delete_selected_division"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_division"]').prop('disabled', true);
        }

    });

    function divisionAction(action, branch_id, id, desc){

        hide('[xaction="save_division"]');

        let crf = "{{ csrf_token() }}";
        $.post("{{route('reference.division.action')}}", {
            '_token':crf,
            'branch_id': branch_id,
            'id': id,
            'desc':desc,
            'action': action
        }).done(function(result) {
            console.log('success/done ',result);
            $('.text-danger').remove();
            $('#divisionModal #message-container #result').text(result.message);
            $('#divisionModal #message-container').show();
            getDivision(branch_id);
            $('[xbranchlist="branch_id_'+branch_id+'_division"]').slideDown('fast');
        })
        .fail(function(response) {
            console.log('failed ',response);
            var errors = response.responseJSON.errors;
            $.each(errors, function(key, value) {
                if($('[name="division-'+key+'"]').parent().find('.text-danger').length == 0){
                    $('[name="division-'+key+'"]').parent().append('<div class="text-danger col-12 fs-6">'+value[0]+'</div>');
                }
            });
            show('[xaction="save_division"]');
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });

    }

    function modalActionUnit(self, mode){
        let modalTarget = $(self).attr('data-bs-target');

        let id = $(self).attr('data-id');
        let code = $(self).attr('data-code');
        let name = $(self).attr('data-name');

        $(modalTarget).find('#action').val(mode);
        show('[xaction="save_division"]');

        switch (mode) {
            case 'insert':
                var subCategoryTypeCode = $('#current-division-code').val();
                $('[name="division-code"]').val(subCategoryTypeCode);
                show('[xaction="save_division"]');
                break;
            case 'update':
                $(modalTarget).find('#division-id').val(id);
                $(modalTarget).find('#division-code').val(code);
                $(modalTarget).find('#division-desc').val(name);
                break;
        }
    }

    function save_division(){
        let id = $('[name="division-id"]').val();
        let branch_id = $('#divisionModal #branch-id').val();
        let desc = $('[name="division-desc"]').val();
        let action = $('#divisionModal #action').val();
        console.log(action);
        divisionAction(action, branch_id, id, desc);
    }

    function deleteItemUnit(id){
        division_ids = [id];
    }

    function deleteDivision(){

        let branch_id = $('#divisionModal #branch-id').val();

        $('input[name="chk_subcategorytype"]:checked').map(function () {
            division_ids.push(parseInt(this.value));
        });

        $.post("{{route('reference.division.action')}}", {
            'division_ids': division_ids,
            'action': 'delete',
            '_token':'{{ csrf_token() }}'
        }).done(function(result) {
            console.log('success/done ',result);
            hide('[xaction="delete"]');
            hide('[xaction="no"]');
            show('[xaction="close"]');
            $('#deleteModal #message').text(result.message)
            $('[xaction="close"]').on('click', function(){
                getDivision(branch_id);
                $('[xbranchlist="branch_id_'+branch_id+'_division"]').slideDown('fast');
            })
        })
        .fail(function(response) {
            console.log('failed ',response);
        })
        .always(function(result) {
            console.log('keep showing ',result);
        });
    }

    function getUnit(division_id){
        $.ajax({
            url: "{{route('reference.getUnit')}}",
            data: {
                division_id: division_id
            },
            type: "GET",
            dataType: "html",
            cache: false,
            success: function (result) {
                $('[xunitlist="division_id_'+division_id+'_unit"]').html(result);
                $('[xunitlist="division_id_'+division_id+'_unit"]').slideDown('fast');
            },
            error: function (xhr, status) {
                alert("Sorry, there was a problem!");
            },
            complete: function (xhr, status) {
                //$('#showresults').slideDown('fast')
            }
        });
    }

    function displayUnitSub(self, division_id, unit_id, unit_code, unit_name){

        $('[xunitlist]').slideUp('fast');
        $('[xunitlist]').html('');

        $('#unitModal #division-id').val(division_id);
        $('#unitCode').text(unit_code);
        $('#unitName').text(unit_name);

        if($(self).find('.fa-angle-up').length > 0){
            $('[xdivisionlist="division_id_'+division_id+'_unit"]').find('.fa-angle-right').removeClass('fa-angle-right').addClass('fa-angle-up');
            $(self).find('#angle').removeClass('fa-angle-up').addClass('fa-angle-right');

            getUnit(division_id);

        } else {
            $(self).find('#angle').removeClass('fa-angle-right').addClass('fa-angle-up');
        }
    }

    $('[xaction="delete_selected_division"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val('division');
    });

    $('[xaction="close_division"]').on('click', function(){
        $('#divisionModal #message-container').hide();
    });

    // End init division
</script>
