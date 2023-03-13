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
                <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" onclick="loadPageGov({{$paginator->onFirstPage()}})">Pertama</a>
            </li>
            <li class="me-1">
                <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" onclick="loadPageGov({{$paginator->currentPage()-1}})">Sebelum</a>
            </li>
            <li class="ms-1">
                <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm btn-primary text-white text-decoration-none cursor-pointer" onclick="loadPageGov({{$paginator->currentPage()+1}})" >Selepas</a>
            </li>
            <li class="ms-1">
                <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm btn-primary text-white text-decoration-none cursor-pointer" onclick="loadPageGov({{$paginator->lastPage() }})" >Akhir</a>
            </li>
        </ul>
    @endif
</div>
