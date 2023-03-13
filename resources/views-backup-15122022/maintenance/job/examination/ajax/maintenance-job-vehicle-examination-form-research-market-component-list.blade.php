@php
    $TaskFlowAccessMaintenanceJobAccess = auth()->user()->vehicleWorkFlow('02', '02');
    $hasAction = false;

    if($can_edit || $can_delete){
        $hasAction = true;
    }
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceJobAccess)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table table-bordered">
        <thead>
            <th style="width: 50px;">Bil</th>
            @if($hasAction)
                <th style="width: 90px;"></th>
            @endif
            <th>Perihal Kerja</th>
            <th class="text-center" style="width: 50px;">Kuantiti (LOT/PC)</th>
            <th class="text-center" style="width: 100px;">Harga Seunit / Set (RM)</th>
            <th class="text-center" style="width: 100px;">Jumlah Harga (RM)</th>
        </thead>
        <tbody>

            @if($componentList && $componentList->count() == 0)
                <tr class="no-record">
                    <td colspan="6" class="no-record"><i class="fas fa-info-circle"></i> Tiada rekod dijumpai</td>
                </tr>
            @endif

            @php
                $indexItem = $componentList->firstItem();
                $indexItemCopy = 0;
            @endphp
            @foreach ($componentList as $component)
            @php
                $indexItemCopy++;
            @endphp
                <tr>
                    <td>{{$indexItem++}}</td>
                    @if($hasAction)
                        <td class="text-center">
                            <div data-component="{{$component}}" class="btn-group">
                                @if($can_edit)
                                    <span onclick="editResearchMarketComponent(this)" class="btn cux-btn small"> <i class="fal fa-pen-nib"></i></span>
                                @endif
                                @if($can_delete)
                                    <span onclick="delResearchMarketComponent({{$component->id}})" class="btn cux-btn small"> <i class="fal fa-trash-alt"></i></span>
                                @endif
                            </div>
                        </td>
                    @endif
                    {{-- <div style="height: 1px; width:1px; overflow: hidden;" name="" id="copy_this_{{$component->id}}">{{$indexItemCopy}}. KERJA-KERJA MEMBUKA, MEROMBAK RAWAT, MENGENALPASTI DAN MEMASANG ALAT GANTI BARU BAGI {{$component->hasRefComponentLvl1?$component->hasRefComponentLvl1->component:''}} SEHINGGA SEMPURNA <br/><br/> @if($component->hasManyResearchMarketComponent->count()>0)@foreach ($component->hasManyResearchMarketComponent as $componentSub)@switch($componentSub->lvl)@case(2){{$indexItemCopy}}.{{$loop->index+1}}. {{$componentSub->hasCompLvl2->component}} <br/>@break @case(3){{$indexItemCopy}}.{{$loop->index+1}}. {{$componentSub->hasCompLvl3->component}} <br/>@break @default @endswitch @endforeach @endif </div> --}}
                    <div style="height: 1px; width:1px; overflow: hidden;" name="" id="copy_this_{{$component->id}}">{{$indexItemCopy}}. {{$component && $component->detail ? $component->detail : ''}} <br/><br/>
                        @if($component && $component->hasManyResearchMarketComponent->count()>0)
                            @foreach ($component->hasManyResearchMarketComponent as $componentSub)
                                @switch($componentSub->lvl) 
                                    @case(2)@if($componentSub->hasCompLvl2){{$indexItemCopy}}.{{$loop->index+1}}. {{$componentSub->hasCompLvl2->component}} <br/>@endif
                                        @break 
                                    @case(3)@if($componentSub->hasCompLvl3){{$indexItemCopy}}.{{$loop->index+1}}. {{$componentSub->hasCompLvl3->component}} <br/>@endif
                                        @break 
                                    @default 
                                @endswitch 
                            @endforeach 
                        @endif
                    </div>
                    <td class="text-uppercase">
                        {{$component && $component->detail ? $component->detail : ' '}} <br>
                        SISTEM DIPILIH :{{$component && $component->hasRefComponentLvl1 ? $component->hasRefComponentLvl1->component:''}}
                        {{-- <textarea class="form-control" style="resize:none; height: 150px;" name="job_detail" id="job_detail_component_id_{{$component->id}}" cols="30" rows="10">KERJA-KERJA MEMBUKA, MEROMBAK RAWAT, MENGENALPASTI DAN MEMASANG ALAT GANTI BARU BAGI {{$component->hasRefComponentLvl1?$component->hasRefComponentLvl1->component:''}} SEHINGGA SEMPURNA</textarea> --}}
                        <br/>
                        @if($can_edit)
                            <div class="btn-group mt-2">
                                <span onclick="addMaintenanceVehicleResearchMarketFormComponentSub({{$component->id}},{{$component->hasRefComponentLvl1->id}})" class="btn cux-btn small"> <i class="fal fa-plus"></i> Sub Komponen</span>
                            </div>
                        @endif
                        @if($component && $component->hasManyResearchMarketComponent->count()>0)
                            <ul class="sub-component mt-2">
                                @foreach ($component->hasManyResearchMarketComponent as $componentSub)
                                    @switch($componentSub->lvl)
                                        @case(2)
                                            @if($componentSub->hasCompLvl2)
                                                <li class="mb-1">
                                                    <div class="btn-group d-inline">
                                                        @if($can_delete)
                                                            <span class="btn cux-btn small" onclick="delResearchMarketComponentSub({{$componentSub->id}})">
                                                                <i class="fal fa-trash-alt"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <label for="" class="form-label d-inline" style="line-height: 22px;">
                                                        {{$componentSub->hasCompLvl2->component}}
                                                    </label>
                                                </li>
                                            @endif
                                            @break
                                        @case(3)
                                            @if($componentSub->hasCompLvl3)
                                                <li class="mb-1">
                                                    <div class="btn-group d-inline">
                                                        @if($can_delete)
                                                            <span class="btn cux-btn small" onclick="delResearchMarketComponentSub({{$componentSub->id}})">
                                                                <i class="fal fa-trash-alt"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <label for="" class="form-label d-inline" style="line-height: 22px;">
                                                        {{$componentSub->hasCompLvl3->component}}
                                                    </label>
                                                </li>
                                            @endif
                                            @break
                                        @default
                                            
                                    @endswitch
                                @endforeach
                            </ul>
                        @endif
                        <div class="btn-group mt-2 float-end">
                            <span class="btn cux-btn small" onclick="copyDivToClipboard('copy_this_{{$component->id}}')">Salin</span>
                        </div>
                    </td>
                    <td class="text-center">
                        @if($can_edit)
                            <input class="form-control" type="text" data-id="{{$component->id}}" data-quantity="{{$component->quantity}}" onchange="selfRecalculate(this, {{$component->id}})" name="quantity" id="quantity_component_id_{{$component->id}}" value="{{$component->quantity}}">
                        @else
                            <label class="form-label mt-0 pt-0">{{number_format($component->quantity,0)}}</label>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        @if($can_edit)
                        <input class="form-control" type="text" data-id="{{$component->id}}" onkeypress="return isNumber(this)" onchange="selfRecalculate(this, {{$component->id}})" data-name="per_unit" name="per_unit" id="per_unit_component_id_{{$component->id}}" value="{{$component->per_price}}">
                        @else
                        <label class="form-label mt-0 pt-0">{{number_format($component->per_price,2)}}</label>
                        @endif
                    </td>
                    <td style="text-align: right;">
                        <input class="input_total_price_component" type="hidden" id="input_total_price_component_id_{{$component->id}}" value="{{$component->quantity*$component->per_price}}"/>
                        <label class="form-label mt-0 pt-0" id="total_price_component_id_{{$component->id}}">{{number_format($component->quantity*$component->per_price, 2)}}</label>
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{-- <tfoot>
            <th style="width: 50px;">Bil</th>
            <th style="width: 90px;"></th>
            <th>Perihal Kerja</th>
            <th class="text-center" style="width: 50px;">Kuantiti (LOT/PC)</th>
            <th class="text-center" style="width: 100px;">Harga Seunit / Set (RM)</th>
            <th class="text-center" style="width: 100px;">Jumlah Harga (RM)</th>
        </tfoot> --}}
    </table>
    <div class="float-end mb-2 mt-1">
        <label for="" class="form-label d-inline fs-6">JUMLAH ANGGARAN HARGA (RM)</label>
        <label class="ms-2 form-label d-inline fs-6" id="grandTotal">{{$formRepair ? number_format($formRepair->price_budget, 2) : null}}</label>
    </div>
