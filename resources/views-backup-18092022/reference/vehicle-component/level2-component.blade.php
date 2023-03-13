<div class="col-md-11 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px" class="del">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionLvl2(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#lvl2Modal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Lvl 2</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-lvl2-code" value="">
            @foreach ($componentLvl2 as $lvl2)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionLvl2(this, 'update')"
                            data-id="{{ $lvl2->id }}" data-code="{{ $lvl2->code }}"
                            data-name="{{ $lvl2->component }}" data-bs-toggle="modal"
                            data-bs-target="#lvl2Modal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemLvl2({{$lvl2->id}})" class="btn cux-btn small" xaction="delete_selected_lvl2" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $lvl2->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionLvl2(this, 'update')"
                            data-id="{{ $lvl2->id }}" data-code="{{ $lvl2->code }}"
                            data-name="{{ $lvl2->component }}" data-bs-toggle="modal"
                            data-bs-target="#lvl2Modal">{{ $lvl2->component }}</a></td>
                    <td style="width: 30px" class="text-end"
                        onclick="displayLvl3(this, {{ $lvl2->id }}, {{ $lvl2->id }},'{{ $lvl2->code }}', '{{ $lvl2->component }}')">
                        <i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                </tr>
                <tr xlvl2list="lvl2_id_{{$lvl2->id}}_lvl3"></tr>
            @endforeach
            @if (count($componentLvl2) == 0)
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
    // Start init SubCategory

    lvl2_code = '{{$code}}';

    function deleteItemLvl2(id){
        comp_ids = [id];
    }

    $('#chkall_lvl2').change(function() {
        comp_ids = [];

        $('[name="chk_lvl2"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_lvl2"]:checked').map(function() {
            comp_ids.push(parseInt(this.value));
        });

        if (comp_ids.length > 0) {
            $('[xaction="delete_selected_lvl2"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_lvl2"]').prop('disabled', true);
        }
    });

    $('[name="chk_lvl2"]').change(function() {
        console.log(this);
        comp_ids = [];

        $('input[name="chk_lvl2"]:checked').map(function() {
            comp_ids.push(parseInt(this.value));
        });

        if (comp_ids.length > 0) {
            $('[xaction="delete_selected_lvl2"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_lvl2"]').prop('disabled', true);
        }

    });

    function save_lvl2(){
        let id = $('[name="lvl2-id"]').val();
        let lvl1_id = $('#lvl2Modal #lvl1-id').val();
        let name = $('[name="lvl2-name"]').val();
        let action = $('#lvl2Modal #action').val();

        let data = {
            lvl: 2,
            action: action, 
            lvl1_id: lvl1_id, 
            id: id, 
            name: name
        };

        vehicleComponentAction(data);
    }

    $('[xaction="delete_selected_lvl2"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val(2);
    });

    $('[xaction="close_lvl2"]').on('click', function(){
        $('#lvl2Modal #message-container').hide();
    });

    // End init SubCategory
</script>

