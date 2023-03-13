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
                <a data-sort-by="{{$sort_by}}" data-sort-field="{{$sort_field}}" class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" onclick="loadUserPage({{$paginator->onFirstPage() ? $paginator->onFirstPage() : 0}}, '{{$register_purpose}}', this)">Pertama</a>
            </li>
            <li class="me-1">
                <a data-sort-by="{{$sort_by}}" data-sort-field="{{$sort_field}}" class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" onclick="loadUserPage({{$paginator->currentPage()-1}}, '{{$register_purpose}}', this)">Sebelum</a>
            </li>
            <li class="ms-1">
                <a data-sort-by="{{$sort_by}}" data-sort-field="{{$sort_field}}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm btn-primary text-white text-decoration-none cursor-pointer" onclick="loadUserPage({{$paginator->currentPage()+1}}, '{{$register_purpose}}', this)" >Selepas</a>
            </li>
            <li class="ms-1">
                <a data-sort-by="{{$sort_by}}" data-sort-field="{{$sort_field}}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm btn-primary text-white text-decoration-none cursor-pointer" onclick="loadUserPage({{$paginator->lastPage() }}, '{{$register_purpose}}', this)" >Akhir</a>
            </li>
        </ul>
    @endif
</div>
