<div class="col-md-11 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px" class="del">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionSubCategory(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#subCategoryModal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Sub Kategori</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-subcategory-code" value="{{ $code }}">
            @foreach ($subCategories as $subCategory)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionSubCategory(this, 'update')"
                            data-id="{{ $subCategory->id }}" data-code="{{ $subCategory->code }}"
                            data-name="{{ $subCategory->name }}" data-bs-toggle="modal"
                            data-bs-target="#subCategoryModal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemSubCategory({{$subCategory->id}})" class="btn cux-btn small" xaction="delete_selected_subcategory" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $subCategory->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionSubCategory(this, 'update')"
                            data-id="{{ $subCategory->id }}" data-code="{{ $subCategory->code }}"
                            data-name="{{ $subCategory->name }}" data-bs-toggle="modal"
                            data-bs-target="#subCategoryModal">{{ $subCategory->name }}</a></td>
                    <td style="width: 30px" class="text-end"
                        onclick="displaySubCategoryType(this, {{ $subCategory->category_id }}, {{ $subCategory->id }},'{{ $subCategory->code }}', '{{ $subCategory->name }}')">
                        <i id="angle" class="fa fa-angle-up fa-2x"></i></td>
                </tr>
                <tr xsubcategorylist="subcategory_id_{{$subCategory->id}}_sub_category_type"></tr>
            @endforeach
            @if (count($subCategories) == 0)
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

    function deleteItemSubCategory(id){
        subcategory_ids = [id];
    }

    $('#chkall_subcategory').change(function() {
        subcategory_ids = [];

        $('[name="chk_subcategory"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_subcategory"]:checked').map(function() {
            subcategory_ids.push(parseInt(this.value));
        });

        if (subcategory_ids.length > 0) {
            $('[xaction="delete_selected_subcategory"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_subcategory"]').prop('disabled', true);
        }
    });

    $('[name="chk_subcategory"]').change(function() {
        console.log(this);
        subcategory_ids = [];

        $('input[name="chk_subcategory"]:checked').map(function() {
            subcategory_ids.push(parseInt(this.value));
        });

        if (subcategory_ids.length > 0) {
            $('[xaction="delete_selected_subcategory"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_subcategory"]').prop('disabled', true);
        }

    });

    function save_subcategory(){
        let id = $('[name="subcategory-id"]').val();
        let category_id = $('#subCategoryModal #category-id').val();
        let name = $('[name="subcategory-name"]').val();
        let action = $('#subCategoryModal #action').val();
        console.log(action);
        subCategoryAction(action, category_id, id, name);
    }

    $('[xaction="delete_selected_subcategory"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val('subcategory');
    });

    $('[xaction="close_subcategory"]').on('click', function(){
        $('#subCategoryModal #message-container').hide();
    });

    // End init SubCategory
</script>