</div>
{{$componentList->links('pagination.ajax-maintenance-job-form-research-market-component')}}

<script type="text/javascript">

    var ids = [];
    var currentrmcCurrentpage = {{$page ?:0}};
    var currentTotal = {{$currentTotal ?: 0}};
    var nextTotal = {{$nextTotal ?: 0}};

    // function copyToClipboard(element) {
    //     var $temp = $("<input>");
    //     $("body").append($temp);
    //     $('#response').html('<span class="text-success">Berjaya Disalin</span>').fadeIn(500).fadeOut(2000);
    //     $temp.val($(element).text()).select();
    //     document.execCommand("copy");
    //     $temp.remove();
    // }

    function copyDivToClipboard(target) {
        var range = document.createRange();
        range.selectNode(document.getElementById(target));
        window.getSelection().removeAllRanges(); // clear current selection
        window.getSelection().addRange(range); // to select text
        document.execCommand("copy");
        window.getSelection().removeAllRanges();// to deselect
        $('#response').html('<span class="text-success">Berjaya Disalin</span>').fadeIn(500).fadeOut(2000);
    }

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }

    $(document).ready(function(){

    $('.foremen').select2({
        'width': "100%",
        'theme': "classic"
    }).on('change', function(e){
        e.preventDefault();

        let vehicle_id = $(this).attr('data-vehicle-id');
        let forment_id = this.value;
        assignToFormen(vehicle_id, forment_id);
    });

    $('[name="chkall"]').change(function() {

        $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

        $('[name="chkall"]').change(function() {

            $('[name="chkdel"]').prop('checked', $(this).is(':checked'));
            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }

        });

        $('[name="chkdel"]').change(function() {

            $('#delete_all').prop('disabled', true);

            getCurrentChecked();
            if(ids.length == $('[name="chkdel"]').length){
                $('#chkall').prop('checked', true);
            } else {
                $('#chkall').prop('checked', false);
            }

            if(ids.length > 0){
                $('#delete_all').prop('disabled', false);
            }
        });

    });
</script>
