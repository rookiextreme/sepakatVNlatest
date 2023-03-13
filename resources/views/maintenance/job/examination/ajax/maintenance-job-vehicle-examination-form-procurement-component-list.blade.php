@php
    $TaskFlowAccessMaintenanceJobAccess = auth()->user()->vehicleWorkFlow('02', '02');
    $mappingComp = [];
@endphp
{{-- <textarea name="" class="form-control" id="" cols="30" rows="3">@json($TaskFlowAccessMaintenanceJobAccess)</textarea> --}}
<div class="table-responsive">
    <table id="fleet-ls" class="table table-bordered">
        <thead>
            <tr style="height: 70px;">
                <td style="width: 50px;">Bil</td>
                <td>Perihal Kerja</td>
                <td class="text-center" style="width: 50px;">Kuantiti</td>
                <td class="text-center" style="width: 50px;">Harga Seunit</td>
                <td class="text-center" style="width: 50px;">Jumlah Harga</td>
            </tr>

            @foreach ($componentList as $component)
                <tr>
                    <td class="align-top" style="width: 50px;">{{$loop->index+1}}</td>
                    <td class="text-uppercase align-top">
                        <div style="height: 100px; overflow: auto;">
                            {{$component->detail}}
                            {{-- KERJA-KERJA MEMBUKA, MEROMBAK RAWAT, MENGENALPASTI DAN MEMASANG ALAT GANTI BARU BAGI {{$component->hasRefComponentLvl1?$component->hasRefComponentLvl1->component:''}} SEHINGGA SEMPURNA --}}

                            @if($component->hasManyResearchMarketComponent->count()>0)
                                <ul class="sub-component mt-2">
                                    @foreach ($component->hasManyResearchMarketComponent as $componentSub)
                                        @switch($componentSub->lvl)
                                            @case(2)
                                                    @if($componentSub->hasCompLvl2)
                                                    <li class="mb-1">
                                                        <label for="" class="form-label d-inline" style="line-height: 22px;">
                                                            {{$componentSub->hasCompLvl2->component}}
                                                        </label>
                                                    </li>
                                                    @endif
                                                @break
                                            @case(3)
                                                    @if($componentSub->hasCompLvl3)
                                                    <li class="mb-1">
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
                        </div>
                    </td>
                    <td class="align-top text-center" style="width: 50px;">{{number_format($component->quantity, 0)}}</td>
                    <td class="align-top text-center" style="width: 50px;">{{number_format($component->per_price, 2)}}</td>
                    <td class="align-top text-center" style="width: 50px;">{{number_format($component->total_price, 2)}}</td>
                </tr>
            @endforeach
            <tr style="">
                <td colspan="5">
                    <div class="float-end">
                        <label class="text-end form-label">
                            Jumlah Sebut Harga (RM)
                        </label>
                    </div>
                </td>
            </tr>
            <tr style="height: 60px;">
                <td colspan="5">
                    <div class="float-end">
                        <span class="text-end form-label">
                            Syor Pembekal <em class="text-danger">*</em>
                        </span>
                        <span class="hasErr ms-2 text-danger" id="hasErr_pro_budget_price_supl_id"></span>
                    </div>
                </td>
            </tr>
            <tr style="height: 106px;">
                <td colspan="5" class="align-top">
                    <div class="float-end">
                        <label class="text-end form-label">
                            Catatan
                        </label>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            @if($detail)
            {{-- @json($detail) --}}
            <tr style="height: 81px;">
                @foreach ($detail->hasManyExamProcurement as $procurement)
                @php
                    $mappingComp['supplier_id_'.$procurement->hasCompany->id] = 0;
                @endphp
                    <td class="align-bottom text-center" style="width: 200px;white-space: nowrap;">
                        <label for="" class="form-label">{{$procurement->hasCompany->company_name}}</label>
                    </td>
                @endforeach
            </tr>
            @endif
            @foreach ($componentList as $component)
            <tr>
                @foreach ($component->hasManyExamProcurement as $procurement)
                @php
                    if(isset($mappingComp['supplier_id_'.$procurement->hasCompany->id])){
                        $mappingComp['supplier_id_'.$procurement->hasCompany->id] += $procurement->price;
                    }
                @endphp
                    <td class="text-uppercase align-top text-end" style="width: 200px;white-space: nowrap;">
                        <div style="height: 100px; width: 100px; overflow: auto;" class="ps-1 pe-1">
                            @if($can_edit)
                                <input data-spl_id="{{$procurement->hasCompany->id}}" class="form-control" onchange="reCalculateSplComp(this); updateSplCompPrice(this, {{$procurement->id}})" type="text" id="price_supplier_id_{{$procurement->hasCompany->id}}" value="{{$procurement->price ?: 0}}" />
                                @else
                                {{number_format($procurement->price ?: 0, 2)}}
                            @endif
                        </div>
                    </td>
                @endforeach
            </tr>
            @endforeach

            @php
                $hasOneComp = $componentList->first();
            @endphp
            @if($hasOneComp)
                <tr style="height: 57px;">
                    @foreach ($hasOneComp->hasManyExamProcurement as $procurement)
                        <td style="width: 200px;white-space: nowrap;" class="text-center">
                            <span id="total_price_supplier_id_{{$procurement->hasCompany->id}}">
                                {{number_format($mappingComp['supplier_id_'.$procurement->hasCompany->id], 2)}}
                            </span>
                        </td>
                    @endforeach
                </tr>
                <tr class="text-center" style="height: 60px;">
                    @foreach ($hasOneComp->hasManyExamProcurement as $procurement)
                    <td style="width: 200px;white-space: nowrap;">
                        @if($can_edit)
                        <input {{$detail->hasFormRepair->pro_budget_price_supl_id == $procurement->hasCompany->id ? 'checked': ''}} class="form-check-input cursor-pointer" type="radio" name="pro_budget_price_supl_id" id="supplier_company_id_{{$procurement->hasCompany->id}}" value="{{$procurement->hasCompany->id}}">
                        <input type="hidden" id="pro_budget_price_{{$procurement->hasCompany->id}}" value="{{$mappingComp['supplier_id_'.$procurement->hasCompany->id]}}">
                        @else
                            @if($detail->hasFormRepair->pro_budget_price_supl_id == $procurement->hasCompany->id)
                                <i class="fa fa-check text-success"></i>
                            @endif
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr style="height: 100px;">
                    <td colspan="{{$hasOneComp->hasManyExamProcurement->count()}}">
                         @if($can_edit)
                            <textarea name="pro_budget_price_note" maxlength="100" class="form-control" style="resize: none;" id="" cols="30" rows="3">{{$detail->hasFormRepair->pro_budget_price_note}}</textarea>
                            @else
                            {!!$detail->hasFormRepair->pro_budget_price_note!!}
                        @endif
                    </td>
                </tr>
            @endif

        </tbody>
        <tfoot>
        </tfoot>
    </table>
