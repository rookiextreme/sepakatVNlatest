@php
    $sub_category_type_id = Request('sub_category_type_id') ? Request('sub_category_type_id') : null;
    $state_id = Request('state_id') ? Request('state_id') : null;
    $placement_id = Request('placement_id') ? Request('placement_id') : null;

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
            <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehiclePage('{{ $paginator->url($paginator->onFirstPage()) }}&sub_category_type_id={{$sub_category_type_id}}&state_id={{$state_id}}&placement_id={{$placement_id}}')"><i class="fa fa-arrow-to-left"></i></a>
            <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehiclePage('{{ $paginator->url($paginator->currentPage()-1) }}&sub_category_type_id={{$sub_category_type_id}}&state_id={{$state_id}}&placement_id={{$placement_id}}')"><i class="fa fa-arrow-left"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehiclePage('{{ $paginator->url($paginator->currentPage()+1) }}&sub_category_type_id={{$sub_category_type_id}}&state_id={{$state_id}}&placement_id={{$placement_id}}')" ><i class="fa fa-arrow-right"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehiclePage('{{ $paginator->url($paginator->lastPage()) }}&sub_category_type_id={{$sub_category_type_id}}&state_id={{$state_id}}&placement_id={{$placement_id}}')" ><i class="fa fa-arrow-to-right"></i></a>
        </div>
    @endif
</div>
