<div class="main-content" style='margin-top:50px;'>
    <div class="detailing">
       <table>
            <thead>
                <tr>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" rowspan="2"> Bil</td>
                    {{-- JKR Cawangan Ibu Pejabat / Negeri --}}
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" rowspan="2">Pemilik</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" colspan="3" >Pengeluar Saman</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" rowspan="2">Jumlah Bilangan Saman</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" colspan="2">Selesai</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" colspan="2">Belum Selesai</td>
                </tr>
                <tr>

                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >PDRM</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >JPJ</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >PBT</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >Bil</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >%</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >Bil</td>
                    <td style="background-color: #a2d3f0; border: 0.5px solid black;" class="col-mth header-depreciation" >%</td>
                </tr>
            </thead>
            <tbody id="sortable_summary_branch">

                @php
                    $grandTotalPDRM = 0;
                    $grandTotalJPJ = 0;
                    $grandTotalPBT = 0;
                    $grandTotalSummon = 0;
                    $grandTotalDone = 0;
                    $grandTotalNotYet = 0;
                @endphp

                @foreach ($list as $item)
                @php
                    $pdrm = $item->hasManySummon('pdrm');
                    $jpj = $item->hasManySummon('jpj');
                    $pbt = $item->hasManySummon('pbt');
                    $totalSummon = $pdrm+$jpj+$pbt;

                    $summon_done = $item->hasManySummon('done');
                    $summon_notyet = $item->hasManySummon('notyet');

                    $grandTotalPDRM += $pdrm;
                    $grandTotalJPJ += $jpj;
                    $grandTotalPBT += $pbt;

                    $grandTotalSummon += $totalSummon;
                    $grandTotalDone += $summon_done;
                    $grandTotalNotYet += $summon_notyet;

                @endphp
                <tr class="ui-state-default" data-id="{{$item->id}}">
                    @if(auth()->user()->isAdmin())
                    <td class="cursor-pointer"><span class="dragdrop ui-icon ui-icon-arrowthick-2-n-s"></span>{{$loop->index + 1}}</td>
                    @else
                    <td>{{$loop->index + 1}}</td>
                    @endif
                    <td class="col-mth header-depreciation" style="text-align: left;" >{{$item->name}}</td>
                    <td class="col-mth header-depreciation">
                        {{$pdrm}}
                    </td>
                    <td class="col-mth header-depreciation">
                        {{$jpj}}
                    </td>
                    <td class="col-mth header-depreciation">
                        {{$pbt}}
                    </td>
                    <td class="col-mth header-depreciation">
                        {{$totalSummon}}
                    </td>
                    <td class="col-mth header-depreciation">{{$summon_done}}</td>
                    <td class="col-mth header-depreciation">{{$summon_done > 0 ? round($summon_done/$totalSummon * 100) : 0}}</td>
                    <td class="col-mth header-depreciation">{{$summon_notyet}}</td>
                    <td class="col-mth header-depreciation">{{$summon_notyet > 0 ? round($summon_notyet/$totalSummon * 100) : 0}}</td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="2" class="text-right" style="text-align: right">
                        <label for="" class="form-label text-right">JUMLAH</label>
                    </td>
                    <td class="col-mth header-depreciation">{{$grandTotalPDRM}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalJPJ}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalPBT}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalSummon}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalDone}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalDone > 0 ? round($grandTotalDone/$grandTotalSummon * 100) : 0}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalNotYet}}</td>
                    <td class="col-mth header-depreciation">{{$grandTotalNotYet > 0 ? round($grandTotalNotYet/$grandTotalSummon * 100) : 0}}</td>
                </tr>

            </tbody>
        </table>
    </div>

</div>
