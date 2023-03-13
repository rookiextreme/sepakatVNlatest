@php
    $vehicleBrandName = $detail->hasVehicle->hasVehicleBrand ? $detail->hasVehicle->hasVehicleBrand->name : '';
    $vehicleModelName = $detail->hasVehicle->model_name ? $detail->hasVehicle->model_name : '';
    $vehiclePlateNo = $detail->hasVehicle->plate_no;

@endphp

<style>

#letter tbody tr:hover {
            background-color: transparent;
        }

#letter td {
    border: none !important;
}

.style_border{
    border: 2px solid black;
}

</style>
<style type="text/css" media="print">
    @page
    {
        size: auto; /* auto is the initial value */
        /*margin: 5mm 4mm 4mm 4mm; /* this affects the margin in the printer settings */

    }

    .no-printme {
        display: none;
    }

    .whenPrint {
        display: block;
        width: 100%;

    }

    .print_next_page {
        page-break-before: always;
    }

    textarea, input{
        color: black !important;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12pt;
        text-transform: capitalize;
        text-align: left;
        line-height: 0.5cm;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        background-color: transparent;
    }

    .form-control {
        /* padding: 5px; */
    }

    ::-webkit-input-placeholder { /* WebKit browsers */
        color: transparent;
    }
    :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
        color: transparent;
    }
    ::-moz-placeholder { /* Mozilla Firefox 19+ */
        color: transparent;
    }
    :-ms-input-placeholder { /* Internet Explorer 10+ */
        color: transparent;
    }
    .table-center {
        margin-left: auto;
        margin-right: auto;
    }

    .input-sign{
        line-height: 0.0cm;
        border: none;
    }
    table tr td {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* @media print {
        body { font-size: 10pt }
    }
    @media screen {
        body { font-size: 12px }
    }
    @media screen, print {
        body { line-height: 0.5 }
    } */

    /* @media print {
    body {display:none};
    } */

</style>
<script>
    function resizeAndPrint() {
        var _print = window.print;
        window.print = function() {
            $('textarea').each(function() {
                $(this).height($(this).prop('scrollHeight'));
            });
            _print();
        }
        window.print();
    }
    function testPrint(){
        var inputValue = document.getElementById("ref_number").value;
        txtOutput.value = "Hi there, " + inputValue + "!"
    }
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>
<button class="btn cux-btn small no-printme" style="cursor: pointer; padding:5px; border-radius: 15px; border: 1px solid rgb(97, 92, 92);" onclick="resizeAndPrint();">Cetak</button>

{{-- <button class="btn cux-btn small no-printme" style="cursor: pointer; padding:5px; border-radius: 15px; border: 1px solid rgb(97, 92, 92);" onclick="printDiv('printableArea')">Cetak</button> --}}

<div class="table-responsive" id="printableArea">
    <table class="table table-borderless" id="" style="width: 100%">
        <tr>
            <td colspan="3">
                <div style="border: 1px solid rgba(0, 0, 0, 0.30);" class="no-printme"></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class="float-end" style="width: 400px;">
                    <tr>
                        <td>Ruj. Kami</td><td>:</td><td>
                            <input onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();transferValue(this)"  type="text" name="ref_number" id="ref_number" value="" style="border: none transparent;outline: none;" placeholder="JKR.WSP.050-2/1 Jld. 105 ()">
                        </td>
                    </tr>
                    <tr>
                        <td>Tarikh</td><td>:</td><td>
                            <input onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();"  type="text" name="date" id="date" value="{{$detail->date ?: \Carbon\Carbon::now()->translatedFormat('d F Y')}}">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                {{-- todo govAgencyStaff / jkrStaff for division --}}
                <table class="float-start" style="width:400px;">
                    <tr>
                        <td>
                            @php
                                $address1 = $detail->department_name;
                                $address2 = $detail->hasAgency->desc;
                                $address3 = $detail->address;
                                $address4 = $detail->postcode." ".$detail->hasState->desc;
                            @endphp
                            <textarea maxlength="200" onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();" style="width: 400px; resize: none;" name="address_to" id="" cols="30" rows="7" class="form-control" placeholder="Butiran Penerima Surat">{{$address1.",\n".$address2.",\n".$address3.",\n".$address4}}</textarea>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Tuan,
            </td>
        </tr>
        <tr>
            <td colspan="3" class="form-label fs-5" style="line-height: 21px">
                SIJIL PERAKUAN PELUPUSAN (PEP) KENDERAAN MILIK {{$address1." ".$address2}}
                <div style="border: 1px solid rgb(71, 71, 71);"></div>
            </td>
        </tr>

        <tr>
            <td colspan="3" class="" style="line-height: 21px">
                Dengan segala hormatnya saya merujuk kepada perkara tersebut di atas dan lajutan daripada surat no. ruj.
                <input  style= "width:250px" onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();" type="text" name="no_ruj_surat" id="no_ruj_surat" value="" placeholder="SKM.IP.(AM) 7966/174 Jld.2 (66)">
                 bertarikh
                <input  style= "width:150px" onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();" type="text" name="tarikh_surat" id="tarikh_surat" value="{{$detail->date ?: \Carbon\Carbon::now()->translatedFormat('d F Y')}}" placeholder="">
                 .
            </td>
        </tr>

        <tr>
            <td colspan="3" class="" style="line-height: 21px">
                2.&nbsp;&nbsp;&nbsp;Untuk makluman, pihak kami telah menjalankan pemeriksaan ke atas
                <input  style= "width:35px" type="text" onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();" name="bil_kenderaan" id="bil_kenderaan" value="" >
                 unit kenderaan milik tuan seperti dalam lampiran A.
            </td>
        </tr>

        <tr>
            <td colspan="3" class="" style="line-height: 21px">
                3.&nbsp;&nbsp;&nbsp;Dilampirkan <b style="font-weight: bold; color:black;">Perakuan Pelupusan (PEP)</b> untuk tindakan selanjutnya. Sebarang pertanyaan boleh menghubungi {{$detail->hasWorkShop->desc}}, {{$detail->hasWorkShop->hasState->desc}} di talian
                <input  style= "width:150px" type="text" name="tel_no" id="tel_no" value="" placeholder="03-92064000"> .
            </td>
        </tr>

        <tr>
            <td colspan="3">
                Sekian, terima kasih<br/><br/>
                <textarea  style="width: 300px; resize: none; height:8px;" onchange="this.setAttribute('value', this.value);" name="signature_quote" id="" cols="30" class="form-control" placeholder=" 'WAWASAN KEMAKMURAN BERSAMA 2020' "></textarea>


                <label for="" class="mt-2">Saya yang menjalankan amanah,</label><br/><br/>

                {{-- <div class="mt-5" style="width: 200px; border-bottom: 1px solid black;"></div> --}}

                    {{-- <div class="d-inline">b.p</div>  --}}
                    @php
                        $textFieldArea = "(MOHD AMIRUL ASWAD BIN KHAIRUDDIN)\nJurutera Mekanikal\nJKR Woksyop Persekutuan\n(Bahagian Perkhidmatan Harta)\nKuala Lumpur"
                    @endphp
                    <textarea  style="width: 300px; resize: none;" onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();" name="officer_designation" id="" cols="30" rows="2" class="form-control" placeholder="">{{$textFieldArea}}</textarea>
            </td>
        </tr>

    </table>
</div>

<div class="table-responsive" id="printableArea">
    <table class="table table-borderless" id="" style="width: 100%; margin-left: auto;  margin-right: auto;">
        <tr>
            <td colspan="3">
                <div style="border: 1px solid rgba(0, 0, 0, 0.30);"  class="no-printme"></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <table class="float-end" style="width: 400px;">
                    <tr>
                        <td>Ruj. Kami</td><td>:</td><td>
                            <input onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();"  type="text" name="ref_number2" id="ref_number2" value="" style="border: none transparent;outline: none;" placeholder="JKR.WSP.050-2/1 Jld. 105 ()">
                        </td>
                    </tr>
                    <tr>
                        <td>Tarikh</td><td>:</td><td>
                            <input onchange="this.setAttribute('value', this.value);this.value = this.value.toUpperCase();"  type="text" name="date" id="date" value="{{$detail->date ?: \Carbon\Carbon::now()->translatedFormat('d F Y')}}">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Tuan,
            </td>
        </tr>
        <tr>
            <td colspan="3" class="form-label fs-5" style="line-height: 21px">
                SIJIL PERAKUAN PELUPUSAN (PEP) KENDERAAN MILIK {{$address1." ".$address2}}
                <div style="border: 1px solid rgb(71, 71, 71);"></div>
            </td>
        </tr>
        <tr >
            <td colspan="3" style="width: 100%">
                <table class="style_border" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="style_border" style="font-weight: bold">Bil.</th>
                            <th class="style_border" style="font-weight: bold">JENIS / JENAMA / MODEL</th>
                            <th class="style_border" style="font-weight: bold">NO. PENDAFTARAN</th>
                        </tr>
                    </thead>
                    <thead>
                        @foreach ( $detail->hasVehicleMany as $vehicle)
                            <tr>
                                <th class="style_border">{{$loop->index+1}}.</th>
                                <th class="style_border">{{$vehicle->hasSubCategoryType ? $vehicle->hasSubCategoryType->name : '-'}} / {{$vehicle->hasVehicleBrand ? $vehicle->hasVehicleBrand->name : '-'}} / {{$vehicle->model_name ? $vehicle->model_name : '-'}}</th>
                                <th class="style_border">{{$vehicle->plate_no}}</th>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </td>
        </tr>
        <tr>
            <br><br><br>
        </tr>
    </table>
</div>

<script type="text/javascript">
    transferValue = function(self){
        var dInput = $('#ref_number').val();
        // console.log(dInput);
        printOutLine(dInput);
    }

    function printOutLine(data){

        $('#ref_number2').val(data);
    }
</script>
