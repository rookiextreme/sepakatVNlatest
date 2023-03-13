<script type="text/javascript">
    var search = "";
    var page = 0;
    var filterByRole = "{{$filter_by_role}}";

    function getUser_{{$field_name}}(currentPage){
        page = currentPage;
        $.get("{{route('ajax.lookup.users')}}", {field_name: "{{$field_name}}", search: search, page: page, filter_by_role: "{{$filter_by_role}}"},  function(data){
            $('[xusers_{{$field_name}}]').html(data);
        });
    }

    function searching_{{$field_name}}(text){
        if(event.key === 'Enter' || text == '') {
            search = text;
            getUser_{{$field_name}}();
        }
    }

    function disableBtnSubmit_{{$field_name}}(){
        $('form :submit').prop("disabled", true);
    }

    function undisableBtnSubmit_{{$field_name}}(){
        $('form :submit').prop("disabled", false);
        $('[name="search"]').val("");
        search = "";
        getUser_{{$field_name}}();
    }

    function selectUser_{{$field_name}}(user_id, user_fullname){
        let fieldName = '{{$field_name}}';
        $('#user_display_'+fieldName).val(user_fullname);
        $('[name="'+fieldName+'"]').val(user_id);
        $('#UserModal_'+fieldName).modal('hide');
        undisableBtnSubmit_{{$field_name}}();
    }
</script>
<style type="text/css">
body {
    background-color: #f4f5f2;
}
.modal-content {
    position: relative;
}
.close-modal-local {
    position: absolute;
    right:15px;
    top:15px;
    width:30px;
    height:30px;
    text-align: center;
    padding-top:5px;
    z-index: 100;
    cursor: pointer;
}
.close-modal-local:hover {
    background-color:#bdbdb3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
}
</style>
<div onclick="disableBtnSubmit_{{$field_name}}()" class="input-group" aria-readonly="" data-bs-toggle="modal" data-bs-target="#UserModal_{{$field_name}}">
    @if($is_display == 1)
        {{$data_name}}
        @else
        <input type="text" readonly disabled id="user_display_{{$field_name}}" class="form-control cursor-pointer"
        value="{{$data_name}}">
        <input type="hidden" id="{{$field_name}}" name="{{$field_name}}" class="form-control cursor-pointer"
            value="{{$field_value}}">
        <span class="input-group-text"><i class="fa fa-user"></i></span>
    @endif
</div>

<div class="modal fade" id="UserModal_{{$field_name}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="UserModal_{{$field_name}}_Label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="close-modal-local fa-lg" data-bs-dismiss="modal">
                <i class="fa fa-times"></i>
            </div>
            <div class="modal-body pt-1">
                <h3 class="mytitle">{{$title}}</h3>
                <p class="text-muted">{{$sub_title}}</p><hr>
                <div class="row">
                    <div class="col-12 input-group">
                        <input type="search" onkeyup="searching_{{$field_name}}(this.value)" name="search" class="form-control" placeholder="{{$sub_title}}">
                        <span class="input-group-text" id="enter" style="display: none">Enter</span>
                    </div>
                    <div class="col-12">
                        <div stye="background-color:#ffffff" class="table-responsive" xusers_{{$field_name}}></div>
                    </div>
                </div>
            </div>

      </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        getUser_{{$field_name}}();
    });
</script>
