<div class="detailing">

    <br/>
    <h1 style="width: 100%; padding:10px; text-align: center;">Senarai Keseluruhan Aset Mengikut Kategori Kenderaan</h1>
    <br/>

    @php
        $totalByCategories = [];

        foreach ($dataByStateAndType as $type) {

            $total_federal = 0;
            $total_state = 0;

            if($type->owner_type_code == '01'){
                $total_federal += $type->total;
                $totalByCategories['state_'.$type->state_code.'_cat_'.$type->cat_code.'_federal'] = $total_federal;
            } elseif($type->owner_type_code == '02'){
                $total_state += $type->total;
                $totalByCategories['state_'.$type->state_code.'_cat_'.$type->cat_code.'_state'] = $total_state;
            }
        }


    @endphp
    {{-- @json($categories) --}}
   <div class="table-responsive">
    <table class="table" id="tbl_vsum_disaster" style="width: 100%">
        <thead>
            <tr>
                <td class="col-mth header-depreciation" rowspan="2" style="vertical-align: middle;"> Bil</td>
                <td class="col-mth header-depreciation" rowspan="2" style="vertical-align: middle;"> Kategori / JKR Woksyop</td>
                @foreach ($categories as $category)
                    <td colspan="3">{{$category->cat_name}}</td>
                @endforeach
                <td  class="col-mth header-depreciation" style="vertical-align: middle;" rowspan="2"> Keseluruhan</td>
            </tr>
            <tr>
                @foreach ($categories as $category)
                    <td>NEGERI</td>
                    <td>PERS.</td>
                    <td>JUML.</td>
                @endforeach
            </tr>
        </thead>
        <tbody id="sortable_summary_report_vehicle_summary_vcategories">


            @foreach ($state_list as $state)

            <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$state['state_name']}}</td>

                @foreach ($categories as $category)
                @php
                    $total = 0;
                @endphp
                    <td>
                        @if(isset($totalByCategories['state_'.$state['state_code'].'_cat_'.$category->cat_code.'_state']))
                        @php
                            $total += $totalByCategories['state_'.$state['state_code'].'_cat_'.$category->cat_code.'_state'];
                        @endphp
                            {{$totalByCategories['state_'.$state['state_code'].'_cat_'.$category->cat_code.'_state']}}
                            @else 0
                        @endif
                    </td>
                    <td>
                        @if(isset($totalByCategories['state_'.$state['state_code'].'_cat_'.$category->cat_code.'_federal']))
                        @php
                            $total += $totalByCategories['state_'.$state['state_code'].'_cat_'.$category->cat_code.'_federal'];
                        @endphp
                            {{$totalByCategories['state_'.$state['state_code'].'_cat_'.$category->cat_code.'_federal']}}
                            @else 0
                        @endif
                    </td>
                    <td>
                        {{$total}}
                    </td>
                @endforeach

                <td style="background-color: rgb(162, 210, 240);">
                    <label for="" class="form-label">{{$state['total']}}</label>
                </td>

            </tr>

            @endforeach

            <tr class="footer">
                <td class="font-weight-bold" colspan="2"> Jumlah</td>
                @php
                    $overall = 0;
                @endphp

                @foreach ($categories as $category)

                @php
                    $total_by_state = 0;
                    $total_by_federal = 0;

                    foreach ($categoriesByOwnerType as $key) {
                        if($key->cat_code == $category->cat_code){
                            if($key->owner_type_code == '01'){
                                $total_by_federal = $key->total;
                                $overall += $total_by_federal;
                            } elseif($key->owner_type_code == '02'){
                                $total_by_state = $key->total;
                                $overall += $total_by_state;
                            }
                        }
                    }
                @endphp

                <td>{{$total_by_state}}</td>
                <td>{{$total_by_federal}}</td>
                <td>{{$total_by_state+$total_by_federal}}</td>
                @endforeach
                <td class="font-weight-bold"> <label for="" class="form-label">{{$overall }}</label></td>
            </tr>

        </tbody>
    </table>
   </div>
</div>
