@php
    use App\Models\Assessment\AssessmentDisposalVehicle;
    $AssessmentDisposalVehicle = AssessmentDisposalVehicle::where('assessment_disposal_id',$details['assessment_id'])->get();
@endphp
<!DOCTYPE html>
<html>

<head>
    <title>{{ $details['title'] }}</title>
</head>

<body>
    <div>
    <div style="max-width:500px;font-size:12px;font-family:Arial, Helvetica, sans-serif">
        Assalamualaikum / Salam Sejahtera<br/><br/>
        Tuan / Puan <br><br>
        {{$details['applicant_name']}} <br><br>
        Proses pemeriksaan bagi permohonan No. Rujukan <b>{{$details['no_rujukan']}}</b> telah hantar.
    Tarikh dan masa temujanji adalah, {{Carbon\Carbon::parse($details['appointment_dt'] )->format('d M Y g:i A')}}. Segala pertanyaan berkaitan permohonan boleh diajukan kepada  {{ucwords(strtolower($details['worksyop']))}}</div>
    <br/><br/>

    No. Pendaftaran:
        <b>
            @foreach ( $AssessmentDisposalVehicle as $list)
                {{$list->plate_no}},
            @endforeach
        </b>
    <br/><br/><br/>

    Sekian, terima kasih.
    <br/>

    <div style="font-weight: bold">{{$details['worksyop']}}</div>
    <br/><br/>
    <div style="max-width: 600px;color:#000000">
        <div>Urusetia</div><br/>
        <img href="http://spakat.cubixi.com/my-assets/img/spakat-small-min.png" width="60">
        <br>
        <span>Cawangan Kejuruteraan Mekanikal, </span>
        <span>{{ucwords(strtolower($details['worksyop']))}}</span>
        <div>No 2, Jalan Arowana, 55300 Kuala Lumpur,</div><div class="address">Wilayah Persekutuan Kuala Lumpur</div>
        <div style="position:relative;
            -webkit-border-radius: 20px;
            -moz-border-radius: 20px;
            border-radius: 20px;
            padding:0px;
            height:35px;
            display: inline-block;
            width: fit-content;
            font-size: 12px;
            height:35px;
            margin-top:20px;">
            <div style="display: inline-block;
                padding-left:0px;
                padding-right:10px;
                color:#ffffff;
                font-size: 12px;
                height:35px;">
                <img href="http://spakat.cubixi.com/my-assets/img/envelope.jpg" width="60"></div>
            <div style="position: relative;
                top:0px;
                right:0px;
                font-family:Arial, Helvetica, sans-serif;
                -webkit-border-radius: 20px;
                -moz-border-radius: 20px;
                border-radius: 20px;
                background-color: #e9b600;
                height:35px;
                line-height:35px;
                font-size: 12px;
                color:#22282b;
                padding-left:20px;
                padding-right:20px;
                padding-top:0px;
                padding-bottom:9px;
                margin-top:0px;
                margin-bottom: 0px;
                display: inline-block;
                cursor: pointer;text-decoration:none">spakat@jkr.gov.my</div>
        </div>
    </div>


</body>

</html>
