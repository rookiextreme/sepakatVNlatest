
<div class="text-center">
    <h3>Senarai Semakan Pemeriksaan Kenderaan yang telah gagal</h3>
</div>

@php
    $index = 0;
@endphp

@foreach ($list as $lvl1)

<ul style="list-style: none;">
    @if(count($lvl1->hasFormComponentCheckListFailedLvl2) > 0)
    <li>
        <label for="" class="form-label">{{$index + 1}}. {{$lvl1->hasComponentLvl1->component}}</label>
    </li>
        <ul style="list-style: none;">
            @foreach ($lvl1->hasFormComponentCheckListFailedLvl2 as $index2 => $lvl2)
            <li>
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Semakan</label>
                        <div>
                            {{$index + 1}}.{{$index2 + 1}}. {{$lvl2->hasComponentLvl2->component}}
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Catatan</label>
                        <div>
                            {{$lvl2->note}}
                        </div>
                    </div>
                </div>
            </li>
            <ul style="list-style: none;">
                @foreach ($lvl2->hasFormComponentCheckListFailedLvl3 as $index3 => $lvl3)
                <div class="row">
                    <div class="col-6">
                        <label for="" class="form-label">Semakan</label>
                        <div>
                            {{$index + 1}}.{{$index2 + 1}}.{{$index3 + 1}}.&nbsp;{{$lvl3->hasComponentLvl3->component}}
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="" class="form-label">Catatan</label>
                        <div>
                            {{$lvl3->note}}
                        </div>
                    </div>
                </div>
                @endforeach
            </ul>
            @endforeach
            
        </ul>
    @endif
</ul>
    
@endforeach