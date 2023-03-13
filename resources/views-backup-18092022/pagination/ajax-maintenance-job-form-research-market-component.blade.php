<div class="float-start">
    @if($paginator->total() > 0)
    Dari
    {{$paginator->firstItem()}}
    Hingga
    {{$paginator->lastItem()}}
    Daripada {{$paginator->total()}}
    @endif
</div>
@php
    $form_id = Request('form_id') ? Request('form_id') : null;
    $jve_form_repair_id = Request('jve_form_repair_id') ? Request('jve_form_repair_id') : null;
    $can_edit = Request('can_edit') ? Request('can_edit') : null;
    $can_delete = Request('can_delete') ? Request('can_delete') : null;

    Log::info("can edit=>" .$can_edit);
    Log::info("can delete=>" .$can_delete);

@endphp
<div class="float-end">
    @if($paginator->total() > 0)
        <div class="btn-group" class="pagination">
            <a class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadMaintenanceJobFormResearchMarketComponentPage('{{ $paginator->url($paginator->onFirstPage()) }}&form_id={{$form_id}}&jve_form_repair_id={{$jve_form_repair_id}}&can_edit={{$can_edit}}&can_delete={{$can_delete}}')"><i class="fa fa-arrow-to-left"></i></a>
            <a class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadMaintenanceJobFormResearchMarketComponentPage('{{ $paginator->url($paginator->currentPage()-1) }}&form_id={{$form_id}}&jve_form_repair_id={{$jve_form_repair_id}}&can_edit={{$can_edit}}&can_delete={{$can_delete}}')"><i class="fa fa-arrow-left"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadMaintenanceJobFormResearchMarketComponentPage('{{ $paginator->url($paginator->currentPage()+1) }}&form_id={{$form_id}}&jve_form_repair_id={{$jve_form_repair_id}}&can_edit={{$can_edit}}&can_delete={{$can_delete}}')"><i class="fa fa-arrow-right"></i></a>
            <a class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadMaintenanceJobFormResearchMarketComponentPage('{{ $paginator->url($paginator->lastPage()) }}&form_id={{$form_id}}&jve_form_repair_id={{$jve_form_repair_id}}&can_edit={{$can_edit}}&can_delete={{$can_delete}}')"><i class="fa fa-arrow-to-right"></i></a>
        </div>
    @endif
</div>


