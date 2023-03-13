<div class="col-md-11 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px" class="del">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionSublocation(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#sublocationModal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Lokasi Penempatan</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-sublocation-code" value="{{ $code }}">
            @foreach ($sublocations as $sublocation)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionSublocation(this, 'update')"
                            data-id="{{ $sublocation->id }}" data-code="{{ $sublocation->code }}"
                            data-name="{{ $sublocation->desc }}" data-bs-toggle="modal"
                            data-bs-target="#sublocationModal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemSublocation({{$sublocation->id}})" class="btn cux-btn small" xaction="delete_selected_sublocation" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $sublocation->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionSublocation(this, 'update')"
                            data-id="{{ $sublocation->id }}" data-code="{{ $sublocation->code }}"
                            data-name="{{ $sublocation->desc }}" data-bs-toggle="modal"
                            data-bs-target="#sublocationModal">{{ $sublocation->desc }}</a></td>
                </tr>
            @endforeach
            @if (count($sublocations) == 0)
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
    // Start init sublocation

    function deleteItemSublocation(id){
        sublocation_ids = [id];
    }

    $('#chkall_sublocation').change(function() {
        sublocation_ids = [];

        $('[name="chk_sublocation"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_sublocation"]:checked').map(function() {
            sublocation_ids.push(parseInt(this.value));
        });

        if (sublocation_ids.length > 0) {
            $('[xaction="delete_selected_sublocation"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_sublocation"]').prop('disabled', true);
        }
    });

    $('[name="chk_sublocation"]').change(function() {
        console.log(this);
        sublocation_ids = [];

        $('input[name="chk_sublocation"]:checked').map(function() {
            sublocation_ids.push(parseInt(this.value));
        });

        if (sublocation_ids.length > 0) {
            $('[xaction="delete_selected_sublocation"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_sublocation"]').prop('disabled', true);
        }

    });

    function save_sublocation(){
        let id = $('[name="sublocation-id"]').val();
        let placement_id = $('#sublocationModal #placement-id').val();
        let name = $('[name="sublocation-name"]').val();
        let action = $('#sublocationModal #action').val();
        console.log(action);
        sublocationAction(action, placement_id, id, name);
    }

    $('[xaction="delete_selected_sublocation"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val('sublocation');
    });

    $('[xaction="close_sublocation"]').on('click', function(){
        $('#sublocationModal #message-container').hide();
    });

    // End init sublocation
</script>
