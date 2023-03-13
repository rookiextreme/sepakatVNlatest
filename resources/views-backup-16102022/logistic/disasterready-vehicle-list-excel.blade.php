@php
    use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
    $DisasterReadyDAO = new DisasterReadyDAO();
@endphp

<div class="table-responsive pt-0">
    <table id="disasterready_vehicle-ls" style="width: 100%;" border="1" cellpadding="2" class="table-custom mt-0 no-footer stripe" data-order='[[ 3, "asc" ]]' data-page-length='10'>
        <thead>
            <tr>
                <th colspan="7" style="height: 60px;font-size: 20px; font-weight: bold;  word-wrap: break-word;">
                   Senarai Kenderaan Siap Siaga Bencana Di JKR Woksyop Sehingga {{\Carbon\Carbon::now()->format('d F Y')}}
                </th>
            </tr>
            <tr class="head">
                <th style="background-color: #ffeebc; height: 30px;">Bil</th>
                <th style="background-color: #ffeebc; height: 30px;">CKMN</th>
                <th style="background-color: #ffeebc; height: 30px;" >No. Pendaftaran</th>
                <th style="background-color: #ffeebc; height: 30px;">Hak Milik</th>
                <th style="background-color: #ffeebc; height: 30px;">Jenis</th>
                <th style="background-color: #ffeebc; height: 30px;">Pembuat</th>
                <th style="background-color: #ffeebc; height: 30px;">Model</th>
            </tr>
        </thead>
        <tbody id="sortable">
            @foreach($list as $index => $key)

            <tr>
                <td rowspan="{{$key->total}}">{{$index + 1}}</td>
                <td rowspan="{{$key->total}}">{{$key->state_name}}</td>
                @foreach ($DisasterReadyDAO->hasManyDisasterReady($key->id) as $index1 => $disasterready_vehicle)
                    @if($index1 == 0)
                        <td>
                            {{$disasterready_vehicle->no_pendaftaran}}
                        </td>
                        <td>{{$disasterready_vehicle->hasOwnerType->desc_bm}}</td>
                        <td>{{$disasterready_vehicle->hasSubCategoryType() ?
                                $disasterready_vehicle->hasSubCategoryType()->hasSubCategory->hasCategory->name 
                                .' / '.
                                $disasterready_vehicle->hasSubCategoryType()->hasSubCategory->name 
                                .' / '.
                                $disasterready_vehicle->hasSubCategoryType()->name : '-'}}</td>
                        <td class="text-uppercase">{{$disasterready_vehicle->hasBrand() ? $disasterready_vehicle->hasBrand()->name : '-'}}</td>
                        <td class="text-uppercase">{{$disasterready_vehicle->hasVehicleModel() ? $disasterready_vehicle->hasVehicleModel()->name : '-'}}</td>
                        @break
                    @endif
                @endforeach
                
            </tr>
            @foreach ($DisasterReadyDAO->hasManyDisasterReady($key->id) as $index2 => $disasterready_vehicle)
                @if($index2 != 0)
                <tr>
                    <td>
                        {{$disasterready_vehicle->no_pendaftaran}}
                    </td>
                    <td>{{$disasterready_vehicle->hasOwnerType->desc_bm}}</td>
                            <td>{{$disasterready_vehicle->hasSubCategoryType() ?
                                    $disasterready_vehicle->hasSubCategoryType()->hasSubCategory->hasCategory->name 
                                    .' / '.
                                    $disasterready_vehicle->hasSubCategoryType()->hasSubCategory->name 
                                    .' / '.
                                    $disasterready_vehicle->hasSubCategoryType()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasBrand() ? $disasterready_vehicle->hasBrand()->name : '-'}}</td>
                            <td class="text-uppercase">{{$disasterready_vehicle->hasVehicleModel() ? $disasterready_vehicle->hasVehicleModel()->name : '-'}}</td>
                </tr>
                @endif
            @endforeach
                
            @endforeach
            
        </tbody>
    </table>
</div>