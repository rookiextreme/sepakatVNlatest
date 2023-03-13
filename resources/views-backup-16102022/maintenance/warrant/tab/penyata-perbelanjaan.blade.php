

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
            
            <td class="col-mth header-depreciation">PERKARA</td>
            <td class="col-mth header-depreciation" >TARIKH</td>
            <td class="col-mth header-depreciation" >PERBELANJAAN (RM)</td>
            <td class="col-mth header-depreciation" >TANGUNGAN (RM)</td>
        </tr>
        <tbody>

            @if(count($listStatement)> 0)
            @foreach ($listStatement as $item)
            <tr data-id = "" >
                <td  class="row-item table-item" style="text-transform:uppercase">{{$item->description}}</td> 
                <td class="row-item table-item " style="text-transform:uppercase">{{\Carbon\Carbon::parse($item->date)->format('d M Y')}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$item->expense != "" ? number_format($item->expense,2):""}}</td>
                <td class="row-item table-item " style="text-transform:uppercase">{{$item->advance != "" ? number_format($item->advance,2):""}}</td>
            </tr>
            @endforeach
            @else 
            <tr>
                <td class="row-item table-item" style="text-transform:uppercase" colspan='12'>Tiada Maklumat</td>
            </tr>
            @endif
            
        </tbody>
    </table>
