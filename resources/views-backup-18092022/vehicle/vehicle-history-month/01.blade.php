<div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 zmonth mth1">
    <div class="prev-year">
        @if (in_array($prevYear, $years))
            <div class="nyear"
                onclick="parent.openPgInFrame('{{ route('vehicle.history', ['id' => Request('id'), 'fleet_view' => $fleet_view, 'selectedYear' => $selectedYear - 1]) }}')">
                <i class="fas fa-arrow-circle-left"></i> {{ $prevYear }}</div>
        @endif
    </div>
    <div class="zyear">{{ $selectedYear }}</div>
    <div class="xmth">Januari</div>
    <div class="last-year">&nbsp;</div>
    @php
        $month = '01';
        $startDay = '01';
        $endDay = '09';
        $index = 0;
        $total = count($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay));
        $nextActivityList = array();
    @endphp
    <script>
        var nextActiviy_m1_s1_l1_id = [];
        var nextActiviy_m1_s2_l2_id = [];
        var nextActiviy_m1_s3_l3_id = [];
    </script>
    @if ($total > 0)
        <div class="point s1">
            <div class="line">
                <div class="info">
                    <ul class="calendar">
                        @php
                            $nextActivity = 0;
                        @endphp
                        @foreach ($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay) as $history)
                        @php
                            $index++;
                        @endphp
                        @if($index <=3)
                            <li>
                                <div>{{ (int) \Carbon\Carbon::parse($history->event_dt)->format('d') }}</div>
                                {{ $history->hasEvent()->desc }}
                            </li>
                            @else
                            @php
                                $nextActivity++;
                            @endphp
                            <script>
                                nextActiviy_m1_s1_l1_id.push({{$history->id}});
                            </script>
                        @endif
                        @if($index == $total && $total>3)
                        <li onclick="showNextActivity('m1', 's1','l1')"><div><i class="fal fa-ellipsis-h" style="filter: invert(1) grayscale(100%) brightness(200%);margin-top:4px"></i></div> {{$nextActivity}} aktiviti lagi...</li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    @php
        $startDay = '10';
        $endDay = '19';
        $index = 0;
        $nextActivity = 0;
        $total = count($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay));
    @endphp
    @if (count($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay)) > 0)
        <div class="point s2">
            <div class="line">
                <div class="info">
                    <ul class="calendar">
                        @foreach ($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay) as $history)
                        @php
                            $index++;
                        @endphp
                        @if($index <=3)
                            <li>
                                <div>{{ (int) \Carbon\Carbon::parse($history->event_dt)->format('d') }}</div>
                                {{ $history->hasEvent()->desc }}
                            </li>
                            @else
                            @php
                                $nextActivity++;
                            @endphp
                            <script>
                                nextActiviy_m1_s2_l2_id.push({{$history->id}});
                            </script>
                        @endif
                        @if($index == $total && $total>3)
                        <li onclick="showNextActivity('m1', 's2','l2')"><div><i class="fal fa-ellipsis-h" style="filter: invert(1) grayscale(100%) brightness(200%);margin-top:4px"></i></div> {{$nextActivity}} aktiviti lagi...</li>
                        @endif
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
            <div class="line">
                <div class="info">
                    <ul class="calendar">
                        @foreach ($detail->hasManyHistoryByRangeDay($selectedYear, $month, $startDay, $endDay) as $history)
                            <li>
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
