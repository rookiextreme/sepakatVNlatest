<div class="col-md-11 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px;">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionSubCategoryType(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#subCategoryTypeModal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Jenis</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-subcategorytype-code" value="{{ $code }}">
            @foreach ($subCategoryTypes as $subCategoryType)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionSubCategoryType(this, 'update')"
                            data-id="{{ $subCategoryType->id }}" data-code="{{ $subCategoryType->code }}"
                            data-name="{{ $subCategoryType->name }}" data-bs-toggle="modal"
                            data-bs-target="#subCategoryTypeModal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemType({{$subCategoryType->id}})" class="btn cux-btn small" xaction="delete_selected_subcategorytype" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $subCategoryType->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionSubCategoryType(this, 'update')"
                            data-id="{{ $subCategoryType->id }}" data-code="{{ $subCategoryType->code }}"
                            data-name="{{ $subCategoryType->name }}" data-bs-toggle="modal"
                            data-bs-target="#subCategoryTypeModal">{{ $subCategoryType->name }}</a></td>
                </tr>
            @endforeach
            @if (count($subCategoryTypes) == 0)
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
    // Start init subcategorytype

    function deleteItemType(id){
        subcategorytype_ids = [id];
    }

    $('#chkall_subcategorytype').change(function() {

        

        subcategorytype_ids = [];

        $('[name="chk_subcategorytype"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_subcategorytype"]:checked').map(function() {
            subcategorytype_ids.push(parseInt(this.value));
        });

        if (subcategorytype_ids.length > 0) {
            $('[xaction="delete_selected_subcategorytype"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_subcategorytype"]').prop('disabled', true);
        }
    });

    $('[name="chk_subcategorytype"]').change(function() {
        console.log(this);
        subcategorytype_ids = [];

        $('input[name="chk_subcategorytype"]:checked').map(function() {
            subcategorytype_ids.push(parseInt(this.value));
        });

        if (subcategorytype_ids.length > 0) {
            $('[xaction="delete_selected_subcategorytype"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_subcategorytype"]').prop('disabled', true);
        }

    });

    function save_subcategorytype(){
        let id = $('[name="subcategorytype-id"]').val();
        let subcategory_id = $('#subCategoryTypeModal #subcategory-id').val();
        let name = $('[name="subcategorytype-name"]').val();
        let action = $('#subCategoryTypeModal #action').val();
        console.log(action);
        subCategoryTypeAction(action, subcategory_id, id, name);
    }

    $('[xaction="delete_selected_subcategorytype"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val('subcategorytype');
    });

    $('[xaction="close_subcategorytype"]').on('click', function(){
        $('#subCategoryTypeModal #message-container').hide();
    });

    // End init subcategorytype
</script>
