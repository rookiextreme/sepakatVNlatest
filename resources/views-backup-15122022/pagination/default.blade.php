@php
    $limit = Request('limit') ? Request('limit') : 5;
    $search = Request('search') ? Request('search') : null;
    $status_code = Request('status_code') ? Request('status_code') : null;
    $workshop_id = Request('workshop_id') ? Request('workshop_id') : null;
    $assessment_type = Request('assessment_type') ? Request('assessment_type') : null;
    $month = Request('month') ? Request('month') : null;
    $year = Request('year') ? Request('year') : null;
    $status = Request('status') ? Request('status') : null;
    $filterOpt = Request('filterOpt') ? Request('filterOpt') : null;
@endphp
<div class="row" style="width: 100%">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 record-indicator">
        @if($paginator->total() > 0)
        {{$paginator->firstItem()}}
        -
        {{$paginator->lastItem()}}
        daripada {{$paginator->total()}}
        @endif
    </div>
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-end pe-0">
        @if($paginator->total() > 0)
        <div class="btn-group float-right" style="margin-right:-10px">
            <button class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn cux-btn text-decoration-none cursor-pointer" onclick="parent.openPgInFrame('{{ $paginator->url($paginator->onFirstPage()) }}&limit={{$limit}}&search={{$search}}&status_code={{$status_code}}&status={{$status}}&workshop_id={{$workshop_id}}&assessment_type={{$assessment_type}}&month={{$month}}&year={{$year}}&filterOpt={{$filterOpt}}')"><i class="fas fa-fast-backward"></i></button>
            <button class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn cux-btn text-white text-decoration-none cursor-pointer" onclick="parent.openPgInFrame('{{ $paginator->url($paginator->currentPage()-1) }}&limit={{$limit}}&search={{$search}}&status_code={{$status_code}}&status={{$status}}&workshop_id={{$workshop_id}}&assessment_type={{$assessment_type}}&month={{$month}}&year={{$year}}&filterOpt={{$filterOpt}}')"><i class="fas fa-step-backward"></i></button>
            <button class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn cux-btn text-white text-white text-decoration-none cursor-pointer" onclick="parent.openPgInFrame('{{ $paginator->url($paginator->currentPage()+1) }}&limit={{$limit}}&search={{$search}}&status_code={{$status_code}}&workshop_id={{$workshop_id}}&assessment_type={{$assessment_type}}&month={{$month}}&year={{$year}}&status={{$status}}&filterOpt={{$filterOpt}}')" ><i class="fas fa-step-forward"></i></button>
            <button class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn cux-btn text-white text-decoration-none cursor-pointer" onclick="parent.openPgInFrame('{{ $paginator->url($paginator->lastPage()) }}&limit={{$limit}}&search={{$search}}&status_code={{$status_code}}&status={{$status}}&workshop_id={{$workshop_id}}&assessment_type={{$assessment_type}}&month={{$month}}&year={{$year}}&filterOpt={{$filterOpt}}')" ><i class="fas fa-fast-forward"></i></button>
        </div>
        @endif
    </div>
</div>
