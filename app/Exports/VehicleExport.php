<?php

namespace App\Exports;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\FleetDisposal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VehicleExport implements WithDrawings, WithColumnWidths, WithStyles, WithHeadingRow, FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    public $id;
    public $total = 0;

    public function __construct(Request $request)
    {
        $this->id = $request->id;
        $this->fleet_view = $request->fleet_view;
        $this->owner_id = $request->owner_id;
        $this->state_id = $request->state_id;
        $this->type_id = $request->type_id;
        $this->index = 0;
        $this->status = $request->status ? $request->status: 'approved';
    }

    public function drawings()
    {
        // $drawing = new Drawing();
        // $drawing->setName('Logo');
        // $drawing->setDescription('This is my logo');
        // $drawing->setPath(public_path('/my-assets/img/logo.png'));
        // $drawing->setHeight(70);
        // $drawing->setOffsetX(15);
        // $drawing->setOffsetY(15);
        // $drawing->setCoordinates('A1');

        return [];
    }

    public function columnWidths(): array
    {
        return [];
    }

    public function styles(Worksheet $sheet)
    {
        return [

            // Styling an entire column.
            'A1:AC1'  => ['font' => ['size' => 20]],
        ];
    }

    public function model(array $row)
    {
        return 'asd';
    }

    public function headingRow(): int
    {
        return 2;
    }

    public function collection()
    {
        Log::info('id -> '.$this->id);
        Log::info('fleet_view -> '.$this->fleet_view);

        $mapStatus = [
            'draf' => '2',
            'verification' => '3',
            'approval' => '4',
            'approved' => '7'
        ];

        $table = FleetDepartment::class;
        if (ob_get_contents()) {ob_end_clean();}
        switch ($this->fleet_view) {
            case 'department':
                $table = new FleetDepartment;
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('fd.id AS id','fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'fd.no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'fd.no_engine', 'fd.no_chasis',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan','tarikh_pemeriksaan_keselamatan', 'manufacture_year', DB::raw('trim(concat(uub.name, \', \' , tarikh_kemaskini))'), 'us.name as pegawai_bertanggungjawab')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->leftJoin('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('users.users as uub','fd.updated_by', '=','uub.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id');

                $this->total = $table->count();
                break;
            case 'public':
                $table = new FleetPublic();
                $table->setTable('fleet.fleet_public AS fd');
                $table = $table->select('fd.id AS id','fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'contract_no', 'project_name', 'hopt', 'contractor_name', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'fd.no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'fd.no_engine', 'fd.no_chasis',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan','tarikh_pemeriksaan_keselamatan', 'manufacture_year', DB::raw('trim(concat(tarikh_kemaskini, \', \', uub.name))'), 'us.name as pegawai_bertanggungjawab')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->leftJoin('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('fleet.fleet_project as fpr', 'fd.project_id', '=', 'fpr.id')
                ->leftJoin('users.users as uub','fd.updated_by', '=','uub.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id');
                $this->total = $table->count();
                break;

            case 'disposal':
                $table = new FleetDisposal();
                $table->setTable('fleet.fleet_disposal AS fd');
                $table = $table->select('fd.id AS id','fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'fd.no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'fd.no_engine', 'fd.no_chasis', 'no_resit', 'dispose_dt','rdi.desc as kaedah_pelupusan', 'pembeli',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan','tarikh_pemeriksaan_keselamatan', 'manufacture_year', DB::raw('trim(concat(tarikh_kemaskini, \', \',uub.name))'), 'us.name as pegawai_bertanggungjawab')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->leftJoin('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('ref_disposal as rdi', 'fd.disposal_id','=', 'rdi.id')
                ->leftJoin('users.users as uub','fd.updated_by', '=','uub.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id');
                $this->total = $table->count();
                break;

            default:
                # code...
                break;
        }

        if($this->owner_id){
            $table->where('fd.cawangan_id', $this->owner_id);
        }
        if($this->state_id){
            $table->where('fd.state_id', $this->state_id);
        }
        if($this->type_id){
            $table->where('fd.sub_category_type_id', $this->type_id);
        }

        $table->whereRaw(' fd.vapp_status_id IN ('.$mapStatus[$this->status].')');

        // return $table::all();
 
        Log::info($table->toSql());

        return collect($table->get())->map(function ($data) {

            $this->index += 1;
            $data['id'] = $this->index;
        
            return $data;
        
        });
    }
     public function headings(): array
    {

        $table = FleetDepartment::class;

        switch ($this->fleet_view) {
            case 'department':
                $table = new FleetDepartment;
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'fd.no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'fd.no_engine', 'fd.no_chasis',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan','tarikh_pemeriksaan_keselamatan', 'manufacture_year','tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab',
                'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->leftJoin('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                    ->first();
                $attributes = array_keys($table->getAttributes());
                break;
            case 'public':
                $table = new FleetPublic;
                $table->setTable('fleet.fleet_public AS fd');
                $table = $table->select('fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'contract_no', 'project_name', 'hopt', 'contractor_name', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'fd.no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'fd.no_engine', 'fd.no_chasis',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan','tarikh_pemeriksaan_keselamatan', 'manufacture_year','tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab',
                'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->leftJoin('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('fleet.fleet_project as fpr', 'fd.project_id', '=', 'fpr.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                    ->first();
                $attributes = array_keys($table->getAttributes());
                break;

            case 'disposal':
                $table = new FleetDisposal();
                $table->setTable('fleet.fleet_disposal AS fd');
                $table = $table->select('fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'fd.no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'fd.no_engine', 'fd.no_chasis', 'no_resit', 'dispose_dt','rdi.desc as kaedah_pelupusan', 'pembeli',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan','tarikh_pemeriksaan_keselamatan', 'manufacture_year','tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab',
                'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->leftJoin('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('ref_disposal as rdi', 'fd.disposal_id','=', 'rdi.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                    ->first();
                $attributes = array_keys($table->getAttributes());
                break;

            default:
                # code...
                break;
        }

        $afterMassage = ['Bil'];
        $mappingColName = [
            'no_pendaftaran' => 'no.pendaftaran',
            'negeri' => 'negeri',
            'cawangan' => 'cawangan',
            'lokasi_penempatan' => 'lokasi penempatan',
            'kategori' => 'kategori',
            'sub_kategori' => 'sub kategori',
            'jenis' => 'jenis',
            'jenama' => 'pembuat',
            'model' => 'model',
            'fd.no_chasis' => 'no.chasis',
            'fd.no_engine' => 'no.enjin',
            'fd.no_id_pemunya' => 'no.id pemunya',
            'no_loji' => 'no.loji',
            'no_jkr' => 'no.jkr',
            'tarikh_cukai_jalan' => 'tarikh cukai jalan',
            'harga_perolehan' => 'harga perolehan',
            'tarikh_pemeriksaan_keselamatan' => 'tarikh pemeriksaan keselamatan',
            'manufacture_year' => 'tahun dibuat',
            'tarikh_kemaskini' => 'tarikh kemaskini',
            'acqDt' => 'tarikh perolehan',
            'status' => 'status',
            'pegawai_bertanggungjawab' => 'pegawai bertanggungjawab',
            'contract_no' => 'no kontrak',
            'project_name' => 'nama projek',
            'hopt' => 'head of project manager',
            'contractor_name' => 'nama syarikat',
            'project_start_dt' => 'tarikh mula',
            'project_end_dt' => 'tarikh tamat',
            'project_cpc_dt' => 'tarikh cpc',
            'kaedah_pelupusan' => 'kaedah pelupusan',
            'pembeli' => 'pembeli',
            'no_resit' => 'no resit rasmi',
            'dispose_dt' => 'tarikh lupus',
        ];

        foreach ($attributes as $key) {
            array_push($afterMassage, isset($mappingColName[$key]) ?  strtoupper($mappingColName[$key]) : strtoupper($key)); //contoh dynamic/mapping
            // array_push($afterMassage, strtoupper($key));
        }

        Log::info($afterMassage);

        return $afterMassage;
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

        return [
            BeforeSheet::class => function(BeforeSheet $event) use ($styleArray)
            {
                $event->sheet->appendRows(array(
                    array(' Senarai Kenderaan JKR - '.Carbon::now()->format('d.m.Y'))
                    // array(' Senarai Kenderaan '),
                ), $event);

                $event->sheet->mergeCells('A1:AE5');
                // $event->sheet->mergeCells('A6:AC6');

                $event->sheet->getDelegate()->getStyle('A1:AE5')->ApplyFromArray([

                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_LEFT,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM,
                        ]]
                ]);
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(10);

            },
            AfterSheet::class => function(AfterSheet $event) use ($styleArray)
            {
                $cellRange = 'A6:AE6';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->ApplyFromArray($styleArray);

                // $last_row = $event->sheet->getHighestRow()+1;
                // Log::info('total rows '.$last_row );

                // $event->sheet->appendRows(array(
                //     array('Jumlah', '2000')
                //     // array(' Senarai Kenderaan '),
                // ), $event);

                // Log::info($event->sheet->getHighestRow());

                // $event->sheet->getDelegate()->getStyle('A'.$last_row.':E'.$last_row)->ApplyFromArray($styleArray);

                // $styleArrayFill = [
                //     'fillType' => Fill::FILL_SOLID,

                // ];

                // $event->sheet->getDelegate()->getStyle('A'.$last_row.':E'.$last_row)->getFill()->applyFromArray($styleArrayFill);


            }
        ];
    }

    public function title(): string
    {
    	return 'Senarai Kenderaan';
    }
}
