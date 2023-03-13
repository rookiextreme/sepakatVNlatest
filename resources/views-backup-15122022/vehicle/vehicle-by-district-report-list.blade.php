<link href="{{ asset('my-assets/css/dataline.css') }}" rel="stylesheet" type="text/css">
<div class="table-responsive mt-3">
    <table class="table-line stripe w-100">
        <thead>
            <th class="p-2" style="width:30px;text-align:right"></th>
            <th class="highlight" style="width:100px;text-align:left;padding-bottom:5px">No Pendaftaran</th>
            <th style="width:auto;vertical-align:bottom;padding-bottom:5px">Cawangan</th>
        </thead>
        <tbody>
        @foreach ($getDistrictList as $vehicle)
            @php
                $cawangan = $vehicle->cawangan ? $vehicle->cawangan->name : "";
            @endphp
            <tr>
                <td style="padding-top:5px;width:30px;">{{$loop->index+1}}.</td>
                <td class="highlight"><a href="#" style="line-height: 28px" onclick="parent.openPgInFrame('{{route('vehicle.onepagedetail', ['id' => $vehicle->id, 'src' => 'map', 'state' => Request('negeri')])}}')">{{$vehicle->no_pendaftaran}}</a></td>
                <td style="padding-top:5px;line-height:18px;padding-bottom:5px">{{str_replace("CAWANGAN", "", $cawangan)}}</td>
            </tr>
        @endforeach
            <tr>
                <td style="padding-top:5px;height:5px;border-bottom-style:none"></td>
                <td class="highlight" style="height:5px;border-bottom-style:none"><a href="#" style="line-height: 28px"></a></td>
                <td style="height:5px;border-bottom-style:none"></td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>
