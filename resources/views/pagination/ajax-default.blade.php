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
    $assessment_new_id = Request('assessment_new_id') ? Request('assessment_new_id') : null;
    $assessment_safety_id = Request('assessment_safety_id') ? Request('assessment_safety_id') : null;
    $assessment_accident_id = Request('assessment_accident_id') ? Request('assessment_accident_id') : null;
    $assessment_currvalue_id = Request('assessment_currvalue_id') ? Request('assessment_currvalue_id') : null;
    $assessment_gov_loan_id = Request('assessment_gov_loan_id') ? Request('assessment_gov_loan_id') : null;
@endphp
<div class="float-end">
    @if($paginator->total() > 0)
        <div class="btn-group" class="pagination">
            <a data-target-div="{{$targetDivList}}" class="{{ ($paginator->currentPage() == $paginator->onFirstPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadPage('{{ $paginator->url($paginator->onFirstPage()) }}&assessment_new_id={{$assessment_new_id}}&assessment_accident_id={{$assessment_accident_id}}&assessment_currvalue_id={{$assessment_currvalue_id}}&assessment_gov_loan_id={{$assessment_gov_loan_id}}', this)"><i class="fa fa-arrow-to-left"></i></a>
            <a data-target-div="{{$targetDivList}}" class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadPage('{{ $paginator->url($paginator->currentPage()-1) }}&assessment_new_id={{$assessment_new_id}}}&assessment_accident_id={{$assessment_accident_id}}&assessment_currvalue_id={{$assessment_currvalue_id}}&assessment_gov_loan_id={{$assessment_gov_loan_id}}', this)"><i class="fa fa-arrow-left"></i></a>
            <a data-target-div="{{$targetDivList}}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadPage('{{ $paginator->url($paginator->currentPage()+1) }}&assessment_new_id={{$assessment_new_id}}}&assessment_accident_id={{$assessment_accident_id}}&assessment_currvalue_id={{$assessment_currvalue_id}}&assessment_gov_loan_id={{$assessment_gov_loan_id}}', this)" ><i class="fa fa-arrow-right"></i></a>
            <a  data-target-div="{{$targetDivList}}" class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} btn btn-sm cux-btn text-decoration-none cursor-pointer" onclick="ajaxLoadPage('{{ $paginator->url($paginator->lastPage()) }}&assessment_new_id={{$assessment_new_id}}}&assessment_accident_id={{$assessment_accident_id}}&assessment_currvalue_id={{$assessment_currvalue_id}}&assessment_gov_loan_id={{$assessment_gov_loan_id}}', this)" ><i class="fa fa-arrow-to-right"></i></a>
        </div>
    @endif
</div>

<script type="text/javascript">

    ajaxLoadPage = function(url, self){
        parent.startLoading();
        var targetDiv = $(self).data('target-div');
        $.get(url, {!! json_encode($params) !!}, function(data){
            $(targetDiv).html(data);
            parent.stopLoading();
        });
    }
</script>
