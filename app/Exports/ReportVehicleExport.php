<?php

namespace App\Exports;

use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetDepartmentView;
use App\Models\Fleet\FleetLookupVehicle;
use App\Models\Fleet\FleetPublic;
use App\Models\Fleet\FleetPublicVIew;
use App\Models\FleetDisposal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportVehicleExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{

    public $id;
    public $index = 0;
    public $xid = null;
    public $ownership = null;
    public $fleet_view = null;
    public $search = null;
    public $filterOpt = null;

    public function __construct(Request $request)
    {
        $this->index = 0;
        $this->id = $request->id;
        $this->xid = $request->xid;
        $this->ownership = $request->ownership;
        $this->fleet_view = $request->fleet_view;
        $this->search = $request->search;
        $this->filterOpt = $request->filterOpt;
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
        Log::info('ownership -> '.$this->ownership);

        $table = FleetDepartmentView::class;
        if (ob_get_contents()) {ob_end_clean();}
        switch ($this->fleet_view) {
            case 'department':

                $table = new FleetDepartment();
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('fd.id as id', 'rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan', 'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori',
                'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'rvs.desc as status','harga_perolehan', DB::raw("TO_CHAR(\"fd\".\"acqDt\", 'dd/mm/yyyy')"),
                'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', DB::raw("concat(fd.updated_at, ' ', u_by.name) as tarikh_kemaskini"), 'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('users.users as u_by','fd.updated_by', '=','u_by.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id');
                break;
            case 'public':
                $table = new FleetPublic();
                $table->setTable('fleet.fleet_public AS fd');
                $table = $table->select('fd.id as id', 'rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'contract_no', 'project_name', 'hopt', 'contractor_name', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan',
                'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis',DB::raw("TO_CHAR(fpr.project_start_dt, 'dd/mm/yyyy')"),
                'fpr.project_end_dt', 'fpr.project_cpc_dt', 'rvs.desc as status', 'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', DB::raw("concat(fd.updated_at, ' ', u_by.name) as tarikh_kemaskini"),
                'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('users.users as u_by','fd.updated_by', '=','u_by.id')
                ->leftJoin('fleet.fleet_project as fpr', 'fd.project_id', '=', 'fpr.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id');
                break;
            case 'disposal':
                $table = new FleetDisposal();
                $table->setTable('fleet.fleet_disposal AS fd');
                $table = $table->select('fd.id as id', 'rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan', 'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori',
                'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'no_resit', DB::raw("TO_CHAR(fd.dispose_dt, 'dd/mm/yyyy')"),'rdi.desc as kaedah_pelupusan', 'pembeli', 'rvs.desc as status', 'harga_perolehan',
                'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', DB::raw("concat(fd.updated_at, ' ', u_by.name) as tarikh_kemaskini"), 'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('users.users as u_by','fd.updated_by', '=','u_by.id')
                ->leftJoin('ref_disposal as rdi', 'fd.disposal_id','=', 'rdi.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id');
                break;

            default:

                $table = new FleetDepartment();
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('fd.id as id', 'rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan', 'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori',
                'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'rvs.desc as status','harga_perolehan', DB::raw("TO_CHAR(\"fd\".\"acqDt\", 'dd/mm/yyyy')"),
                'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', DB::raw("concat(fd.updated_at, ' ', u_by.name) as tarikh_kemaskini"), 'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('users.users as u_by','fd.updated_by', '=','u_by.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                ->where('fd.disaster_ready', '=', 'TRUE');
                break;
        }

        if($this->search){
            $this->search = strtoupper($this->search);

            switch ($this->filterOpt) {
                case 'flt-plateno':
                    $table->whereRaw("upper(fd.no_pendaftaran) LIKE '%".$this->search."%'");
                    break;
                case 'flt-negeri':
                    $table->whereRaw("upper(rs.desc) LIKE '%".$this->search."%'");
                    break;
                case 'flt-jenis':
                    $table->whereRaw("upper(rsc.name) LIKE '%".$this->search."%'");
                    break;
                default:
                    $table->whereRaw("(upper(fd.no_pendaftaran) LIKE '%".$this->search."%' OR upper(rs.desc) LIKE '%".$this->search."%' OR upper(rsc.name) LIKE '%".$this->search."%')");
                    break;
            }
        }

        if($this->search){
            $table->whereRaw($this->checkXid($this->xid, $this->search));
        }

        Log::info('$this->ownership => '.$this->ownership);

        if($this->ownership == 'jkr'){
            $table->whereRaw("rot.code = '01'");
        } else if($this->ownership == 'state'){
            $table->whereRaw("rot.code = '02'");
        }

        return collect($table->get())->map(function ($data) {

            $this->index += 1;
            $data['id'] = $this->index;
        
            return $data;
        
        });
    }

    public function checkXid($xid, $search){
        if($xid == 0){
            $query = "upper(\"NO.PENDAFTARAN\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 1){
            $query = "upper(\"NO.PENDAFTARAN\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 2){
            $query = "upper(\"NO.JKR\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 3){
            $query = "upper(\"LOKASI PENEMPATAN\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 4){
            $query = "upper(\"HAK MILIK\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 5){
            $query = "upper(\"JENIS\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 6){
            $query = "upper(\"PEMBUAT\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 7){
            $query = "upper(\"NEGERI\") LIKE '%".strtoupper($search)."%' ";
        }elseif($xid == 8){
            $query = "upper(\"CAWANGAN\") LIKE '%".strtoupper($search)."%' ";
        }else{
            $query = "upper(\"NO.PENDAFTARAN\") LIKE '%".strtoupper($search)."%' ";
        }

        return $query;
    }

     public function headings(): array
    {

        $table = FleetDepartmentView::class;
        if (ob_get_contents()) {ob_end_clean();}

        switch ($this->fleet_view) {
            case 'department':
                $table = new FleetDepartment();
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan', 'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori',
                'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'rvs.desc as status','harga_perolehan', 'acqDt',
                'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', 'tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                    ->first();

                    Log::info($table->toSql());
                $attributes = array_keys($table->getAttributes());
                break;
            case 'public':
                $table = new FleetPublic();
                $table->setTable('fleet.fleet_public AS fd');
                $table = $table->select('rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'contract_no', 'project_name', 'hopt', 'contractor_name', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan',
                'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori', 'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'fpr.project_start_dt',
                'fpr.project_end_dt', 'fpr.project_cpc_dt', 'rvs.desc as status', 'rvs.desc as status', 'harga_perolehan', 'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', 'tarikh_kemaskini',
                'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('fleet.fleet_project as fpr', 'fd.project_id', '=', 'fpr.id')
                ->leftJoin('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                    ->first();
                $attributes = array_keys($table->getAttributes());
                break;
            case 'disposal':
                $table = new FleetDisposal();
                $table->setTable('fleet.fleet_disposal AS fd');
                $table = $table->select('rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan', 'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori',
                'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'no_resit', 'dispose_dt','rdi.desc as kaedah_pelupusan', 'pembeli', 'rvs.desc as status', 'harga_perolehan',
                'acqDt', 'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', 'tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_state as rs','fd.state_id', '=','rs.id')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->leftJoin('ref_disposal as rdi', 'fd.disposal_id','=', 'rdi.id')
                ->leftJoin('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                    ->first();
                $attributes = array_keys($table->getAttributes());
                break;

            default:

                $table = new FleetDepartment();
                $table->setTable('fleet.fleet_department AS fd');
                $table = $table->select('rot.desc_bm as hakmilik', 'ro.name as cawangan', 'fd.no_pendaftaran', 'rs.desc as negeri', 'fp.desc as lokasi_penempatan', 'no_id_pemunya', 'rc.name as kategori', 'rsc.name as sub_kategori',
                'rsct.name as jenis', 'vb.name as pembuat', 'vm.name as model', 'fd.no_jkr as no_jkr', 'fd.no_loji as no_loji', 'no_engine', 'no_chasis', 'rvs.desc as status','harga_perolehan', 'acqDt',
                'tarikh_cukai_jalan', 'fd.tarikh_pembelian_kenderaan', 'manufacture_year', 'tarikh_kemaskini', 'us.name as pegawai_bertanggungjawab', 'us.name as pegawai_kemaskini')
                ->leftJoin('ref_owner as ro','fd.cawangan_id', '=','ro.id')
                ->leftJoin('fleet.fleet_placement as fp','fd.placement_id', '=','fp.id')
                ->leftJoin('ref_state as rs','fp.ref_state_id', '=','rs.id')
                ->leftJoin('ref_category as rc','fd.category_id', '=','rc.id')
                ->leftJoin('ref_sub_category as rsc','fd.sub_category_id', '=','rsc.id')
                ->leftJoin('ref_sub_category_type as rsct','fd.sub_category_type_id', '=','rsct.id')
                ->leftJoin('vehicles.brands as vb','fd.brand_id', '=','vb.id')
                ->leftJoin('vehicles.vehicle_models as vm','fd.model_id', '=','vm.id')
                ->join('ref_vehicle_status as rvs','fd.vehicle_status_id', '=','rvs.id')
                ->leftJoin('users.users as us','fd.person_incharge_id', '=','us.id')
                ->join('ref_owner_type as rot', 'fd.owner_type_id', '=', 'rot.id')
                ->where('fd.disaster_ready', '=', 'TRUE')
                    ->first();
                $attributes = array_keys($table->getAttributes());
                break;
        }

        $afterMassage = ['Bil'];

        if($this->fleet_view == 'department'){
            $mappingColName = [
                'hakmilik' => 'hak milik',
                'cawangan' => 'cawangan',
                'no_pendaftaran' => 'no. pendaftaran',
                'negeri' => 'negeri',
                'lokasi_penempatan' => 'lokasi penempatan',
                'no_id_pemunya' => 'no id pemunya',
                'kategori' => 'kategori',
                'sub_kategori' => 'sub kategori',
                'jenis' => 'jenis',
                'pembuat' => 'pembuat',
                'model' => 'model',
                'no_chasis' => 'no chasis',
                'no_engine' => 'no enjin',
                'no_loji' => 'no loji',
                'no_jkr' => 'no jkr',
                'tarikh_cukai_jalan' => 'tarikh cukai jalan',
                'harga_perolehan' => 'harga perolehan',
                'tarikh_pembelian_kenderaan' => 'tarikh pembelian kenderaan',
                'tarikh_pemeriksaan_keselamatan' => 'tarikh pemeriksaan keselamatan',
                'manufacture_year' => 'tahun dibuat',
                'tarikh_kemaskini' => 'tarikh kemaskini',
                'acqDt' => 'tarikh perolehan',
                'status' => 'status',
                'pegawai_bertanggungjawab' => 'pegawai bertanggungjawab',
                'pegawai_kemaskini' => 'pegawai kemaskini',
            ];
        }elseif($this->fleet_view == 'public'){
            $mappingColName = [
                'hakmilik' => 'hak milik',
                'cawangan' => 'cawangan',
                'no_pendaftaran' => 'no. pendaftaran',
                'contract_no' => 'no kontrak',
                'project_name' => 'nama projek',
                'hopt' => 'head of project manager',
                'contractor_name' => 'nama syarikat',
                'project_start_dt' => 'tarikh mula',
                'project_end_dt' => 'tarikh tamat',
                'project_cpc_dt' => 'tarikh cpc',
                'lokasi_penempatan' => 'lokasi penempatan',
                'no_id_pemunya' => 'no id pemunya',
                'kategori' => 'kategori',
                'sub_kategori' => 'sub kategori',
                'jenis' => 'jenis',
                'pembuat' => 'pembuat',
                'model' => 'model',
                'no_chasis' => 'no chasis',
                'no_engine' => 'no enjin',
                'no_loji' => 'no loji',
                'no_jkr' => 'no jkr',
                'tarikh_cukai_jalan' => 'tarikh cukai jalan',
                'harga_perolehan' => 'harga perolehan',
                'tarikh_pembelian_kenderaan' => 'tarikh pembelian kenderaan',
                'tarikh_pemeriksaan_keselamatan' => 'tarikh pemeriksaan keselamatan',
                'manufacture_year' => 'tahun dibuat',
                'tarikh_kemaskini' => 'tarikh kemaskini',
                'acqDt' => 'tarikh perolehan',
                'status' => 'status',
                'pegawai_bertanggungjawab' => 'pegawai bertanggungjawab',
                'pegawai_kemaskini' => 'pegawai kemaskini',
            ];
        }elseif($this->fleet_view == 'disposal'){
            $mappingColName = [
                'hakmilik' => 'hak milik',
                'cawangan' => 'cawangan',
                'no_pendaftaran' => 'no. pendaftaran',
                'negeri' => 'negeri',
                'lokasi_penempatan' => 'lokasi penempatan',
                'no_id_pemunya' => 'no id pemunya',
                'kategori' => 'kategori',
                'sub_kategori' => 'sub kategori',
                'jenis' => 'jenis',
                'pembuat' => 'pembuat',
                'model' => 'model',
                'no_chasis' => 'no chasis',
                'no_engine' => 'no enjin',
                'no_loji' => 'no loji',
                'no_jkr' => 'no jkr',
                'tarikh_cukai_jalan' => 'tarikh cukai jalan',
                'no_resit' => 'no resit rasmi',
                'dispose_dt' => 'tarikh lupus',
                'harga_perolehan' => 'harga perolehan',
                'tarikh_pembelian_kenderaan' => 'tarikh pembelian kenderaan',
                'tarikh_pemeriksaan_keselamatan' => 'tarikh pemeriksaan keselamatan',
                'manufacture_year' => 'tahun dibuat',
                'tarikh_kemaskini' => 'tarikh kemaskini',
                'acqDt' => 'tarikh perolehan',
                'status' => 'status',
                'pegawai_bertanggungjawab' => 'pegawai bertanggungjawab',
                'pegawai_kemaskini' => 'pegawai kemaskini',
                'kaedah_pelupusan' => 'kaedah pelupusan',
                'pembeli' => 'pembeli'
            ];
        }else{
            $mappingColName = [
                'hakmilik' => 'hak milik',
                'cawangan' => 'cawangan',
                'no_pendaftaran' => 'no. pendaftaran',
                'negeri' => 'negeri',
                'lokasi_penempatan' => 'lokasi penempatan',
                'no_id_pemunya' => 'no id pemunya',
                'kategori' => 'kategori',
                'sub_kategori' => 'sub kategori',
                'jenis' => 'jenis',
                'pembuat' => 'pembuat',
                'model' => 'model',
                'no_chasis' => 'no chasis',
                'no_engine' => 'no enjin',
                'no_loji' => 'no loji',
                'no_jkr' => 'no jkr',
                'tarikh_cukai_jalan' => 'tarikh cukai jalan',
                'no_resit' => 'no resit rasmi',
                'dispose_dt' => 'tarikh lupus',
                'harga_perolehan' => 'harga perolehan',
                'tarikh_pembelian_kenderaan' => 'tarikh pembelian kenderaan',
                'tarikh_pemeriksaan_keselamatan' => 'tarikh pemeriksaan keselamatan',
                'manufacture_year' => 'tahun dibuat',
                'tarikh_kemaskini' => 'tarikh kemaskini',
                'acqDt' => 'tarikh perolehan',
                'status' => 'status',
                'pegawai_bertanggungjawab' => 'pegawai bertanggungjawab',
                'pegawai_kemaskini' => 'pegawai kemaskini',
                'kaedah_pelupusan' => 'kaedah pelupusan',
                'pembeli' => 'pembeli',
                'disaster_ready' => 'siap siaga'
            ];
        }
        foreach ($attributes as $key) {

            array_push($afterMassage, isset($mappingColName[$key]) ?  strtoupper($mappingColName[$key]) : strtoupper($key)); //contoh dynamic/mapping

        }

        return $afterMassage;
    }

    public function registerEvents(): array
    {

        if (ob_get_contents()) {ob_end_clean();}

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

                $event->sheet->mergeCells('A1:AE4');
                $event->sheet->getDelegate()->getStyle('A1:AE4')->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle('A1:AE4')->ApplyFromArray([

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
            AfterSheet::class    => function(AfterSheet $event) use ($styleArray)
            {
                $cellRange = 'A5:AE5'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->ApplyFromArray($styleArray);
            },
        ];
    }

    public function title(): string
    {
    	return 'Senarai Kenderaan';
    }
}
