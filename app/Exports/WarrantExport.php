<?php

namespace App\Exports;

use App\Http\Controllers\Maintenance\Warrant\WarrantDistributionDAO;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\FleetDisposal;
use App\Models\Maintenance\WarrantDetail;
use App\Models\Maintenance\WarrantDetailStatement;
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
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WarrantExport implements WithDrawings, WithColumnWidths, WithStyles, WithHeadingRow, FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{

    public $id;

    public function __construct(Request $request)
    {
        $this->id = $request->id;
        $this->fleet_view = $request->fleet_view;
        $this->month = 10;
        $this->year = 2021;
        $this->osolType = '01';

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

        $rangeMonth = "";
        for ($i = 1; $i <= $this->month; $i++) {
            if($i == $this->month) {
                $rangeMonth .= $i;
            }else {
                $rangeMonth .= $i.',';
            }
           
          }

       // Log::info('rangeMonth->'.$rangeMonth);
        
             $query = DB::select(DB::raw('
             WITH tbl1 AS (
                select  sum(addition) as carry_addition , sum(deduct) as carry_deduct , sum(total_allocation) as carry_total_allocation ,sum(expense) as carry_expense ,sum(advance) as carry_advance, sum(total_expense) as carry_total_expense , sum(balance) as carry_balance ,workshop_id as wd_id_sum
                from maintenance.warrant_detail 
                where waran_type_id = 1 
                and osol_type_id= ?
                and year = ?
                and month in ('.$rangeMonth.')
                group by workshop_id
            )
            , tbl2 AS (
                select row_number() over (order by workshop_id) as bil,id, workshop_id , waran_type_id, osol_type_id , state, allocation , addition, deduct, total_allocation, expense , advance, total_expense ,balance, COALESCE(percent_expense,0) AS percent_expense, COALESCE(percent_advance,0) AS percent_advance, COALESCE(percent_financial,0) AS percent_financial  
                from maintenance.warrant_detail
                where waran_type_id = 1 
                and osol_type_id= ?
                and year = ?
                and month = ?
            )
                select t2.state,t2.allocation,t2.addition, t2.deduct, t2.deduct,t2.total_allocation,t1.carry_expense,t1.carry_advance,t1.carry_total_expense ,t2.balance from
                tbl1 t1
                right join tbl2 t2
                on t1.wd_id_sum =  t2.workshop_id
                order by workshop_id 
    
        '),[$this->osolType,$this->year,$this->osolType,$this->year,$this->month]);
        
       // $attributes = array_keys((array) $query[0]);
        return collect($query);
    }
     public function headings(): array
    {


        $rangeMonth = "";
        for ($i = 1; $i <= $this->month; $i++) {
            if($i == $this->month) {
                $rangeMonth .= $i;
            }else {
                $rangeMonth .= $i.',';
            }
           
          }


        $query = DB::select(DB::raw('
        WITH tbl1 AS (
           select  sum(addition) as carry_addition , sum(deduct) as carry_deduct , sum(total_allocation) as carry_total_allocation ,sum(expense) as carry_expense ,sum(advance) as carry_advance, sum(total_expense) as carry_total_expense , sum(balance) as carry_balance ,workshop_id as wd_id_sum
           from maintenance.warrant_detail 
           where waran_type_id = 1 
           and osol_type_id= ?
           and year = ?
           and month in ('.$rangeMonth.')
           group by workshop_id
       )
       , tbl2 AS (
           select row_number() over (order by workshop_id) as bil,id, workshop_id , waran_type_id, osol_type_id , state, allocation , addition, deduct, total_allocation, expense , advance, total_expense ,balance, COALESCE(percent_expense,0) AS percent_expense, COALESCE(percent_advance,0) AS percent_advance, COALESCE(percent_financial,0) AS percent_financial  
           from maintenance.warrant_detail
           where waran_type_id = 1 
           and osol_type_id= ?
           and year = ?
           and month = ?
       )
           select t2.state,t2.allocation,t2.addition, t2.deduct,t2.total_allocation,t1.carry_expense,t1.carry_advance,t1.carry_total_expense ,t2.balance from
           tbl1 t1
           right join tbl2 t2
           on t1.wd_id_sum =  t2.workshop_id
           order by workshop_id limit 1

   '),[$this->osolType,$this->year,$this->osolType,$this->year,$this->month]);

        $attributes = array_keys((array) $query[0]);

        $afterMassage = [];
        $mappingColName = [
            'state' => 'NEGERI',
            'allocation' => 'PERUNTUKAN',
            'addition' => 'TAMBAHAN',
            'deduct' => 'TARIK BALIK',
            'total_allocation' => 'JUMLAH',
            'carry_expense' => 'PERBELANJAAN',
            'carry_advance' => 'TANGGUNGAN',
            'carry_total_expense' => 'JUMLAH',
            'balance' => 'BAKI (RM)',

        ];
        foreach ($attributes as $key) {
            array_push($afterMassage, isset($mappingColName[$key]) ?  strtoupper($mappingColName[$key]) : strtoupper($key)); //contoh dynamic/mapping
            }

        return $mappingColName;

         $table = FleetDepartment::class;
         if (ob_get_contents()) {ob_end_clean();}
        switch ($this->fleet_view) {
            case 'department':
                $table = new FleetDepartment;
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'no_engine', 'no_chasis',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'tarikh_pemeriksaan_keselamatan', 'manufacture_year','tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab',
                'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
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
                Log::info('attributes table');
                Log::info($table->getAttributes());
                Log::info('attributes');
                Log::info($attributes);
                break;
            case 'public':
                $table = new FleetPublic;
                $table->setTable('fleet.fleet_public AS fd');
                $table = $table->select('fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'contract_no', 'project_name', 'hopt', 'contractor_name', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'no_engine', 'no_chasis',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'tarikh_pemeriksaan_keselamatan', 'manufacture_year','tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab',
                'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
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
                $table = $table->select('fd.no_pendaftaran', 'rot.desc_bm as hakmilik', 'rs.desc as negeri', 'ro.name as cawangan', 'fp.desc as lokasi_penempatan', 'no_id_pemunya',
                'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr', 'fd.no_loji', 'no_engine', 'no_chasis', 'no_resit', 'dispose_dt','rdi.desc as kaedah_pelupusan', 'pembeli',
                'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'tarikh_pemeriksaan_keselamatan', 'manufacture_year','tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab',
                'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
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
        
        // Log::info('attributes');
        // Log::info($attributes);

        // $afterMassage = ['Bil'];
        // $mappingColName = [
        //     'no_pendaftaran' => 'no.pendaftaran',
        //     'negeri' => 'negeri',
        //     'cawangan' => 'cawangan',
        //     'lokasi_penempatan' => 'lokasi penempatan',
        //     'kategori' => 'kategori',
        //     'sub_kategori' => 'sub kategori',
        //     'jenis' => 'jenis',
        //     'jenama' => 'pembuat',
        //     'model' => 'model',
        //     'no_chasis' => 'no.chasis',
        //     'no_engine' => 'no.enjin',
        //     'no_id_pemunya' => 'no.id pemunya',
        //     'no_loji' => 'no.loji',
        //     'no_jkr' => 'no.jkr',
        //     'tarikh_cukai_jalan' => 'tarikh cukai jalan',
        //     'harga_perolehan' => 'harga perolehan',
        //     'tarikh_pembelian_kenderaan' => 'tarikh pembelian kenderaan',
        //     'tarikh_pemeriksaan_keselamatan' => 'tarikh pemeriksaan keselamatan',
        //     'manufacture_year' => 'tahun dibuat',
        //     'tarikh_kemaskini' => 'tarikh kemaskini',
        //     'acqDt' => 'tarikh perolehan',
        //     'status' => 'status',
        //     'pegawai_bertanggungjawab' => 'pegawai bertanggungjawab',
        //     'pegawai_kemaskini' => 'pegawai kemaskini',
        //     'contract_no' => 'no kontrak',
        //     'project_name' => 'nama projek',
        //     'hopt' => 'head of project manager',
        //     'contractor_name' => 'nama syarikat',
        //     'project_start_dt' => 'tarikh mula',
        //     'project_end_dt' => 'tarikh tamat',
        //     'project_cpc_dt' => 'tarikh cpc',
        //     'kaedah_pelupusan' => 'kaedah pelupusan',
        //     'pembeli' => 'pembeli',
        //     'no_resit' => 'no resit rasmi',
        //     'dispose_dt' => 'tarikh lupus',
        // ];

        // foreach ($attributes as $key) {
        //     array_push($afterMassage, isset($mappingColName[$key]) ?  strtoupper($mappingColName[$key]) : strtoupper($key)); //contoh dynamic/mapping
        //     // array_push($afterMassage, strtoupper($key));
        // }

        // Log::info('afterMassage');
        // Log::info($afterMassage);

        // return $afterMassage;
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
                    array(' Senarai Kenderaan ')
                    // array(' Senarai Kenderaan '),
                ), $event);

                $event->sheet->mergeCells('A1:AE5');
                // $event->sheet->mergeCells('A6:AC6');

                $event->sheet->getDelegate()->getStyle('A1:AE5')->ApplyFromArray([

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

                $last_row = $event->sheet->getHighestRow()+1;
                Log::info('total rows '.$last_row );

                $event->sheet->appendRows(array(
                    array('Jumlah', '2000')
                    // array(' Senarai Kenderaan '),
                ), $event);
                
                Log::info($event->sheet->getHighestRow());

                $event->sheet->getDelegate()->getStyle('A'.$last_row.':E'.$last_row)->ApplyFromArray($styleArray);

            }
        ];
    }

    public function title(): string
    {
    	return 'Senarai Kenderaan';
    }
}
