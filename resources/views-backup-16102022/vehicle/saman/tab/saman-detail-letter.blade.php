@php
    $dateTime = \Carbon\Carbon::setLocale('ms');
@endphp
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>JKR SPaKAT : Sistem Aplikasi Pengurusan Kenderaan Atas Talian</title>
      <link rel="shortcut icon" href="{{asset('my-assets/favicon/favicon.png')}}">
      <script type="text/javascript" src="{{ asset('my-assets/jquery/jquery-3.6.0.min.js') }}"></script>
   </head>
<style>

    .print_next_page {
        display: block;
    }
    .whenPrint {
        display: none;
    }
</style>

<style type="text/css" media="print">
    @page
    {
        size: A4 potrait; /* auto is the initial value */
        margin-top: 5mm;
        margin-left: 1mm;
        margin-right: 1mm;
        margin-bottom: 1mm;
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

<style>
    .btn-group {
        position: relative;
        display: inline-flex;
        vertical-align: middle;
    }
    .btn-group button:hover, .btn-group a:hover {
        color:white;
        background-color: black;
    }
</style>

<script>
    function resizeAndPrint() {
        var _print = window.print;
        window.print = function() {
            $('textarea').each(function() {
                $(this).height(30);
                $(this).height($(this).prop('scrollHeight')+20).css({
                    'overflow' : 'hidden'
                });
            });
            _print();
        }
        window.print();
    }

    exportTo = function(self){

        //['format' => 'pdf', 'title' => 'Sijil Kenderaan Keselamatan & Prestasi', 'report_name' => 'assessment_certificate_safety', 'table_name' => 'assessment_safety', 'vehicle_id' => $vehicle->id]

        let summon_id = $(self).data('summon-id');
        let url = "{{route('jasperReport')}}";
        let title = "Surat Saman";
        let report_name = "summon_letter";
        let report_type= $(self).data('type');
        let ref_number = $('#ref_number').val();
        let ref_date = $('#ref_date').val();
        let address_to = document.getElementById('address_to').value.replace(/\n/g, "<br/>");
        let quote = document.getElementById('quote').value.replace(/\n/g, "<br/>");
        let signature = document.getElementById('signature').value.replace(/\n/g, "<br/>");
        let copy_to = document.getElementById('copy_to').value.replace(/\n/g, "<br/>");
        let crf_token = "{{ csrf_token() }}";
        let fullUrl = url
        +"?title="+title+
        "&summon_id="+summon_id+
        "&report_name="+report_name+
        "&report_type="+report_type+
        "&ref_number="+ref_number+
        "&ref_date="+ref_date+
        "&address_to="+address_to+
        "&quote="+quote+
        "&signature="+signature+
        "&copy_to="+copy_to+
        "&_token="+crf_token;
        window.open(fullUrl);
        
    }
</script>

<div class="btn-group" style="padding-bottom: 5px;">
    {{-- <button class="btn cux-btn small no-printme" style="cursor: pointer; padding:5px; border-radius: 15px 0px 0px 15px; border: 1px solid rgb(97, 92, 92);" onclick="resizeAndPrint()">Cetak</button> --}}
    <button class="btn cux-btn small no-printme" style="cursor: pointer; padding:5px; border-radius: 15px 0px 0px 15px; border: 1px solid rgb(97, 92, 92);" data-summon-id="{{$detail->id}}" data-type="pdf" data-jasper-file="summon_letter" onclick="exportTo(this)">Muat turun Pdf</button>
    <button class="btn cux-btn small no-printme" style="cursor: pointer;padding:5px;border-radius: 0px 15px 15px 0px;border: 1px solid rgb(97, 92, 92);border-left: 0px;" data-summon-id="{{$detail->id}}" data-type="word" data-jasper-file="summon_letter" onclick="exportTo(this)">Muat turun Word</button>
</div>
<body>

    <div style="margin-top: 0px; margin-left: 30px; margin-right: 30px; margin-bottom: 0px;">
        <div align="left">
            <table style="width: 100%">
                <thead>
                    <tr>
                        <td style="width: 90px;padding-right: 10px;vertical-align: top;">
                            <img style="width:100%" src="{{asset('my-assets/img/jata_negara_logo.png')}}"/>
                        </td>
                        <td style="font-size: 13px;vertical-align: top;">
                            <strong>JABATAN KERJA RAYA MALAYSIA</strong><br/>
                            <strong>Cawangan Kejuruteraan Mekanikal</strong><br/>
                            JKR Woksyop Persekutuan<br/>
                            (JKR Cawangan Kejuruteraan Mekanikal,
                            Bahagian Perkhidmatan Harta)<br/>
                            No. 2, Jalan Arowana, Cheras<br/>
                            55300 KUALA LUMPUR 
                        </td>
                        <td style="text-align: right;vertical-align: bottom;">
                            <table style="width: 100%;">
                                <thead style="font-size: 12px;">
                                    <tr>
                                        <td>Telefon</td>
                                        <td>:</td>
                                        <td style="width: 100px;">03-9206 4000</td>
                                    </tr>
                                    <tr>
                                        <td>Faks</td>
                                        <td>:</td>
                                        <td style="width: 100px;">03-9283 1285</td>
                                    </tr>
                                </thead>
                            </table>
                        </td>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="border: 0.1px solid #000000a1;line-height: 1px;margin-bottom: 5px;margin-top: 3px;"></div>
        <div align="right">
            <table>
                <thead>
                    <tr>
                        <td>Ruj. Kami</td>
                        <td>:</td>
                        <td><input id="ref_number" onchange="$('.refnumber').text(this.value); this.value = this.value.toUpperCase()" type="text" class="form-control" placeholder="( )JKR.WSP.030-13"></td>
                    </tr>
                    <tr>
                        <td>Tarikh</td>
                        <td>:</td>
                        <td><input id="ref_date"onchange="$('.refdate').text(this.value); this.value = this.value.toUpperCase()" type="text" class="form-control" placeholder="{{\Carbon\Carbon::now()->translatedFormat('d F Y')}}"></td>
                    </tr>
                </thead>
            </table>
        </div>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td>
                        <textarea style="resize: none; height: 200px;" class="form-control font-weight-bold" name="" id="address_to" cols="40" rows="5" placeholder="Alamat Penerima" ></textarea>
                    </td>
                </tr>
            </thead>
        </table>
        <table>
            <tr>
                <td>Tuan,</td>
            </tr>
            <tr>
                <td>
                    <b style="justify-content: justify; line-height: 0.5cm;">
                        NOTIS PEMBERITAHUAN KESALAHAN LALULINTAS

                    </b>
                    <hr style="font-weight: bold;border: 1px solid black;margin-top: 0;" />
                </td>
            </tr>
            <tr>
                <td style="justify-content: justify; line-height: 0.5cm;">
                    Dengan segala hormatnya saya merujuk kepada perkara tersebut di atas.
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm;">
                    {{-- 2. &nbsp;&nbsp;Semakan saman kenderaan Jabatan melalui {{$issuer}}.&nbsp;
                    No.Notis :
                    <b>{{$detail->maklumatSaman->summon_notice_no}}</b> serta tarikh kuatkuasa : 7/4/2021 adalah berkaitan. Melalui Notis Saman tersebut, pihak <b>JKR
                    Woksyop
                    Persekutuan, Kuala Lumpur</b> telah membuat semakan dan mengenalpasti kenderaan yang dimaksudkan adalah milik
                    Jabatan Kerja
                    Raya Malaysia. Berdasarkan semakan adalah didapati kenderaan tersebut ditempatkan dan dikawalselia oleh
                    pihak tuan.
                    Maklumat notis/ kenderaan adalah dinyatakan seperti berikut :- --}}
                    2. &nbsp;&nbsp;Untuk makluman, JKR Woksyop Persekutuan telah menerima notis saman dan semakan lanjut mendapati kenderaan tersebut adalah milik
                    cawangan tuan. Ringkasan notis saman adalah seperti berikut:
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm;">

                    {{-- No. Pendaftaran : WSD2025
                    No. Notis : 2192004142
                    Tarikh / Masa Kesalahan : 22/02/2021 Jam 11:22
                    Jenis Kereta : TOYOTA FORTUNER 2.5G (D) AUTO
                    Penempatan : CAW. KERJA PENDIDIKAN --}}
                    <table style="padding-left: 20px; padding-top: 5px; padding-bottom: 5px;" width="100%" class="table-center">
                        {{-- <tr>
                            <td>Jenis Saman</td>
                            <td>:</td>
                            <td>{{$detail->MaklumatSaman->hasSummonAgency->desc}}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kesalahan</td>
                            <td>:</td>
                            <td>{{$detail->MaklumatSaman->hasSummonType->desc}}</td>
                        </tr>
                        <tr>
                            <td>No. Pendaftaran</td>
                            <td>:</td>
                            <td>{{$detail->pendaftaran->no_pendaftaran}}</td>
                        </tr>
                        <tr>
                            <td>No. Notis</td>
                            <td>:</td>
                            <td>{{$detail->maklumatSaman->summon_notice_no}}</td>
                        </tr>
                        <tr>
                            <td>Tarikh / Masa Kesalahan</td>
                            <td>:</td>
                            <td>{{\Carbon\Carbon::parse($detail->maklumatSaman->mistake_date)->format('d/m/Y')}} Jam {{\Carbon\Carbon::parse($detail->maklumatSaman->mistake_date)->format('h:m')}}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kereta</td>
                            <td>:</td>
                            <td>{{$detail->pendaftaran->hasSubCategoryType() ? $detail->pendaftaran->hasSubCategoryType()->name : '-'}}</td>
                        </tr>
                        <tr>
                            <td>Penempatan</td>
                            <td>:</td>
                            <td>{{$detail->pendaftaran->hasPlacement() ? $detail->pendaftaran->hasPlacement()->desc : '-'}}</td>
                        </tr> --}}
                        <tr>
                            <td style="font-weight: bold;" width="45%">No. Pendaftaran </td>
                            <td style="font-weight: bold;">: </td>
                            <td style="font-weight: bold;" width="55%">{{$detail->pendaftaran->no_pendaftaran}} </td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Pengeluar Saman</td>
                            <td style="font-weight: bold;">:</td>
                            <td style="font-weight: bold;">{{$detail->maklumatSaman->hasSummonAgency->desc}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; text-transform: capitalize;">no. notis</td>
                            <td style="font-weight: bold;">:</td>
                            <td style="font-weight: bold;">{{strtoupper($detail->maklumatSaman->summon_notice_no)}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold; text-align: left;">Tarikh / Masa Kesalahan</td>
                            <td style="font-weight: bold;">:</td>
                            <td style="font-weight: bold;">{{\Carbon\Carbon::parse($detail->maklumatSaman->mistake_date)->format('d/m/Y')}} Jam {{\Carbon\Carbon::parse($detail->maklumatSaman->mistake_date)->format('h:m')}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Model</td>
                            <td style="font-weight: bold;">:</td>
                            <td style="font-weight: bold;">{{$detail->maklumatSaman->maklumatKenderaanSaman->pendaftaran->hasModel ? $detail->maklumatSaman->maklumatKenderaanSaman->pendaftaran->hasModel->name : '-'}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;">Lokasi Penempatan</td>
                            <td style="font-weight: bold;">:</td>
                            <td style="font-weight: bold;">{{$detail->pendaftaran->hasPlacement() ? $detail->pendaftaran->hasPlacement()->desc : '-'}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm;">
                    {{-- 3. &nbsp;&nbsp;Sehubungan dengan itu, adalah menjadi tanggungjawab pihak tuan untuk menyelesaikan tuntutan Notis Saman
                    berkenaan
                    mengikut tatacara pekeliling perbendaharaan PK4.1 : Pengurusan Kenderaan Kerajaan (Para 14.4-Saman
                    tertunggak perlu
                    diselesaikan dalam tempoh sebulan setelah menerima peringatan bertulis dari Ketua Jabatan). Status
                    pemakluman
                    penyelesaian saman tersebut hendaklah dimaklumkan semula kepada pihak kami untuk tujuan pengemaskinian rekod
                    kenderaan
                    Jabatan. Bersama-sama ini dimajukan notis saman berkenaan untuk tindakan pihak tuan selanjutnya. --}}
                    3. &nbsp;&nbsp;Bersama ini dimajukan notis saman tersebut untuk tindakan tuan selanjutnya. Pihak tuan juga dipohon untuk
                    mengemaskini status penyelesaian saman tersebut di dalam Sistem Pengurusan Kenderaan Atas Talian (SPaKAT) yang boleh diakses
                    melalui https://spakat.jkr.gov.my/
                </td>
            </tr>
            <tr>
                <td style="padding-top: 10px; text-align: justify; line-height: 0.5cm;">
                    {{-- 4. &nbsp;&nbsp;Kerjasama dan perhatian pihak tuan untuk menyelesaikan tuntutan saman berkenaan demi menjaga nama baik
                    Jabatan
                    amatlah dihargai dengan ucapan terima kasih. --}}
                    4. &nbsp;&nbsp;Kerjasama dan perhatian pihak tuan amatlah dihargai.
                    <br><br>
                    Sekian. Terima Kasih.
                </td>
            </tr>
        </table>
        <br>
        {{-- <div class="whenPrint" >
        <br/>
            <div style="width: 100%; margin-top: 50px;">
                <div>
                    <b>
                        NOTIS PEMBERITAHUAN KESALAHAN LALULINTAS

                    </b>
                    <hr style="font-weight: bold;border: 1px solid black;margin-top: 0;" />
                </div>
            </div>
        </div> --}}

        <table style="width: 100%;">
            <tr>
                <td>
                    {{-- <p style="margin-bottom: 10px">
                        Sekian untuk makluman dan tindakan selanjutnya daripada pihak tuan.
                    </p> --}}
                    @php
                        $text2PlaceHolder = "\"WAWASAN KEMAKMURAN BERSAMA\"\n\"BERKHIDMAT UNTUK NEGARA\"\nSaya yang menjalankan amanah,";
                        $forSigning = "\"(Ts. NORHISHAM BIN LAUNAH)\"\n\"Ketua Jurutera Mekanikal\"\nJKR Woksyop Persekutuan\"\nKuala Lumpur";
                    @endphp
                    <textarea id="quote" style="resize: none;" class="form-control font-weight-bold" name="" cols="30" rows="5" placeholder="{{$text2PlaceHolder}}"></textarea>
                    <br>
                    <p>__________________________</p>
                    {{-- <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" placeholder="(Ts. NORHISHAM BIN LAUNAH)"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" placeholder="Ketua Jurutera Mekanikal"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" placeholder="JKR Woksyop Persekutuan"><br/>
                    <input type="text" class="form-control input-sign" style="width: 300px;" onchange="this.value = this.value.toUpperCase()" placeholder="Kuala Lumpur"><br/> --}}
                    <textarea id="signature" style="resize: none;" class="form-control font-weight-bold" name="" cols="30" rows="5" placeholder="{{$forSigning}}"></textarea>
                </td>
            </tr>
        </table>
    </div>
    {{-- <div class="print_next_page"></div> --}}
    <br><br>
    <div style="margin-top: 72px; margin-left: 30px; margin-right: 30px; margin-bottom: 72px;">
        <table style="float: right">
            <thead>
                <tr>
                    <td>Ruj. Kami</td>
                    <td>:</td>
                    <td class="refnumber">( )JKR.WSP.030-13</td>
                </tr>
                <tr>
                    <td>Tarikh</td>
                    <td>:</td>
                    <td class="refdate">{{\Carbon\Carbon::now()->format('M Y')}}</td>
                </tr>
            </thead>
        </table>
        <table style="width: 100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                {{-- <img src="http://spakat.test/my-assets/img/logo.png" class="img-fluid"> --}}
                                {{-- (Ts. NORHISHAM BIN LAUNAH)<br/>
                                Ketua Jurutera Mekanikal<br/>
                                JKR Woksyop Persekutuan<br/>
                                Kuala Lumpur<br/> --}}

                                SALINAN KEPADA :<br/><br/>

                                <div>
                                    <textarea id="copy_to" style="resize: none;" class="form-control font-weight-bold" name="" cols="30" rows="10" placeholder="salinan kepada" ></textarea>
                                </div>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>


</body>
</html>
