<div class="process-stage">
    <div class="stageline">&nbsp</div>
    <div class="stagecover">&nbsp</div>
    @php
        $stage = 0;
        if (!$detail || $detail && in_array($detail->hasStatus->code, ['01'])) {
            $stage = 65;
        } else if ($detail && in_array($detail->hasStatus->code, ['02'])) {
            $stage = 150;
        } else if ($detail && in_array($detail->hasStatus->code, ['03','04'])) {
            $stage = 235;
        } else if ($detail && in_array($detail->hasStatus->code, ['05'])) {
            $stage = 320;
        } else if ($detail && in_array($detail->hasStatus->code, ['08'])) {
            $stage = 405;
        }
    @endphp
    <!--
        85px per stage

        e.g
        Stage 1 : +65px;
        Stage 2 : +150px;
        Stage 3 : +235px;
        Stage 4 : +320px;
        Stage 5 : +405px;

        stagestatus = blue line status
    -->
    <div class="stagestatus" style="width:calc(30px + {{$stage}}px);">
        <div class="cover">&nbsp</div>
    </div>
    <div class="stage">
        <div class="num {{$detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']) ? 'done': ''}}">1</div>
        <div class="stagename">Permohonan</div>
    </div>
    <div class="stage">
        <div class="num {{$detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']) ? 'done': ''}}">2</div>
        <div class="stagename">Temujanji</div>
    </div>
    <div class="stage">
        <div class="num {{$detail && in_array($detail->hasStatus->code, ['03','04','05','08']) ? 'done': ''}}">3</div>
        <div class="stagename">Penilaian</div>
    </div>
    <div class="stage">
        <div class="num {{$detail && in_array($detail->hasStatus->code, ['05','08']) ? 'done': ''}}">4</div>
        <div class="stagename">Kelulusan</div>
    </div>
    <div class="stage">
        <div class="num {{$detail && in_array($detail->hasStatus->code, ['08']) ? 'done': ''}}">5</div>
        <div class="stagename">Sijil</div>
    </div>
</div>


@if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
    <li class="cub-tab"  onClick="goTab(this, 'vehicle');" id="tab2">Kenderaan</li>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
    <li class="cub-tab"  onClick="goTab(this, 'appointment');" id="tab3">Temujanji</li>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && auth()->user()->isForemenAssessment())
    <li class="cub-tab"  onClick="goTab(this, 'assessment');" id="tab4">Penilaian</li>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['04','05','08']) && $TaskFlowAccessAssessmentAccident->mod_fleet_verify)
    <li class="cub-tab"  onClick="goTab(this, 'evaluation');" id="tab5">Semakan</li>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['05','08']) && $TaskFlowAccessAssessmentAccident->mod_fleet_approval)
    <li class="cub-tab"  onClick="goTab(this, 'approval');" id="tab6">Kelulusan</li>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['08']))
    <li class="cub-tab"  onClick="goTab(this, 'certificate');" id="tab7">Sijil</li>
@endif

@if ($detail && $detail && in_array($detail->hasStatus->code, ['01','02','03','04','05','08']))
<section id="vehicle" class="tab-content">
    @include('assessment.accident.tab.accident-vehicle')
</section>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['02','03','04','05','08']))
    <section id="appointment" class="tab-content">
        @include('assessment.accident.tab.accident-appointment')
    </section>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['03','04','05','08']) && auth()->user()->isForemenAssessment())
    <section id="assessment" class="tab-content">
        @include('assessment.accident.tab.accident-assessment')
    </section>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['04','05','08']) && $TaskFlowAccessAssessmentAccident->mod_fleet_verify)
    <section id="evaluation" class="tab-content">
        @include('assessment.accident.tab.accident-evaluation')
    </section>
@endif
@if ($detail && $detail && in_array($detail->hasStatus->code, ['05','08']) && $TaskFlowAccessAssessmentAccident->mod_fleet_approval)
    <section id="approval" class="tab-content">
        @include('assessment.accident.tab.accident-approval')
    </section>
@endif

@if ($detail && $detail && in_array($detail->hasStatus->code, ['08']))
    <section id="certificate" class="tab-content">
        @include('assessment.accident.tab.accident-certificate')
    </section>
@endif
