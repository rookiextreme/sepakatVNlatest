<?php

namespace App\Exports;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\Logistic\LogisticBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReportBookingExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    public $id;
    public $fleet_view = "department";

    public function collection()
    {
        Log::info('id -> '.$this->id);
        // Log::info('fleet_view -> '.$this->fleet_view);

        $table = LogisticBooking::class;

        if (ob_get_contents()) {ob_end_clean();}
        switch ($this->fleet_view) {

            case 'department':
                $table = new LogisticBooking();
                $table->setTable('logistic.logistic_booking');
                $table->select('tel_no as tel_no','reason as reason','destination as destination','start_datetime as start_datetime','end_datetime as end_datetime');
                Log::info($table->get());
                return $table->get();
                break;
            case 'public':
                // $table = new FleetPublic();
                // $table->setTable('fleet.fleet_public AS fd');
                // $table = $table->select('fp.no_pendaftaran', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'rc.name as kategori', 'rsc.name as sub_kategori',
                // 'rsct.name as jenis', 'vb.name as jenama', 'vm.name as model', 'no_chasis', 'no_engine', 'tarikh_belian', 'no_resit', 'pembeli', 'comment', 'fp.no_loji','tarikh_cukai_jalan',
                // 'harga_perolehan', 'fp.tarikh_pembelian_kenderaan', 'no_lo', 'tarikh_pemeriksaan_fizikal', 'tarikh_pemeriksaan_keselamatan', 'manufacture_year',
                // 'tarikh_kemaskini', 'acqDt', 'rvs.desc as status', 'us.name as pegawai_bertanggungjawab', 'disaster_ready as siapsiaga')
                // ->leftJoin('ref_state as rs','fp.state_id', '=','rs.id')
                // ->leftJoin('ref_owner as ro','fp.cawangan_id', '=','ro.id')
                // ->leftJoin('fleet.fleet_placement as fp','fp.placement_id', '=','fp.id')
                // ->leftJoin('ref_category as rc','fp.category_id', '=','rc.id')
                // ->leftJoin('ref_sub_category as rsc','fp.sub_category_id', '=','rsc.id')
                // ->leftJoin('ref_sub_category_type as rsct','fp.sub_category_type_id', '=','rsct.id')
                // ->leftJoin('vehicles.brands as vb','fp.brand_id', '=','vb.id')
                // ->leftJoin('vehicles.vehicle_models as vm','fp.model_id', '=','vm.id')
                // ->leftJoin('ref_vehicle_status as rvs','fp.vehicle_status_id', '=','rvs.id')
                // ->leftJoin('users.users as us','fp.person_incharge_id', '=','us.id');
                // break;

            default:
                # code...
                break;
        }

        // return $table::all();

    }
     public function headings(): array
    {

        $table = LogisticBooking::class;

        switch ($this->fleet_view) {
            case 'department':
                $table = new LogisticBooking;
                $table->setTable('logistic.logistic_booking');
                $table->select('tel_no as tel_no','reason as reason','destination as destination','start_datetime as start_datetime','end_datetime as end_datetime')->first();
                $attributes = array_keys($table->getAttributes());
                break;
            case 'public':
                // $table = new FleetPublic;
                // $table->setTable('fleet.fleet_public AS fp');
                // $table = $table->select('fp.no_pendaftaran', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'rc.name as kategori', 'rsc.name as sub_kategori',
                // 'rsct.name as jenis', 'vb.name as jenama', 'vm.name as model', 'no_chasis', 'no_engine', 'tarikh_belian', 'no_resit', 'pembeli', 'comment', 'fp.no_loji','tarikh_cukai_jalan',
                // 'harga_perolehan', 'fp.tarikh_pembelian_kenderaan', 'no_lo', 'tarikh_pemeriksaan_fizikal', 'tarikh_pemeriksaan_keselamatan', 'manufacture_year',
                // 'tarikh_kemaskini', 'acqDt', 'rvs.desc as status', 'us.name as pegawai_bertanggungjawab', 'disaster_ready as siapsiaga')
                // ->leftJoin('ref_state as rs','fp.state_id', '=','rs.id')
                // ->leftJoin('ref_owner as ro','fp.cawangan_id', '=','ro.id')
                // ->leftJoin('fleet.fleet_placement as fp','fp.placement_id', '=','fp.id')
                // ->leftJoin('ref_category as rc','fp.category_id', '=','rc.id')
                // ->leftJoin('ref_sub_category as rsc','fp.sub_category_id', '=','rsc.id')
                // ->leftJoin('ref_sub_category_type as rsct','fp.sub_category_type_id', '=','rsct.id')
                // ->leftJoin('vehicles.brands as vb','fp.brand_id', '=','vb.id')
                // ->leftJoin('vehicles.vehicle_models as vm','fp.model_id', '=','vm.id')
                // ->leftJoin('ref_vehicle_status as rvs','fp.vehicle_status_id', '=','rvs.id')
                // ->leftJoin('users.users as us','fp.person_incharge_id', '=','us.id')
                //     ->first();
                // $attributes = array_keys($table->getAttributes());
                break;

            default:
                # code...
                break;
        }

        $afterMassage = [];
        $mappingColName = [
            'tel_no' => 'tel_no',
            'reason' => 'reason',
            'start_datetime' => 'start_datetime',
            'end_datetime' => 'end_datetime',
        ];

        foreach ($attributes as $key) {
            array_push($afterMassage, isset($mappingColName[$key]) ?  strtoupper($mappingColName[$key]) : strtoupper($key)); //contoh dynamic/mapping
            // array_push($afterMassage, strtoupper($key));
        }

        Log::info($afterMassage);

        // Log::info($attributes);
        return $afterMassage;
        // return [
        //     'No Pendaftaran',
        //     'Kategori',
        //     'Milik',
        //     'Lokasi',
        //     'Umur',
        //     'Pengeluar',
        //     'Model'
        // ];
    }

    public function registerEvents(): array
    {

        $styleArray = [
                'font' => [
                'bold' => true
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => Border::BORDER_MEDIUM,
                        'color'       => [
                            'argt' => 'black',
                            'argb' => 'black',
                            'argl' => 'black',
                            'argr' => 'black'
                        ],
                        'cellpadding' => '5',
                        'cellspacing' => '5',
                    ],
                ]
        ];

        // $styleTitle = [
        //         'title' => 'title',
        // ];

        return [
            AfterSheet::class    => function(AfterSheet $event) use ($styleArray)
            {
                // $cellTitle = 'A1:D1';
                $cellRange = 'A1:A5'; // All headers
                // $cellRangeRoaw = 'A10:A20'; // All rows
                // $event->sheet->getDelegate()->getStyle($cellTitle)->ApplyFromArray($styleTitle);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->ApplyFromArray($styleArray);
                //$event->sheet->setAllBorders('thin');
            },
        ];
    }
}
