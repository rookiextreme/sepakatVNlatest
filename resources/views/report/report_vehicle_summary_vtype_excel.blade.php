<div class="detailing">
    <br/>
        <h1>Senarai Keseluruhan Aset Mengikut Jenis Kenderaan</h1>
        <br/>
    <div class="table-responsive">
        
     <table class="table" id="tbl_vsum_disaster">
         <thead>
             <tr>
                 <td class="col-mth header-depreciation"> Bil</td>
                 <td class="col-mth header-depreciation"> Kategori / JKR Woksyop</td>
                 @foreach ($totalByType as $bYType)
                     <td class="fs-overflow">{{$bYType->v_type_name}}</td>
                 @endforeach
                 <td class="col-mth header-depreciation"> Jumlah</td>
             </tr>
         </thead>
         <tbody id="sortable_summary_report_vehicle_summary_vtype">

             @php
                 $totalByTypes = [];

                 foreach ($list as $key) {
                     foreach ($key['has_many_total'] as $type) {
                         $total = 0;
                         if($key['state_code'] == $type['state_code']){
                             $total += (int) $type['total'];
                             $totalByTypes['state_'.$type['state_code'].'_type_'.$type['type_code']] = $total;
                         }
                         
                     }
                 }


             @endphp

             @foreach ($list as $item)
             <tr>

                 <td>{{$loop->index+1}}</td>
                 <td>{{$item['state_name']}}</td>
                 @foreach ($totalByType as $bYType)
                     <td class="font-weight-bold">
                         @if(isset($totalByTypes['state_'.$item['state_code'].'_type_'.$bYType->v_type_code]))
                             {{$totalByTypes['state_'.$item['state_code'].'_type_'.$bYType->v_type_code]}}
                             @else
                             0
                         @endif
                     </td>
                 @endforeach
                 
                 <td style="background-color: rgb(162, 210, 240);">
                     <label for="" class="form-label">
                         {{$item['total']}}
                     </label>
                 </td>

             </tr>
                 
             @endforeach

             <tr class="footer">
                 <td class="font-weight-bold" colspan="2"> Jumlah</td>
                 @php
                     $overall = 0;
                 @endphp
                 @foreach ($totalByType as $bYType)
                 @php
                     $overall += $bYType->total_type;
                 @endphp
                     <td class="font-weight-bold">
                         <label for="" class="form-label">{{$bYType->total_type}}</label>
                     </td>
                 @endforeach
                 <td class="font-weight-bold"> <label for="" class="form-label">{{$overall }}</label></td>
             </tr>

         </tbody>
     </table>
    </div>
 </div>