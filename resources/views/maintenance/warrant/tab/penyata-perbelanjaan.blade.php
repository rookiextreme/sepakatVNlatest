

<div class="dropdown inline" style="display: inline;">
    <span class="btn cux-btn bigger dropdown-toggle dd-workshop" xvalue="{{$selectedWorkshopId}}" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        {{$selectedWorkshop}}
    </span>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><h6 class="dropdown-header">PENYATA</h6></li>
        @foreach ($listWorkshop as $item)
        <li><a class="dropdown-item workshop"  valueId="{{$item->id}}" xvalue={{$item->desc}} {{ $selectedWorkshop == $item->desc ? 'style=background-color:lightgrey': ''}} onclick='change'>{{$item->desc}}</a></li>
        @endforeach
    </ul>
</div>

<div class="dropdown inline" id='warrant_selection' style="display: inline;">
    <span class="btn cux-btn bigger dropdown-toggle dd-waran" xvalue="{{$selectedWaranId}}" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        {{$selectedWaran}}
    </span>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><h6 class="dropdown-header">WARAN</h6></li>
        @foreach ($listWaranType as $item)
        <li><a class="dropdown-item waran"  valueId="{{$item->id}}" xvalue={{$item->desc}} {{ $selectedWaran == $item->desc ? 'style=background-color:lightgrey': ''}}>{{$item->desc}}</a></li>
        @endforeach
    </ul>
</div>

<div class="dropdown inline" id='osol_selection' style="display: inline;">
    <span class="btn cux-btn bigger dropdown-toggle dd-osol" xvalue=" {{$selectedOsolId}}" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
        {{$selectedOsol}}
    </span>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><h6 class="dropdown-header">OSOL</h6></li>
        @foreach ($listOsolType as $item)
        <li><a class="dropdown-item osol"  valueId="{{$item->id}}" xvalue={{$item->desc}} {{ $selectedOsol == $item->value ? 'style=background-color:lightgrey': ''}}>{{$item->value}}</a></li>
        @endforeach
    </ul>
</div>
<div class="btn-group" id='btn_search' >
    <button class="btn cux-btn bigger" type="button" id="delete_all" onclick='getStatement(this)'><i class="fa fa-search"></i> Cari</button>
</div>

<div class="small-title" style='margin-bottom:15px'>{{$selectedWaran}} - PENYATA  PERBELANJAAN TAHUN {{$selectedYear}}</div>
    <table>
        <tr>
            
            <td class="col-mth header-depreciation">Bil</td>
            <td class="col-mth header-depreciation">PERKARA</td>
            <td class="col-mth header-depreciation" >TARIKH</td>
            <td class="col-mth header-depreciation" >PERBELANJAAN (RM)</td>
            <td class="col-mth header-depreciation" >TANGUNGAN (RM)</td>
        </tr>
        <tbody>

            @if(count($listStatement)> 0)
            @foreach ($listStatement as $index => $item)
            <tr data-id = "" >
                <td class="row-item table-item">
                    {{$offset + ($index +1)}}
                </td>
                <td  class="row-item table-item" style="text-transform:uppercase">{{$item->description}}</td> 
                <td class="row-item table-item " style="text-transform:uppercase">{{\Carbon\Carbon::parse($item->date)->format('d M Y')}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$item->expense != "" ? number_format($item->expense,2):""}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$item->advance != "" ? number_format($item->advance,2):""}}</td>
            </tr>
            @endforeach
            @php
                $url = route('maintenance.warrant.table', 
                    [
                        'selectedYear' => $selectedYear, 
                        'selectedMonth' => $selectedMonth, 
                        'selectedWorkshop' => $selectedWorkshop,
                        'selectedWorkshopId' => $selectedWorkshopId,
                        'selectedWaran' => $selectedWaran,
                        'selectedWaranId' => $selectedWaranId,
                        'selectedOsolId' => $selectedOsolId,
                        'tab' => $tab,
                    ]);
            @endphp
            <tr>
                <td colspan="5">
                    <div class="row mt-2 mb-2" style="width: 100%">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 record-indicator">
                            @php
                                $totalPage = round($totalStatement[0]->count / $limit);

                                if(($totalPage * $limit) >= $totalStatement[0]->count){
                                    $totalPage = $totalPage - 1;
                                }
                            @endphp
                            {{$offset + 1}} - {{$offset + $index + 1}} Daripada {{$totalStatement[0]->count}}
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 text-end pe-0">
                            <div class="btn-group float-right" style="margin-right:-10px">
                                <button class="btn cux-btn text-decoration-none cursor-pointer" @if($page == 0) disabled @endif onclick="openPgInFrame('{{$url}}&page=0')"><i class="fas fa-fast-backward"></i></button>
                                <button class="btn cux-btn text-white text-decoration-none cursor-pointer" @if($page == 0) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$page > 0 ? $page - 1: 0}}')"><i class="fas fa-step-backward"></i></button>
                                <button class="btn cux-btn text-white text-white text-decoration-none cursor-pointer" @if($page == $totalPage) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$page + 1}}')" ><i class="fas fa-step-forward"></i></button>
                                <button class="btn cux-btn text-white text-decoration-none cursor-pointer" @if($page == $totalPage) disabled @endif onclick="openPgInFrame('{{$url}}&page={{$totalPage}}')"><i class="fas fa-fast-forward"></i></button>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @else 
            <tr>
                <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
            </tr>
            @endif
            
        </tbody>
    </table>
