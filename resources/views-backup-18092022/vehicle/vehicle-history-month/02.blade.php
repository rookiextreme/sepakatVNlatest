@php
$month = '02';
$startDay = '01';
$endDay = '09';
@endphp
<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 zmonth mth2">
    <div class="xmth">Febuary</div>
    @if (count($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay)) > 0)
        <div class="point s1">
            <div class="line l1">
                <div class="info" style="display: none">
                    <ul class="calendar">
                        @foreach ($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay) as $history)

                        @php
                            $url = "";
                            switch ($history->hasEvent()->code) {
                                case '01':
                                    $url = route('vehicle.register', [ 'id' => $detail->id, 'fleet_view' => $fleet_view ]);
                                    break;
                                case '03':
                                    $url = route('vehicle.register', [ 'id' => $detail->id, 'fleet_view' => $fleet_view ]);
                                    break;
                                case '05':
                                    $url = route('logistic.booking.list');
                                    break;
                                case '06':
                                    $url = route('vehicle.saman.rekod', ['vehicle_id' => $detail->id]);
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        @endphp
                            <li onclick='parent.openPgInFrame("{{$url}}")'>
                                <div>{{ (int) \Carbon\Carbon::parse($history->event_dt)->format('d') }}</div>
                                {{ $history->hasEvent()->desc }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @php
        $startDay = '10';
        $endDay = '19';
    @endphp
    @if (count($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay)) > 0)
        <div class="point s2">
            <div class="line l2">
                <div class="info" style="display: none">
                    <ul class="calendar">
                        @foreach ($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay) as $history)

                        @php
                            $url = "";
                            switch ($history->hasEvent()->code) {
                                case '01':
                                    $url = route('vehicle.register', [ 'id' => $detail->id, 'fleet_view' => $fleet_view ]);
                                    break;
                                case '03':
                                    $url = route('vehicle.register', [ 'id' => $detail->id, 'fleet_view' => $fleet_view ]);
                                    break;
                                case '05':
                                    $url = route('logistic.booking.list');
                                    break;
                                case '06':
                                    $url = route('vehicle.saman.rekod', ['vehicle_id' => $detail->id]);
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        @endphp
                            <li onclick='parent.openPgInFrame("{{$url}}")'>
                                <div>{{ (int) \Carbon\Carbon::parse($history->event_dt)->format('d') }}</div>
                                {{ $history->hasEvent()->desc }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @php
        $startDay = '20';
        $endDay = \Carbon\Carbon::parse($selectedYear . '-' . $month . '-' . $startDay)
            ->endOfMonth()
            ->format('d');
    @endphp
    @if (count($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay)) > 0)
        <div class="point s3">
            <div class="line l3">
                <div class="info" style="display: none">
                    <ul class="calendar">
                        @foreach ($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay) as $history)

                        @php
                            $url = "";
                            switch ($history->hasEvent()->code) {
                                case '01':
                                    $url = route('vehicle.register', [ 'id' => $detail->id, 'fleet_view' => $fleet_view ]);
                                    break;
                                case '03':
                                    $url = route('vehicle.register', [ 'id' => $detail->id, 'fleet_view' => $fleet_view ]);
                                    break;
                                case '05':
                                    $url = route('logistic.booking.list');
                                    break;
                                case '06':
                                    $url = route('vehicle.saman.rekod', ['vehicle_id' => $detail->id]);
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                        @endphp
                            <li onclick='parent.openPgInFrame("{{$url}}")'>
                                <div>{{ (int) \Carbon\Carbon::parse($history->event_dt)->format('d') }}</div>
                                {{ $history->hasEvent()->desc }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>
