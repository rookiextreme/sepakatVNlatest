<style>

.red-cell{
    background-color:red;
    color: white;

}
</style>

<div class="detailing" style='overflow-x: scroll;'>
    <div class="small-title" style='margin-bottom:15px'>UNJURAN PERBELANJAAN MHPV BAGI TAHUN {{$selectedYear}}</div>

    <div class="row" id="unjuran-parent">
        <div class="col-6 col-md-2 pe-0" id="container-unjuran-main">
            <table style="width: 100%">
                <tbody>
                    <tr>
                        <td class="col-mth header-depreciation main label_unjuran" style="height:29px;">UNJURAN
                        <div class="btn-group float-end d-none d-md-inline-flex no-printme">
                            <button type="button" class="btn cux-btn small" onclick="scrollToLeft('container-unjuran')"><i class="fa fa-arrow-left"></i></button>
                            <button type="button" class="btn cux-btn small" onclick="scrollToRight('container-unjuran')"><i class="fa fa-arrow-right"></i></button>
                        </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="row-item table-item footer-table main" style="text-transform:uppercase">UNJURAN DITETAPKAN</td>
                    </tr>
                    <tr>
                        <td class="row-item table-item main" style="text-transform:uppercase">26000</td>
                    </tr>
                    <tr>
                        <td class="row-item table-item main" style="text-transform:uppercase">28000</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-6 col-md-10 ps-0 overflow-auto" id="container-unjuran">
            <table style="width: 100%">
                <tr>
                    @foreach ($osolProjectionSet as $osolItem)
                    <td class="col-mth header-depreciation" colspan='2' style="height: 39px;">{{$osolItem->month}}</td>
                    @endforeach

                </tr>
                <tbody>

                    <tr>
                        @foreach ($osolProjectionSet as $osolItem)
                        <td class="row-item table-item" @if($is_preview == 1) colspan="2" @endif data-id = "{{$osolItem->value}}" style="text-transform:uppercase">{{$osolItem->percent}}%</td>
                        @if($is_preview == 0)
                        <td class="table-item cursor-pointer edit-add-item-projection" data-id = "{{$osolItem->value}}" ><i class="fa fa-pencil-alt"></i></td>
                        @endif
                        @endforeach
                    </tr>
                        <tr>
                            @foreach ($osol26Projectionpercent as $osolItem)
                            <td class="row-item table-item {{$osolItem < $osolProjectionSet[$loop->index]->percent ? "red-cell":""}}"  style="text-transform:uppercase" colspan='2'>{{$osolItem}}%</td>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($osol28Projectionpercent as $osolItem)
                            <td class="row-item table-item {{$osolItem < $osolProjectionSet[$loop->index]->percent ? "red-cell":""}}"  style="text-transform:uppercase" colspan='2'>{{$osolItem}}%</td>
                            @endforeach
                        </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="detailing">
    <div class="small-title" ></div>
    <figure class="highcharts-figure">
        <div id="container"></div>
    </figure>
</div>
