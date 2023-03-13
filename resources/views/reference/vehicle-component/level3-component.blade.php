

<div class="col-md-11 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px;">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionLvl3(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#lvl3Modal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Lvl 3</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-lvl3-code" value="">
            @foreach ($componentLvl3 as $lvl2Type)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionLvl3(this, 'update')"
                            data-id="{{ $lvl2Type->id }}" data-code="{{ $lvl2Type->code }}"
                            data-name="{{ $lvl2Type->component }}" data-bs-toggle="modal"
                            data-bs-target="#lvl3Modal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemType({{$lvl2Type->id}})" class="btn cux-btn small" xaction="delete_selected_lvl3" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $lvl2Type->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionLvl3(this, 'update')"
                            data-id="{{ $lvl2Type->id }}" data-code="{{ $lvl2Type->code }}"
                            data-name="{{ $lvl2Type->component }}" data-bs-toggle="modal"
                            data-bs-target="#lvl3Modal">{{ $lvl2Type->component }}</a></td>
                </tr>
            @endforeach
            @if (count($componentLvl3) == 0)
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
    // Start init lvl3

    lvl3_code = '{{$code}}';

    function deleteItemType(id){
        comp_ids = [id];
    }

    $('#chkall_lvl3').change(function() {

        

        comp_ids = [];

        $('[name="chk_lvl3"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_lvl3"]:checked').map(function() {
            comp_ids.push(parseInt(this.value));
        });

        if (comp_ids.length > 0) {
            $('[xaction="delete_selected_lvl3"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_lvl3"]').prop('disabled', true);
        }
    });

    $('[name="chk_lvl3"]').change(function() {
        console.log(this);
        comp_ids = [];

        $('input[name="chk_lvl3"]:checked').map(function() {
            comp_ids.push(parseInt(this.value));
        });

        if (comp_ids.length > 0) {
            $('[xaction="delete_selected_lvl3"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_lvl3"]').prop('disabled', true);
        }

    });

    function save_lvl3(){
        let id = $('[name="lvl3-id"]').val();
        let lvl2_id = $('#lvl3Modal #lvl2-id').val();
        let name = $('[name="lvl3-name"]').val();
        let action = $('#lvl3Modal #action').val();

        let data = {
            lvl: 3,
            action: action,
            lvl2_id: lvl2_id,
            id: id,
            name: name
        }

        vehicleComponentAction(data);
    }

    $('[xaction="delete_selected_lvl3"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val(3);
    });

    $('[xaction="close_lvl3"]').on('click', function(){
        $('#lvl3Modal #message-container').hide();
    });

    // End init lvl3
</script>
