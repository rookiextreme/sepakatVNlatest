<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 zmonth mth12">
    <div class="xmth">Disember</div>
    <div class="next-year">
        @if(in_array($nextYear, $years))
        <div class="nyear" onclick="parent.openPgInFrame('{{route('vehicle.history', [ 'id' => Request('id'), 'fleet_view' => $fleet_view, 'selectedYear' => $selectedYear + 1 ])}}')">{{$nextYear}} <i class="fas fa-arrow-circle-right"></i></div>
        @endif
    </div>
</div>