</div>
{{--  {{$componentList->paginate(5)->links('pagination.ajax-maintenance-job-form-research-market-component')}}  --}}

<script type="text/javascript">

    var ids = [];

    $.fn.digits = function(){
        return this.each(function(){
            $(this).text( $(this).text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") );
        })
    }

    function getCurrentChecked(){
        ids = [];
        $('#chkdel:checked').map(function() {
            ids.push(parseInt(this.value));
        });

        return ids;
    }

    function remove(){
        $('#maintenanceJobVehicleDelModal #remove').hide();
        $('#maintenanceJobVehicleDelModal #close').hide();
        $.post("{{route('maintenance.job.vehicle.delete')}}", {
            ids: ids,
            '_token': '{{ csrf_token() }}'
        },  function(result){
            $('#maintenanceJobVehicleDelModal').modal('hide');
            loadMaintenanceVehicle();
        })
    }

    function updateSplCompPrice(self, id){
        let price = $(self).val();
        $.post('{{route('maintenance.job.vehicle.getVehicleForm.procurement.component.save')}}',
        {
            "_token": "{{ csrf_token() }}",
            price: price,
            id: id
        },
        function(){

        });
    }

    function reCalculateSplComp(self){
        let spl_id = $(self).data('spl_id');
        let price = $(self).val();
        let total = 0;
        $('[data-spl_id="'+spl_id+'"]').map(function(){
            total += $(this).val() ? parseFloat($(this).val()) : 0;
        });
        console.log('spl_id  ', spl_id);
        console.log('price  ', price);
        console.log('total  ', total);
        $('#pro_budget_price_'+spl_id).val(total);
        $('#total_price_supplier_id_'+spl_id).html(total.toLocaleString(undefined, {minimumFractionDigits: 2}));
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
