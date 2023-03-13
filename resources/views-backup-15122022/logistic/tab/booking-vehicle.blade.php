<div class="btn-group">
    <a class="btn cux-btn bigger" aria-readonly="" data-bs-toggle="modal"
    data-bs-target="#addVehicleTypeModal"><i class="fal fa-plus"></i> Jenis Kenderaan</a>
</div>
<form class="row" id="table_vehicle_type">

</form>


<script type="text/javascript">

    function ajaxLoadVehicleTypePage(url){
        parent.startLoading();
        $.get(url, function(data){
            $('#table_vehicle_type').html(data);
            parent.stopLoading();
        });
    }

    function loadBookingVehicle(){
        $.get("{{route('logistic.booking.vehicle-type.list')}}", function(result){
            $('#table_vehicle_type').html(result);
        });
    }

    function selectVehicleTypeDetail(id){
        $('#assignVehicleModal #vehicle_type_id').val(id);
    }

    $(document).ready(function(){

        loadBookingVehicle();

    })

</script>
