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
        border: none;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12pt;
        text-transform: capitalize;
        text-align: left;
        line-height: 0.5cm;
    }

    .form-control {
        padding: 5px;
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
</script>


<button class="btn cux-btn small no-printme" style="cursor: pointer; padding:5px; border-radius: 15px; border: 1px solid rgb(97, 92, 92);" onclick="resizeAndPrint()">Cetak</button>

<br/>

    <form class="row" id="frm_disposal_letter">
    <input type="hidden" value="{{$detail->id}}" name="assessment_id">
    <input type="hidden" value="disposal_letter2" name="report_name">
    <div style="">
        <div>
            <table style="margin-top: 20px;">
                <thead>
                    <tr>
                        <td colspan="2">
                            {{-- <button
                            style="height: unset; width: 60px;"
                            class="btn cux-btn small"
                            data-fancybox data-type="iframe"
                            class="btn cux-btn" data-id="{{$detail->id}}" style="cursor: pointer; padding:5px; border-radius: 15px; border: 1px solid rgb(97, 92, 92);" onclick="viewLetter(this)"
                            >Cetak</button> --}}

                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="width: 50%"></td>
                        <td>Ruj. Kami</td>
                        <td>:</td>
                        <td><input onchange="$('.refnumber').text(this.value); this.value = this.value.toUpperCase()" id="letter_ref" name="letter_ref" type="text" class="form-control" placeholder="JKR.WSP.050-2/1 Jld. 105 ()"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Tarikh</td>
                        <td>:</td>
                        <td><input onchange="$('.refdate').text(this.value); this.value = this.value.toUpperCase()" id="letter_date" name="letter_date" type="text" class="form-control" placeholder="{{\Carbon\Carbon::now()->translatedFormat('d F Y')}}"></td>
                    </tr>
                </thead>
            </table>
        </div>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td colspan="4" style="color: black">
                        {{-- <textarea style="resize: none;" class="form-control font-weight-bold" name="" id="" cols="30" rows="5" placeholder="Alamat Penerima" >
                        {{$detail->address}}
                        </textarea> --}}
                        {{$detail->address}},<br>
                        {{$detail->postcode}},<br>
                        {{$detail->hasState->desc}},
                    </td>
                </tr>
            </thead>
        </table>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td style="width: 50%">
                        <input type="text" class="form-control" placeholder="u.p : NORAZLAN BIN HAJI ANUAR" id="up_name" name="up_name">
                    </td>
                    <td colspan="3"></td>
                </tr>
            </thead>
        </table>
        <table>
            <tr>
                <td colspan="4">Tuan,</td>
            </tr>
            <tr>
                <td colspan="4">
                    <b style="justify-content: justify; line-height: 0.5cm; font-weight: bold; color: black">
                        SIJIL PERAKUAN PERLUPUSAN (PEP) KENDERAAN MILIK {{$detail->department_name}}, {{$detail->hasAgency->desc}}

                    </b>
                    <hr style="font-weight: bold;border: 1px solid black;margin-top: 0;" />
                </td>
            </tr>
            <tr>
                <td colspan="4" style="justify-content: justify; width:50%">
                    Dengan ini segala hormatnya saya merujuk kepada perkara tersebut di atas dan lanjutan daripada surat tuan no.ruj.
                </td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" placeholder="SKM.IP.(AM) 7966/174 Jld.2 (66)" name="ref_number" id="ref_number"></td>
                <td>bertarikh</td>
                <td><input type="text" class="form-control" placeholder="{{\Carbon\Carbon::now()->translatedFormat('d F Y')}}" name="evaluate_date" id="evaluate_date"></td>
                <td style="width:20%;"> adalah berkaitan.</td>
            </tr>
            <tr>
                <td colspan="4"><br></td>
            </tr>
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm; width:50%;">
                    2. Untuk makluman, pihak kami telah menjalankan pemeriksaan ke atas
                </td>
                <td><input type="number" placeholder="Bilangan Kenderaan" class="form-control" name="car_total" id="car_total"></td>
                <td colspan="2">unit kenderaan milik tuan seperti dilampiran A.</td>
            </tr>
            <tr>
                <td colspan="4"><br></td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top: 10px; text-align: justify; line-height: 0.5cm;">
                    3. Dilampirkan <b style="font-weight: bold; color: black">Perakuan Pelupusan (PEP)</b> untuk tindakan selanjutnya. Sebarang pertanyaan boleh menghubungi <b style="font-weight: bold; color: black">{{$detail->hasWorkShop->desc}}</b>
                    di talian
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm; width:50%;">
                    <input type="text" placeholder="03-92064000" class="form-control" name="no_tel" id="no_tel">
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top: 10px; text-align: justify; line-height: 0.5cm;">
                    <br><br>
                    Sekian, terima Kasih.
                </td>
            </tr>
            <tr>
                @php
                    $text2PlaceHolder = "\"WAWASAN KEMAKMURAN BERSAMA\"\n\"BERKHIDMAT UNTUK NEGARA\"\n\"";
                    $forSigning = "\"(Ts. NORHISHAM BIN LAUNAH)\"\n\"Ketua Jurutera Mekanikal\"\nJKR Woksyop Persekutuan\"\nKuala Lumpur";
                @endphp
                <td colspan="2" style="width: 50%;">
                    <textarea name="propaganda" class="form-control" placeholder="{{$text2PlaceHolder}}" id="propaganda" cols="30" rows="10"></textarea>
                </td>
                <td></td>
                <td></td>
            </tr>
        </table>
        <br>

        <table style="width: 100%;">
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm;" colspan="4">
                    Saya yang menjalankan amanah,
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 50%; line-height: 0.5cm;">
                    <br><br>
                    <p>__________________________</p>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" name="signature_name" id="signature_name" placeholder="(MOHD AMIRUL ASWAD BIN KHAIRUDDIN)"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" name="jawatan" id="jawatan" placeholder="Jurutera Mekanikal"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" name="woksyop" id="woksyop" placeholder="JKR Woksyop Persekutuan"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" name="bahagian" id="bahagian" placeholder="(Bahagian Perkhidmatan Harta)"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" name="state" id="state" placeholder="Kuala Lumpur"><br/>
                </td>
                <td></td>
            </tr>
        </table>
    </div>
    {{-- <div class="print_next_page"></div> --}}
    <br><br>
    <div style="margin-top: 72px; margin-left: 72px; margin-right: 72px; margin-bottom: 72px;">

    </div>

</form>
<script>

    viewLetter = function(self){
        let assessment_id = $(self).data('id');
        // let letter_ref = $('#letter_ref').val();

        // var formData = $('#frm_disposal_letter').serialize();
        // printLetter(formData);


        $.get("{{route('jasperReport')}}", {
            format: 'pdf',
            title: 'SURAT PELUPUSAN',
            report_name: 'disposal_letter2',
            assessment_id: assessment_id,
            letter_ref: $('#letter_ref').val(),
            letter_date: $('#letter_date').val(),
            up_name: $('#up_name').val(),
            ref_number: $('#ref_number').val(),
            evaluate_date: $('#evaluate_date').val(),
            car_total: $('#car_total').val(),
            no_tel: $('#no_tel').val(),
            propaganda: $('#propaganda').val(),
            signature_name: $('#signature_name').val(),
            jawatan: $('#jawatan').val(),
            woksyop: $('#woksyop').val(),
        },  function(result){

        })

        // window.open(
        // '_blank' // <- This is what makes it open in a new window.
        // ))
        // let format = 'pdf';
        // let title = 'SURAT PELUPUSAN';
        // let report_name = 'disposal_letter2';
        // // let assessment_id = assessment_id;
        // let letter_ref = $('#letter_ref').val();
        // let letter_date = $('#letter_date').val();
        // let up_name = $('#up_name').val();
        // let ref_number = $('#ref_number').val();
        // let evaluate_date = $('#evaluate_date').val();
        // let car_total = $('#car_total').val();
        // let no_tel = $('#no_tel').val();
        // let propaganda = $('#propaganda').val();
        // let signature_name = $('#signature_name').val();
        // let jawatan = $('#jawatan').val();
        // let woksyop = $('#woksyop').val();

        // window.location.href = "{{route('jasperReport')}}?format="+format+"?title="+title+"?report_name="+report_name+"?assessment_id="+assessment_id+"?letter_ref="+letter_ref+"?letter_date="+letter_date+"?up_name="+up_name+"?ref_number="+ref_number+"?evaluate_date="+evaluate_date+"?car_total="+car_total+"?no_tel="+no_tel+"?propaganda="+propaganda+"?signature_name="+signature_name+"?jawatan="+jawatan+"?woksyop="+woksyop;

    }

    function printLetter(data) {
            parent.startLoading();
            $.ajax({
                url: "{{ route('jasperReport') }}",
                type: 'get',
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                method: 'GET',
                success: function(response) {
                    parent.stopLoading();
                },
                error: function(response) {
                    parent.stopLoading();
                }
        });
    }

    $(document).ready(function(){
    });
</script>
