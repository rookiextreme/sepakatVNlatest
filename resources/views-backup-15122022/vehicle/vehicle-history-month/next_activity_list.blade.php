@foreach ($eventHistoryList as $event)
<ul class="list-group">
    <li class="text-center list-group-item cursor-pointer mb-1" onmouseover="$(this).css('color', 'orange')" onmouseout="$(this).css('color', 'black')" onclick="parent.openPgInFrame('{{route('vehicle.register', [ 'id' => $event->vehicle_id,'fleet_view' => $fleet_view])}}')">{{$event->hasEvent()->desc}}</li>
</ul>
@endforeach