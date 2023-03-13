@php
    $state_id = Request('state_id') ? Request('state_id') : null;
    $placement_id = Request('placement_id') ? Request('placement_id') : null;
    $vehicle_type_id = Request('vehicle_type_id') ? Request('vehicle_type_id') : null;
@endphp
<div class="float-start">
    @if($paginator->total() > 0)
    Dari
    {{$paginator->firstItem()}}
    Hingga
    {{$paginator->lastItem()}}
    Daripada {{$paginator->total()}}
    @else
    Tiada Rekod
    @endif
</div>
<div class="float-end">
    @if($paginator->total() > 0)
        <div class="btn-group" class="pagination">
            <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadModalVehicleTypeUnitPage('{{ $paginator->url($paginator->onFirstPage()) }}&state_id={{$state_id}}&placement_id={{$placement_id}}&vehicle_type_id={{$vehicle_type_id}}')"><i class="fa fa-arrow-to-left"></i></a>
            <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadModalVehicleTypeUnitPage('{{ $paginator->url($paginator->currentPage()-1) }}&state_id={{$state_id}}&placement_id={{$placement_id}}&vehicle_type_id={{$vehicle_type_id}}')"><i class="fa fa-arrow-left"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadModalVehicleTypeUnitPage('{{ $paginator->url($paginator->currentPage()+1) }}&state_id={{$state_id}}&placement_id={{$placement_id}}&vehicle_type_id={{$vehicle_type_id}}')" ><i class="fa fa-arrow-right"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadModalVehicleTypeUnitPage('{{ $paginator->url($paginator->lastPage()) }}&state_id={{$state_id}}&placement_id={{$placement_id}}&vehicle_type_id={{$vehicle_type_id}}')" ><i class="fa fa-arrow-to-right"></i></a>
        </div>
    @endif
</div>
