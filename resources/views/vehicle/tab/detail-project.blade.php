<div class="row">
    <div class="col-12"></div>
    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
        <label for="" class="form-label text-dark">No Kontrak <em>*</em></label>
        @if (!empty($is_display) && $is_display == 1)
        <div class="text-capitalize theme-color-text">
            {{ isset($detail->hasProject['contract_no']) ? $detail->hasProject['contract_no'] : '' }}
        </div>
        @else
        <input type="text" class="form-control" name="contract_no" id=""
            value="{{ isset($detail->hasProject['contract_no']) ? $detail->hasProject['contract_no'] : '' }}">
        @endif

    </div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
        <label for="" class="form-label text-dark">Hopt <em>*</em></label>
        @if (!empty($is_display) && $is_display == 1)
        <div class="text-capitalize theme-color-text">
            {{ isset($detail->hasProject['hopt']) ? $detail->hasProject['hopt'] : '' }}
        </div>
        @else
        <input type="text" class="form-control" name="hopt" id="hopt"
            value="{{ isset($detail->hasProject['hopt']) ? $detail->hasProject['hopt'] : '' }}">
        @endif

    </div>

    <div class="col-12"></div>

    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-4 col-12">
        <label for="" class="form-label text-dark">Nama Syarikat Kontraktor <em>*</em></label>
        @if (!empty($is_display) && $is_display == 1)
        <div class="text-capitalize theme-color-text">
            {{ isset($detail->hasProject['contractor_name']) ? $detail->hasProject['contractor_name'] : '' }}
        </div>
        @else
        <input type="text" class="form-control" name="contractor_name" id=""
            value="{{ isset($detail->hasProject['contractor_name']) ? $detail->hasProject['contractor_name'] : '' }}">
        @endif

    </div>

    <div class="col-12"></div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
        <label for="" class="form-label text-dark">Tarikh Mula</label>
        @if (!empty($is_display) && ($is_display == 1))
        <div class="text-capitalize theme-color-text">
            {{isset($detail->hasProject['project_start_dt']) ? $detail->hasProject['project_start_dt'] : ""}}
        </div>
        @else
        <div class="input-group date" id="project_start_dt" data-target-input="nearest">
            <input name="project_start_dt" id="project_start_dtInput" type="text" class="form-control datepicker"
                placeholder="" autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                value="{{isset($detail->hasProject['project_start_dt']) ? Carbon\Carbon::parse($detail->hasProject['project_start_dt'])->format('d/m/Y'): null}}" />

            <div class="input-group-text" for="project_start_dtInput">
                <i class="fa fa-calendar"></i>
            </div>
        </div>
        @endif
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
        <label for="" class="form-label text-dark">Tarikh Siap</label>
        @if (!empty($is_display) && ($is_display == 1))
        <div class="text-capitalize theme-color-text">
            {{isset($detail->hasProject['project_end_dt']) ? $detail->hasProject['project_end_dt'] : ""}}
        </div>
        @else
        <div class="input-group date" id="project_end_dt" data-target-input="nearest">
            <input name="project_end_dt" id="project_end_dtInput" type="text" class="form-control datepicker"
                placeholder="" autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                value="{{isset($detail->hasProject['project_end_dt']) ? Carbon\Carbon::parse($detail->hasProject['project_end_dt'])->format('d/m/Y'): null}}" />

            <div class="input-group-text" for="project_end_dtInput">
                <i class="fa fa-calendar"></i>
            </div>
        </div>
        @endif
    </div>

    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
        <label for="" class="form-label text-dark">Tarikh CPC</label>
        @if (!empty($is_display) && ($is_display == 1))
        <div class="text-capitalize theme-color-text">
            {{isset($detail->hasProject['project_cpc_dt']) ? $detail->hasProject['project_cpc_dt'] : ""}}
        </div>
        @else
        <div class="input-group date" id="project_cpc_dt" data-target-input="nearest">
            <input name="project_cpc_dt" id="project_cpc_dtInput" type="text" class="form-control datepicker"
                placeholder="" autocomplete="off" data-provide="datepicker" data-date-autoclose="true"
                data-date-format="dd/m/yyyy" data-date-today-highlight="true"
                value="{{isset($detail->hasProject['project_cpc_dt']) ? Carbon\Carbon::parse($detail->hasProject['project_cpc_dt'])->format('d/m/Y'): null}}" />

            <div class="input-group-text" for="project_cpc_dtInput">
                <i class="fa fa-calendar"></i>
            </div>
        </div>
        @endif
    </div>
</div>