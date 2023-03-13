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
        <ul class="pagination">
            <li class="me-1">
                <div class="btn-group">
                    <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn bigger" onclick="getVehicleType_{{$field_name}}({{$paginator->onFirstPage()}})"><i class="fa fa-arrow-to-left"></i></a>
                    <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn bigger" onclick="getVehicleType_{{$field_name}}({{$paginator->currentPage()-1}})"><i class="fa fa-arrow-left"></i></a>
                    <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn bigger" onclick="getVehicleType_{{$field_name}}({{$paginator->currentPage()+1 }})" ><i class="fa fa-arrow-right"></i></a>
                    <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn bigger" onclick="getVehicleType_{{$field_name}}({{$paginator->lastPage()}})" ><i class="fa fa-arrow-to-right"></i></a>
                </div>
            </li>
        </ul>
    @endif
</div>
