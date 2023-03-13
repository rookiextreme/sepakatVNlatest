<div class="col-md-11 float-end">
    <table class="table mt-0" id="mytable">
        <thead>
            <tr>
                <th style="width: 80px" class="del">
                    <div class="btn-group">
                        <button class="btn cux-btn small" onclick="modalActionModel(this, 'insert')"
                            data-bs-toggle="modal" data-bs-target="#modelModal" type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-plus"></i></button>
                    </div>
                </th>
                <th>Model</th>
            </tr>
        </thead>
        <tbody>
            <input type="hidden" id="current-model-code" value="{{ $code }}">
            @foreach ($models as $model)
                <tr id="">
                    <td style="width: 80px;">
                        <div class="btn-group">
                            <span class="btn cux-btn small" onclick="modalActionModel(this, 'update')"
                            data-id="{{ $model->id }}" data-code="{{ $model->code }}"
                            data-name="{{ $model->name }}" data-bs-toggle="modal"
                            data-bs-target="#modelModal"><i
                                    class="fal fa-edit"></i></span>
                            <span onclick="deleteItemModel({{$model->id}})" class="btn cux-btn small" xaction="delete_selected_model" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" data-bs-target="" disabled type="button" data-toggle="popover"
                            data-trigger="focus" data-placement="top" data-content="Some info"><i
                                class="fal fa-trash-alt"></i></span>
                        </div>
                    </td>
                    <td style="width: 60px">{{ $model->code }}</td>
                    <td class="cfoc wd-wf key"><a href="#" onclick="modalActionModel(this, 'update')"
                            data-id="{{ $model->id }}" data-code="{{ $model->code }}"
                            data-name="{{ $model->name }}" data-bs-toggle="modal"
                            data-bs-target="#modelModal">{{ $model->name }}</a></td>
                </tr>
            @endforeach
            @if (count($models) == 0)
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
    // Start init model

    function deleteItemModel(id){
        model_ids = [id];
    }

    $('#chkall_model').change(function() {
        model_ids = [];

        $('[name="chk_model"]').prop('checked', $(this).is(':checked'));
        $('input[name="chk_model"]:checked').map(function() {
            model_ids.push(parseInt(this.value));
        });

        if (model_ids.length > 0) {
            $('[xaction="delete_selected_model"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_model"]').prop('disabled', true);
        }
    });

    $('[name="chk_model"]').change(function() {
        console.log(this);
        model_ids = [];

        $('input[name="chk_model"]:checked').map(function() {
            model_ids.push(parseInt(this.value));
        });

        if (model_ids.length > 0) {
            $('[xaction="delete_selected_model"]').prop('disabled', false);
        } else {
            $('[xaction="delete_selected_model"]').prop('disabled', true);
        }

    });

    function save_model(){
        let id = $('[name="model-id"]').val();
        let brand_id = $('#modelModal #brand-id').val();
        let name = $('[name="model-name"]').val();
        let action = $('#modelModal #action').val();
        console.log(action);
        modelAction(action, brand_id, id, name);
    }

    $('[xaction="delete_selected_model"]').on('click', function(e) {
        e.preventDefault();
        show('[xaction="delete"]');
        show('[xaction="no"]');
        hide('[xaction="close"]');
        $('#deleteModal #delete_for').val('model');
    });

    $('[xaction="close_model"]').on('click', function(){
        $('#modelModal #message-container').hide();
    });

    // End init model
</script>
