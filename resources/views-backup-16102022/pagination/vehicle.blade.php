@php
    $params = "";
    if(request('xmode')){
        $params = "&xmode=".request('xmode');
    }
    if(request('fleet_view')){
        $params = $params."&fleet_view=".request('fleet_view');
    }

    if(request('ownership')){
        $params = $params."&ownership=".request('ownership');
    }
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
            <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="parent.startLoading()" href="{{ $paginator->url($paginator->onFirstPage()).$params }}"><i class="fa fa-arrow-to-left"></i></a>
            <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="parent.startLoading()" href="{{ $paginator->url($paginator->currentPage()-1).$params }}"><i class="fa fa-arrow-left"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="parent.startLoading()" href="{{ $paginator->url($paginator->currentPage()+1).$params }}" ><i class="fa fa-arrow-right"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="parent.startLoading()" href="{{ $paginator->url($paginator->lastPage()).$params }}" ><i class="fa fa-arrow-to-right"></i></a>
        </div>
        <!--<ul class="pagination">
            <li class="me-1">
                <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" href="{{ $paginator->url($paginator->onFirstPage()).$params }}"> <i class="fas fa-step-backward"></i></a>
            </li>
            <li class="me-1">
                <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" href="{{ $paginator->url($paginator->currentPage()-1).$params }}">Sebelum</a>
            </li>
            {{-- @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="ms-1 me-1">
                    <a class="{{ ($paginator->currentPage() == $i) ? ' disabled' : '' }} btn btn-sm btn-secondary text-white text-decoration-none cursor-pointer" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor --}}
            <li class="ms-1">
                <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" href="{{ $paginator->url($paginator->currentPage()+1).$params }}" >Selepas</a>
            </li>
            <li class="ms-1">
                <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" href="{{ $paginator->url($paginator->lastPage()).$params }}" >Page Akhir</a>
            </li>
        </ul>-->
    @endif
</div>
