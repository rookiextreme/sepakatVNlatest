<div class="table-responsive" style="width:100%;padding-left:25px;padding-right:25px;margin-top:10px;padding-bottom:5px">
    @php
        $totalKeseluruhan = 0;
    @endphp
    <table class="table-report stripe" style="width:auto">
        <thead>
            <tr>
                <th class="lcal-2 col-del" style="background-color: #BDD7EE">Bil.</th>
                <th class="lcal-5" style="background-color: #BDD7EE">JENIS / JKR WOKSYOP</th>
                @foreach ($state_list as $state)
                    <th class="lcal-4" style="background-color: #BDD7EE">{{$state->desc}}</th>
                @endforeach
                <th style="background-color: #BDD7EE">JUMLAH KESELURUHAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td colspan="{{$total_state+3}}" style="background-color: #5B9BD5; font-weight: bolder; padding: 10px; text-align: left !important;">{{$category['cat_name']}}</td>
                </tr>
                @foreach ($category['has_many_type'] as $type)
                    <tr>
                        <td>{{$loop->index +1}}</td>
                        <td>{{$type['name']}}</td>
                        {{-- @foreach ($type['has_many_state'] as $state) --}}
                        @foreach ($state_list as $ref_state_list)
                            @php
                                $total = 0;
                            @endphp
                            <td style="align-self: right">
                                @foreach ($type['has_many_state'] as $state)
                                    @php
                                        if ($state->state_id == $ref_state_list->id){
                                            $total += $state->total;
                                        }
                                    @endphp
                                @endforeach
                                {{$total}}
                            </td>
                        @endforeach
                        <td>{{$type['total']}}</td>
                        @php
                            $totalKeseluruhan += $type['total'];
                        @endphp
                    </tr>
                @endforeach
            @endforeach
                <tr>
                    <td colspan="2" style="background-color: #FCDF5E; font-weight: bold">JUMLAH</td>
                    @foreach ($listByState as $totalState)
                        <td style="background-color: #FCDF5E;">{{$totalState['total']}}</td>
                    @endforeach
                    <td style="background-color: #FCDF5E; font-weight: bold">{{$totalKeseluruhan}}</td>
                </tr>
        </tbody>
    </table>
</div>
