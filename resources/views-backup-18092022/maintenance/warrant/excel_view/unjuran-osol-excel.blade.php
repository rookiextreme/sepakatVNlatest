<style>

.red-cell{
    background-color:red;
    color: white;

}
</style>

<div class="detailing" style='overflow-x: scroll;'>
    <table><tr><td  colspan='13' ><div class="small-title" style='margin-bottom:15px'>UNJURAN PERBELANJAAN MHPV BAGI TAHUN {{$selectedYear}}</div></td></tr></table>
    <table>
        <tr> 
            <td class="col-mth header-depreciation main">UNJURAN</td>

            @foreach ($osolProjectionSet as $osolItem)
            <td class="col-mth header-depreciation" >{{$osolItem->month}}</td>
            @endforeach

        </tr>
        <tbody>
            
            <tr>
                <td class="row-item table-item footer-table main" style="text-transform:uppercase">UNJURAN DITETAPKAN</td>
                @foreach ($osolProjectionSet as $osolItem)
                <td class="row-item table-item cursor-pointer edit-add-item-projection" data-id = "{{$osolItem->value}}" style="text-transform:uppercase">{{$osolItem->percent}}%</td>
                @endforeach
            </tr>
                <tr>
                    <td class="row-item table-item main" style="text-transform:uppercase">26000</td>
                    @foreach ($osol26Projectionpercent as $osolItem)
                    <td class="row-item table-item {{$osolItem < $osolProjectionSet[$loop->index]->percent ? "red-cell":""}}"  style="text-transform:uppercase" >{{$osolItem}}%</td>
                    @endforeach
                </tr>
                <tr>
                    <td class="row-item table-item main" style="text-transform:uppercase">28000</td>
                    @foreach ($osol28Projectionpercent as $osolItem)
                    <td class="row-item table-item {{$osolItem < $osolProjectionSet[$loop->index]->percent ? "red-cell":""}}"  style="text-transform:uppercase" >{{$osolItem}}%</td>
                    @endforeach
                </tr>
            
        </tbody>
    </table>
</div>