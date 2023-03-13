<div class="float-start">
    @if($paginator->total() > 0)
    Dari
    {{$paginator->firstItem()}}
    Hingga
    {{$paginator->lastItem()}}
    Daripada {{$paginator->total()}}
    @else

    @endif
</div>
<div class="float-end">
    @if($paginator->total() > 0)
        <div class="btn-group" class="pagination">
            <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehicleTypePage('{{ $paginator->url($paginator->onFirstPage()) }}')"><i class="fa fa-arrow-to-left"></i></a>
            <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehicleTypePage('{{ $paginator->url($paginator->currentPage()-1) }}')"><i class="fa fa-arrow-left"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehicleTypePage('{{ $paginator->url($paginator->currentPage()+1) }}')" ><i class="fa fa-arrow-right"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadVehicleTypePage('{{ $paginator->url($paginator->lastPage()) }}')" ><i class="fa fa-arrow-to-right"></i></a>
        </div>
    @endif
</div>
