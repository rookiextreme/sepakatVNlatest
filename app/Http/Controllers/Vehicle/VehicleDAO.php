<?php

namespace App\Http\Controllers\Vehicle;

use App\Exports\VehicleExport;
use App\Http\Controllers\Controller;
use App\Models\Fleet\FleetDepartment;
use App\Models\Fleet\FleetGrant;
use App\Models\Fleet\FleetPublic;
use App\Models\Fleet\VehicleApproval;
use App\Models\Fleet\VehicleVerification;
use App\Models\FleetDisposal;
use App\Models\Identifier\KenderaanStatus;
use App\Models\Kenderaan\Dokumen;
use App\Models\RefBranch;
use App\Models\RefDisposal;
use App\Models\RefOwnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class VehicleObjectStatus{
    public $code;
    public $total;
 }

class VehicleDAO extends Controller
{
    const HAPUS = '00';
    const DRAF = '01';
    const MENUNGGU_SEMAKAN = '02';
    const MENUNGGU_PENGESAHAN = '03';
    const DITOLAK = '04';
    const TIDAK_LENGKAP = '05';
    const SELESAI = '06';

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dispose_list;
    public $vehicles;
    public $owner_type_list;
    public $search;

    public function mount()
    {

        $xmode = request('xmode') ? request('xmode') : 'catelog';
        $status = request('status') ? request('status') : '';
        $fleet_view = Request('fleet_view') ?  Request('fleet_view') : 'department';
        $this->search = request('search') ? request('search') : null;

        $this->dispose_list = RefDisposal::all();
        $this->owner_type_list = RefOwnerType::where('display_for','vehicle_register')->get();

        if($status){
            $hasPaging = true;
            $this->vehicles = $this->getList($status, $hasPaging);
        } else {
            if($fleet_view == 'department'){
                $this->vehicles = $this->getFleetDepartment($xmode);
            } else if($fleet_view == 'public'){
                $this->vehicles = $this->getFleetPublic($xmode);
            } else if($fleet_view == 'disposal'){
                $this->vehicles = $this->getFleetDisposal($xmode);
            }
        }

    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new VehicleExport($request), 'vehicles.xlsx');
    }

    public function totalVehicleByStatus($fleet_view){

        $table = "fleet.fleet_disposal";
        if($fleet_view == 'department'){
            $table = 'fleet.fleet_department';
        } else if($fleet_view == 'public'){
            $table = 'fleet.fleet_public';
        } else if($fleet_view == 'all'){
            $table = 'fleet.fleet_lookup_vehicle_view';
        }

        $queryCreatedBy = "";

        if(Auth::user()->isPublic()){
            $queryCreatedBy = " and a.created_by =".Auth::user()->id;
        }

        $datas = DB::select(DB::raw("select count(*) as total, c.code from ".$table." a
        join identifiers.vapp_status c ON c.id = a.vapp_status_id
        where c.code in ('01','02','03') ".$queryCreatedBy." group by c.code"));

        Log::info('totalVehicleByStatus');
        Log::info($datas);

        return $datas;
    }

    function insert($data){

        Log::info($data);

        $owner_type_id = $data['owner_type_id'];
        //TODO pic_id once ready lookup for person_incharge
        //$data['pic_id'] = auth()->user()->id;
        $vehicle_id = -1;
        $fleet_view = 'department';
        Log::info('$owner_type_id --> '.$owner_type_id);
        $RefOwnerType = null;
        if($owner_type_id > 0){
            $RefOwnerType = RefOwnerType::find($owner_type_id);
        }

        if($data['mode'] == 'new'){
            $vehicle_status_id = $this->vehicleStatus($this::DRAF);
            $data['vapp_status_id'] = $vehicle_status_id;
        }

        if($data['fleet_view'] == 'grant'){

            $fleet_view = $data['fleet_view'];
            $vehicle_status_id = $this->vehicleStatus($this::SELESAI);
            $data['vapp_status_id'] = $vehicle_status_id;

            $fleetData = FleetGrant::create($data);
            $vehicle_id = $fleetData->id;
        } else {

            switch ($RefOwnerType->code) {
                case '01':
                    $fleetData = FleetDepartment::create($data);
                    $vehicle_id = $fleetData->id;
                    break;
                case '02':
                    $fleetData = FleetDepartment::create($data);
                    $vehicle_id = $fleetData->id;
                    break;
                case '03':
                    $fleetData = FleetPublic::create($data);
                    $vehicle_id = $fleetData->id;
                    $fleet_view = 'public';
                    break;

                break;
            }

        }

        return [
            'pendaftaran_id' =>  $vehicle_id,
            'fleet_view' => $fleet_view
        ];

    }

    function insertToDisposal($data){

        Log::info('insertToDisposal');
        Log::info($data);
        $fleetData = FleetDisposal::create($data);
        $fleet_view = 'disposal';

        return [
            'pendaftaran_id' =>  $fleetData->id,
            'fleet_view' => $fleet_view
        ];

    }

    function update($data, $id){

        $fleet_view = $data['fleet_view'];

        if(isset($data['v_primary_image'])){
            $queryDoc = Dokumen::where('id', $data['v_primary_image'])->first();
            $queryUnsetDoc = Dokumen::where('id', '!=', $data['v_primary_image']);
            switch ($fleet_view) {
                case 'department':
                    $queryUnsetDoc->where([
                        'fleet_department_id' => $queryDoc->fleet_department_id
                    ]);
                    break;
                case 'public':
                    $queryUnsetDoc->where([
                        'fleet_public_id' => $queryDoc->fleet_public_id
                    ]);
                    break;
                case 'disposal':
                    $queryUnsetDoc->where([
                        'fleet_disposal_id' => $queryDoc->fleet_disposal_id
                    ]);
                    break;

            }
            $queryUnsetDoc->update([
                'is_primary' => false
            ]);

            Log::info($queryDoc);
            $queryDoc->update([
                'is_primary' => true
            ]);
        }
        unset($data['v_primary_image']);


        switch ($fleet_view) {
            case 'department':
                Log::info($fleet_view);
                Log::info($data);
                $query = FleetDepartment::find($id);
                $query->update($data);
                break;
            case 'public':
                Log::info($fleet_view);
                Log::info($data);
                $query = FleetPublic::find($id);
                $query->update($data);
                $fleet_view = 'public';
                break;
        }

        return [
            'pendaftaran_id' =>  $id,
            'fleet_view' => $fleet_view
        ];

    }

    public function getList($status, $hasPaging){

        $vehicleList = [];

        Log::info("time start : ".time());
        switch ($status) {
            case 'verification':
                if($hasPaging){
                    $verify = VehicleVerification::orderBy('id');

                    if(Auth::user()->isPublic()){
                        $verify->where('created_by', Auth::user()->id);
                    }

                    $vehicleList = $verify->paginate(5);
                } else {
                    $verify = VehicleVerification::orderBy('id');

                    if(Auth::user()->isPublic()){
                        $verify->where('created_by', Auth::user()->id);
                    }

                    $vehicleList = $verify->get();
                }
                break;
            case 'approval':
                if($hasPaging){
                    $approval = VehicleApproval::orderBy('id');

                    if(Auth::user()->isPublic()){
                        $approval->where('created_by', Auth::user()->id);
                    }

                    $vehicleList = $approval->paginate(5);
                } else {
                    $approval = VehicleApproval::orderBy('id');

                    if(Auth::user()->isPublic()){
                        $approval->where('created_by', Auth::user()->id);
                    }

                    $vehicleList = $approval->get();
                }
                break;
        }

        Log::info("time end : ".time());

        Log::info($vehicleList);

        Log::info(Auth::user()->isPublic());

        return $vehicleList;

    }

    public function getFleetDepartment($xmode){

        $table = 'fleet.fleet_department';
        $RefOwnerType = 'ref_owner_type';
        $summon = 'saman.maklumat_kenderaan_saman';
        $FleetEventHistory = 'fleet.fleet_event_history';

        $vehicleList = DB::table($table)
        ->select(
            $table.'.id AS id',
            $table.'.no_pendaftaran AS plat_number',
            $RefOwnerType.'.desc_bm AS ownership',
            $table.'.no_chasis AS chasis_no',
            $table.'.no_engine AS engine_no',
            $table.'.disaster_ready',
            'fleet.fleet_department.acqDt AS acqDt',
            'kenderaans.maklumats.status AS vehicle_status',
            'kenderaans.dokumens.doc_path_thumbnail AS thumb_url',
            'kenderaans.dokumens.doc_name AS doc_name',
            'kenderaans.dokumens.is_primary AS img_is_primary',
            'identifiers.vapp_status.name AS status',
            'identifiers.vapp_status.code AS vehicle_status_code',
            'ref_category.name AS category_name',
            'fleet.fleet_placement.desc AS placement_name',
            'vehicles.brands.name AS brand_name',
            'vehicles.vehicle_models.name AS model_name',
            'ref_vehicle_status.desc AS vehicle_status',
            'ref_owner_type.desc_bm AS ref_owner_type',
            DB::raw('(SELECT COUNT(*) FROM '.$summon.' WHERE '.$summon.'.pendaftaran_id = '.$table.'.id) as total_summon'),
            DB::raw('(SELECT COUNT(*) FROM '.$FleetEventHistory.' WHERE '.$FleetEventHistory.'.vehicle_id = '.$table.'.id) as total_fleet_event_history')
        )
        ->leftJoin('kenderaans.maklumats', 'kenderaans.maklumats.pendaftaran_id', '=', 'fleet.fleet_department.id')
        ->leftJoin('kenderaans.maklumat_tambahans', 'kenderaans.maklumat_tambahans.pendaftaran_id', '=', 'fleet.fleet_department.id')
        ->leftJoin('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'fleet.fleet_department.id')
        ->leftJoin('kenderaans.dokumens', function($join){
            $join->on('kenderaans.dokumens.fleet_department_id', '=', 'fleet.fleet_department.id')
            ->where('kenderaans.dokumens.is_primary', '=', true);
        })
        ->leftJoin('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'fleet.fleet_department.vapp_status_id')
        ->leftJoin('ref_category', 'ref_category.id', '=', 'fleet.fleet_department.category_id')
        ->leftJoin('fleet.fleet_placement', 'fleet.fleet_placement.id', '=', 'fleet.fleet_department.placement_id')
        // ->leftJoin('locations.placement', 'locations.placement.id', '=', 'fleet.fleet_department.placement_id')
        ->leftJoin('vehicles.brands', 'vehicles.brands.id', '=' , 'fleet.fleet_department.brand_id')
        ->leftJoin('vehicles.vehicle_models', 'vehicles.vehicle_models.id', '=' , 'fleet.fleet_department.model_id')
        ->leftJoin($RefOwnerType, $RefOwnerType.'.id', '=' , 'fleet.fleet_department.owner_type_id')
        ->leftJoin('ref_vehicle_status', 'ref_vehicle_status.id', '=', 'fleet.fleet_department.vehicle_status_id');

        if ( Auth::user()->roleAccess()->code == '04') {
            $vehicleList->where($table.'.created_by', Auth::user()->id);
        };

        $vehicleList->where('identifiers.vapp_status.code', '!=', '00');

        $vehicleList->orderBy($table.'.created_at', 'desc');

        Log::info($this->search);

        if($this->search){
            $vehicleList->whereRaw("upper(no_pendaftaran) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(fleet.fleet_department.no_chasis) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(vehicles.brands.name) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(vehicles.vehicle_models.name) LIKE '%".$this->search."%'");
        }

        if($xmode == 'list'){
            //Log::info($vehicleList->toSql());
            return $vehicleList->get();
        } else if($xmode == 'catelog'){
            //Log::info($vehicleList->toSql());
            return $vehicleList->paginate(5);
        }
    }

    public function getFleetPublic($xmode){
        Log::info('xmode = '. $xmode);
        $table = 'fleet.fleet_public';
        $RefOwnerType = 'ref_owner_type';
        $summon = 'saman.maklumat_kenderaan_saman';
        $FleetEventHistory = 'fleet.fleet_event_history';
        $FleetProject = 'fleet.fleet_project';

        $vehicleList = DB::table($table)
        ->select(
            $table.'.id AS id',
            $table.'.no_pendaftaran AS plat_number',
            $RefOwnerType.'.desc_bm AS ownership',
            $table.'.category_id AS category_id',
            $table.'.placement_id AS placement_id',
            $table.'.tarikh_pembelian_kenderaan AS purchase_dt',
            $table.'.no_chasis AS chasis_no',
            $table.'.no_engine AS engine_no',
            'fleet.fleet_public.acqDt AS acqDt',
            'kenderaans.maklumats.status AS vehicle_status',
            'kenderaans.dokumens.doc_path_thumbnail AS thumb_url',
            'kenderaans.dokumens.doc_name AS doc_name',
            'kenderaans.dokumens.is_primary AS img_is_primary',
            'identifiers.vapp_status.name AS status',
            'identifiers.vapp_status.code AS vehicle_status_code',
            'ref_category.name AS category_name',
            'fleet.fleet_placement.desc AS placement_name',
            $FleetProject.'.project_name',
            $FleetProject.'.hopt',
            'vehicles.brands.name AS brand_name',
            'vehicles.vehicle_models.name AS model_name',
            'ref_vehicle_status.desc AS vehicle_status',
            DB::raw('(SELECT COUNT(*) FROM '.$summon.' WHERE '.$summon.'.pendaftaran_id = '.$table.'.id) as total_summon'),
            DB::raw('(SELECT COUNT(*) FROM '.$FleetEventHistory.' WHERE '.$FleetEventHistory.'.vehicle_id = '.$table.'.id) as total_fleet_event_history')
        )
        ->leftJoin('kenderaans.maklumats', 'kenderaans.maklumats.pendaftaran_id', '=', 'fleet.fleet_public.id')
        ->leftJoin('kenderaans.maklumat_tambahans', 'kenderaans.maklumat_tambahans.pendaftaran_id', '=', 'fleet.fleet_public.id')
        ->leftJoin('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'fleet.fleet_public.id')
        ->leftJoin('kenderaans.dokumens', function($join){
            $join->on('kenderaans.dokumens.fleet_public_id', '=', 'fleet.fleet_public.id')
            ->where('kenderaans.dokumens.is_primary', '=', true);
        })
        ->leftJoin('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'fleet.fleet_public.vapp_status_id')
        ->leftJoin('ref_category', 'ref_category.id', '=', 'fleet.fleet_public.category_id')
        ->leftJoin('fleet.fleet_placement', 'fleet.fleet_placement.id', '=', 'fleet.fleet_public.placement_id')
        ->leftJoin('fleet.fleet_project', 'fleet.fleet_project.id', '=', 'fleet.fleet_public.project_id')
        ->leftJoin('vehicles.brands', 'vehicles.brands.id', '=' , 'fleet.fleet_public.brand_id')
        ->leftJoin('vehicles.vehicle_models', 'vehicles.vehicle_models.id', '=' , 'fleet.fleet_public.model_id')
        ->leftJoin($RefOwnerType, $RefOwnerType.'.id', '=' , 'fleet.fleet_public.owner_type_id')
        ->leftJoin('ref_vehicle_status', 'ref_vehicle_status.id', '=', 'fleet.fleet_public.vehicle_status_id');

        if ( Auth::user()->roleAccess()->code == '04') {
            $vehicleList->where($table.'.created_by', Auth::user()->id);
        };

        $vehicleList->where('identifiers.vapp_status.code', '!=', '00');
        $vehicleList->orderBy($table.'.created_at', 'desc');

        if($this->search){
            $vehicleList->whereRaw("upper(no_pendaftaran) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(".$table.".no_chasis) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(vehicles.brands.name) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(vehicles.vehicle_models.name) LIKE '%".$this->search."%'");
        }

        if($xmode == 'list'){
            return $vehicleList->get();
            dd($vehicleList);
        } else if($xmode == 'catelog'){
            // dd($vehicleList);
            return $vehicleList->paginate(5);

        }
    }

    public function getFleetDisposal($xmode){

        $table = 'fleet.fleet_disposal';
        $RefOwnerType = 'ref_owner_type';
        $RefDisposalMethod = 'ref_disposal';
        $summon = 'saman.maklumat_kenderaan_saman';
        $FleetEventHistory = 'fleet.fleet_event_history';

        $vehicleList = DB::table($table)
        ->select(
            $table.'.id AS id',
            $table.'.no_pendaftaran AS plat_number',
            $RefOwnerType.'.desc_bm AS ownership',
            $RefDisposalMethod.'.desc AS dispose_method',
            $table.'.tarikh_pembelian_kenderaan AS purchase_dt',
            $table.'.no_chasis AS chasis_no',
            $table.'.no_engine AS engine_no',
            'fleet.fleet_disposal.acqDt AS acqDt',
            'kenderaans.maklumats.status AS vehicle_status',
            'kenderaans.dokumens.doc_path_thumbnail AS thumb_url',
            'kenderaans.dokumens.doc_name AS doc_name',
            'identifiers.vapp_status.name AS status',
            'identifiers.vapp_status.code AS vehicle_status_code',
            'ref_category.name AS category_name',
            'fleet.fleet_placement.desc AS placement_name',
            'vehicles.brands.name AS brand_name',
            'vehicles.vehicle_models.name AS model_name',
            'ref_owner_type.desc_bm AS ref_owner_type',
            DB::raw('(SELECT COUNT(*) FROM '.$summon.' WHERE '.$summon.'.pendaftaran_id = '.$table.'.id) as total_summon'),
            DB::raw('(SELECT COUNT(*) FROM '.$FleetEventHistory.' WHERE '.$FleetEventHistory.'.vehicle_id = '.$table.'.id) as total_fleet_event_history')
        )
        ->leftJoin('kenderaans.maklumats', 'kenderaans.maklumats.pendaftaran_id', '=', 'fleet.fleet_disposal.id')
        ->leftJoin('kenderaans.maklumat_tambahans', 'kenderaans.maklumat_tambahans.pendaftaran_id', '=', 'fleet.fleet_disposal.id')
        ->leftJoin('kenderaans.status_semakans', 'kenderaans.status_semakans.pendaftaran_id', '=', 'fleet.fleet_disposal.id')
        ->leftJoin('kenderaans.dokumens', function($join){
            $join->on('fleet.fleet_disposal.id', '=', 'kenderaans.dokumens.fleet_disposal_id')
            ->on('kenderaans.dokumens.is_primary', '=', DB::raw("true"))
            ->on('kenderaans.dokumens.doc_type', '=', DB::raw("'gambarKenderaan'"));
        })
        ->leftJoin('identifiers.vapp_status', 'identifiers.vapp_status.id', '=', 'fleet.fleet_disposal.vapp_status_id')
        ->leftJoin('ref_category', 'ref_category.id', '=', 'fleet.fleet_disposal.category_id')
        ->leftJoin('fleet.fleet_placement', 'fleet.fleet_placement.id', '=', 'fleet.fleet_disposal.placement_id')
        // ->leftJoin('locations.placement', 'locations.placement.id', '=', 'fleet.fleet_disposal.placement_id')
        ->leftJoin('vehicles.brands', 'vehicles.brands.id', '=' , 'fleet.fleet_disposal.brand_id')
        ->leftJoin($RefOwnerType, $RefOwnerType.'.id', '=' , 'fleet.fleet_disposal.owner_type_id')
        ->leftJoin($RefDisposalMethod, $RefDisposalMethod.'.id', '=' , 'fleet.fleet_disposal.disposal_id')
        ->leftJoin('vehicles.vehicle_models', 'vehicles.vehicle_models.id', '=' , 'fleet.fleet_disposal.model_id');

        if ( Auth::user()->roleAccess()->code == '04') {
            $vehicleList->where($table.'.created_by', Auth::user()->id);
        };

        $vehicleList->where('identifiers.vapp_status.code', '!=', '00');

        $vehicleList->orderBy($table.'.created_at', 'desc');

        if($this->search){
            $vehicleList->whereRaw("upper(no_pendaftaran) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(".$table.".no_chasis) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(vehicles.brands.name) LIKE '%".$this->search."%'")
            ->orWhereRaw("upper(vehicles.vehicle_models.name) LIKE '%".$this->search."%'");
        }

        if($xmode == 'list'){
            Log::info($vehicleList->toSql());
            return $vehicleList->get();
        } else if($xmode == 'catelog'){
            return $vehicleList->paginate(5);
        }
    }

    public function vehicleStatus($const)
    {
        $status = KenderaanStatus::where('code',$const)->first();

        return $status->id;
    }

    public function getTotalVehicle($status,$searchString, $fleetGroup, $offset, $limit, $xid, $ownerType, Request $request){

        Log::info('status -> '.$status);

        $ownerId = $request->owner_id ? $request->owner_id : null;

        if(Auth::user()->detail->branch_id){
            $ownerId = Auth::user()->detail->branch_id;
        }

        $queryCreatedBy = "";
        $queryOwnerTypeBy = "";
        $queryOwner = "";
        $queryState = "";
        $queryVType = "";

        if(Auth::user()->isPublic()){
            $queryCreatedBy = " and fd.created_by =".Auth::user()->id;
        }

        if($ownerType){
            $queryOwnerTypeBy = "and fd.owner_type_id =".$ownerType->id;
        }

        if($ownerId){
            $queryOwner = "and fd.cawangan_id =".$ownerId;
        }

        if($request->state_id){
            $queryState = "and fd.state_id =".$request->state_id;
        }

        if($request->type_id){
            $queryVType = "and fd.sub_category_type_id =".$request->type_id;
        }

        $currentYear = date('Y');

        $ownerTypeCondition = '';
        //TODO filter by owner_type
        // if($owner_type_id > 0){
        //     $ownerTypeCondition = " AND fd.owner_type_id ".$owner_type_id;
        // }

        $orderBy = '';
        $paginate = '';

        if($request->mode == 'report' || $request->mode == 'query'){
            $paginate = '';
        }
         else {
            $paginate = 'OFFSET '.$offset.'LIMIT '.$limit.'';
        }

        if(in_array($status, ['draf','verification', 'approval'])){
            $selectCol = 'SELECT fd.id, fd.vapp_status_id, rvs.code AS vehicle_status_code, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name, fpo.project_name, fpo.hopt, fd.no_engine as no_engine, fd.no_chasis as no_chasis';
            $joinProject = 'LEFT JOIN fleet.fleet_project fpo ON fpo.id = fd.project_id';
        }
        elseif($fleetGroup == 'public'){
            $selectCol = 'SELECT fd.id, fd.vapp_status_id, rvs.code AS vehicle_status_code, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name, fpo.project_name, fpo.hopt, fd.no_engine as no_engine, fd.no_chasis as no_chasis';
            $joinProject = 'LEFT JOIN fleet.fleet_project fpo ON fpo.id = fd.project_id';
        }
        elseif($fleetGroup == 'disposal'){
            $selectCol = 'SELECT fd.id, fd.vapp_status_id, rvs.code AS vehicle_status_code, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name, rds.desc as disposal_name, fd.recipient as recipient, fd.dispose_dt as dispose_dt, fd.no_engine as no_engine, fd.no_chasis as no_chasis';
            $joinProject = 'LEFT JOIN public.ref_disposal rds ON rds.id = fd.disposal_id';
            $orderBy = 'order by fd.dispose_dt';
        }
        elseif($fleetGroup == 'grant'){
            $selectCol = 'SELECT fd.id, fd.vapp_status_id, rvs.code AS vehicle_status_code, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name, fd.no_engine as no_engine, fd.no_chasis as no_chasis';
            $joinProject = '';
        }
        else{
            $selectCol = 'SELECT fd.id, fd.vapp_status_id, rvs.code AS vehicle_status_code, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name, fd.no_engine as no_engine, fd.no_chasis as no_chasis, rs.desc as negeri, fd.no_id_pemunya, rc.name as kategori, rsc.name as sub_kategori, rsct.name as jenis,
            vm.name as pembuat, vm.name as model, fd.no_jkr as no_jkr, fd.no_loji as no_loji, no_engine, no_chasis,
            rvs.desc as status, harga_perolehan, ('.$currentYear.'-manufacture_year) AS age, manufacture_year, TO_CHAR("fd"."acqDt", \'dd/mm/yyyy\') as tarikh_perolehan, harga_perolehan, concat(fd.updated_at, \' \', u_by.name) as tarikh_kemaskini';
            $joinProject = '';
        }

        $mapStatus = [
            'draf' => '2',
            'verification' => '3',
            'approval' => '4',
            'approved' => '7'
        ];

        if($searchString == null || $searchString == ''){

            if(in_array($status, ['draf','verification', 'approval'])){

                $sql= '
                 '.$selectCol.', \'department\' as fleet_view, kd.doc_path_thumbnail AS thumb_url, kd.doc_name, fpo.project_name AS project_name, fpo.hopt AS hopt
                FROM fleet.fleet_department fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                LEFT JOIN kenderaans.dokumens kd ON kd.fleet_department_id = fd.id AND kd.is_primary = true
                LEFT JOIN fleet.fleet_project fpo ON fpo.id = fd.project_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'
                UNION '.$selectCol.', \'public\' as fleet_view, kd.doc_path_thumbnail AS thumb_url, kd.doc_name, fpo.project_name AS project_name, fpo.hopt AS hopt
                FROM fleet.fleet_public fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                LEFT JOIN kenderaans.dokumens kd ON kd.fleet_public_id = fd.id AND kd.is_primary = true
                LEFT JOIN fleet.fleet_project fpo ON fpo.id = fd.project_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'
                '.$orderBy.'
                '.$paginate.'
                ' ;

                if($request->mode == 'query'){

                } else {
                    $query = DB::select($sql);
                }

            } else {

                $sql= '
                '.$selectCol.',kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_sub_category rsc ON rsc.id=fd.sub_category_id
                LEFT JOIN public.ref_sub_category_type rsct ON rsct.id=fd.sub_category_type_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                LEFT JOIN ref_state rs ON rs.id=fp.ref_state_id
                LEFT JOIN users.users u_by ON u_by.id = fd.updated_by
                LEFT JOIN kenderaans.dokumens kd ON kd.fleet_'.$fleetGroup.'_id = fd.id AND kd.is_primary = true
                '.$joinProject.'
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'
                '.$orderBy.'
                '.$paginate.'
                ' ;

                if($request->mode == 'query'){

                } else {
                    $query = DB::select($sql);
                }

            }
            // dd($query);
        }else{


            $searchString = strtoupper('%'.$searchString.'%');
            $searchStringTrim = trim($searchString, " ");

            if($xid == 0){

                if(in_array($status, ['draf','verification', 'approval'])){

                    $sql = 
                    $selectCol.', \'department\' as fleet_view, kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                    FROM fleet.fleet_department fd
                    LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                    LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                    LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                    LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                    LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                    JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                    LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                    LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                    LEFT JOIN kenderaans.dokumens kd ON kd.fleet_department_id = fd.id AND kd.is_primary = true
                    '.$joinProject.'
                    WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                    AND (
                        UPPER(no_pendaftaran) LIKE %'.$searchString.'% OR
                        UPPER(no_jkr) LIKE %'.$searchString.'% OR
                        UPPER(fp.desc) LIKE %'.$searchString.'% OR
                        UPPER(rot.desc_bm) LIKE %'.$searchString.'% OR
                        UPPER(rc.name) LIKE %'.$searchString.'% OR
                        UPPER(rs.desc) LIKE %'.$searchString.'% OR
                        UPPER(rb.desc) LIKE %'.$searchString.'%
                        )
                        '.$queryCreatedBy.'
                        '.$queryOwner.'
                        '.$queryState.'
                        '.$queryVType.'
                        UNION ' .$selectCol.', \'public\' as fleet_view, kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                    FROM fleet.fleet_public fd
                    LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                    LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                    LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                    LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                    LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                    JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                    LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                    LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                    LEFT JOIN kenderaans.dokumens kd ON kd.fleet_public_id = fd.id AND kd.is_primary = true
                    '.$joinProject.'
                    WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                    AND (
                        UPPER(no_pendaftaran) LIKE (?) OR
                        UPPER(no_jkr) LIKE (?) OR
                        UPPER(fp.desc) LIKE (?) OR
                        UPPER(rot.desc_bm) LIKE (?) OR
                        UPPER(rc.name) LIKE (?) OR
                        UPPER(rs.desc) LIKE (?) OR
                        UPPER(rb.desc) LIKE (?)
                        )
                        '.$queryCreatedBy.'
                        '.$queryOwner.'
                        '.$queryState.'
                        '.$queryVType.'
                        '.$orderBy.'
                        '.$paginate.'';

                        if($request->mode == 'query'){

                        } else {
                            $query = DB::select($sql);
                        }

                } else {
                    $sql = $selectCol.",kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                        FROM fleet.fleet_".$fleetGroup." fd
                        LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                        LEFT JOIN public.ref_sub_category rsc ON rsc.id=fd.sub_category_id
                        LEFT JOIN public.ref_sub_category_type rsct ON rsct.id=fd.sub_category_type_id
                        LEFT JOIN users.users u_by ON u_by.id = fd.updated_by
                        LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                        LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                        LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                        LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                        JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                        LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                        LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                        LEFT JOIN kenderaans.dokumens kd ON kd.fleet_".$fleetGroup."_id = fd.id AND kd.is_primary = true
                        ".$joinProject."
                        WHERE fd.vapp_status_id IN (".$mapStatus[$status].") AND fd.vehicle_status_id IN (1,2,3,4)
                        AND (
                            UPPER(no_pendaftaran) LIKE '".$searchString."' OR
                            UPPER(no_jkr) LIKE '".$searchString."' OR
                            UPPER(fp.desc) LIKE '".$searchString."' OR
                            UPPER(rot.desc_bm) LIKE '".$searchString."' OR
                            UPPER(rc.name) LIKE '".$searchString."' OR
                            UPPER(rs.desc) LIKE '".$searchString."' OR
                            UPPER(rb.desc) LIKE '".$searchString."'
                            )
                            ".$queryCreatedBy."
                            ".$queryOwner."
                            ".$queryState."
                            ".$queryVType."
                            ".$orderBy."
                            ".$paginate."

                        ";
                        if($request->mode == 'query'){
                            Log::info($sql);
                        } else {
                            $query = DB::select(DB::raw($sql));
                        }
                }

            }else{

                $searchStringCondition = '';

                switch ($xid) {
                    case 1:
                        $searchStringCondition = 'UPPER(no_pendaftaran) LIKE (%'.$searchString.'%)';

                        break;

                    case 2:
                        $searchStringCondition = 'UPPER(no_jkr) LIKE (%'.$searchString.'%)';
                        //no jkr
                        break;

                    case 3:
                        $searchStringCondition = 'UPPER(fp.desc) LIKE (%'.$searchString.'%)';
                        // lokasi
                        break;

                    case 4:
                        $searchStringCondition = 'UPPER(rot.desc_bm) LIKE (%'.$searchString.'%)';
                        //milik
                        break;

                    case 5:
                        $searchStringCondition = 'UPPER(rc.name) LIKE (%'.$searchString.'%)';
                        //jenis
                        break;
                    case 6:
                        $searchStringCondition = 'UPPER(rs.desc) LIKE (%'.$searchString.'%)';
                        //negeri
                        break;
                    case 7:
                        $searchStringCondition = 'UPPER(rb.desc) LIKE (%'.$searchString.'%)';
                        //cawangan
                        break;


                }

                //$searchString = strtoupper('%'.$searchString.'%');

                if(in_array($status, ['draf','verification', 'approval'])){

                    $sql = '
                    SELECT \'department\' as fleet_view, fd.id, rvs.code AS vehicle_status_code, no_pendaftaran,disaster_ready,  ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, fpo.project_name, fpo.hopt, b.name AS brand_name, vm.name AS model_name, fd.no_engine, fd.no_chasis,kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                    FROM fleet.fleet_department fd
                    LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                    LEFT JOIN public.ref_sub_category rsc ON rsc.id=fd.sub_category_id
                    LEFT JOIN public.ref_sub_category_type rsct ON rsct.id=fd.sub_category_type_id
                    LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                    LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                    LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                    LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                    JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                    LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                    LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                    LEFT JOIN kenderaans.dokumens kd ON kd.fleet_department_id = fd.id AND kd.is_primary = true
                    '.$joinProject.'
                    WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4) '.$queryCreatedBy.'
                    AND ('.$searchStringCondition.')
                    '.$queryOwner.'
                    '.$queryState.'
                    '.$queryVType.'

                     UNION

                     SELECT \'public\' as fleet_view, fd.id, rvs.code AS vehicle_status_code, no_pendaftaran,disaster_ready,  ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, fpo.project_name, fpo.hopt, b.name AS brand_name, vm.name AS model_name, fd.no_engine, fd.no_chasis,kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                    FROM fleet.fleet_public fd
                    LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                    LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                    LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                    LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                    LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                    JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                    LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                    LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                    LEFT JOIN kenderaans.dokumens kd ON kd.fleet_public_id = fd.id AND kd.is_primary = true
                    '.$joinProject.'
                    WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4) '.$queryCreatedBy.'
                    AND ('.$searchStringCondition.')
                    '.$queryOwner.'
                    '.$queryState.'
                    '.$queryVType.'

                    '.$orderBy.'
                    '.$paginate.'
                    ';
                    $query = DB::select($sql);

                } else {

                    $sql = DB::raw('
                    '.$selectCol.',kd.doc_path_thumbnail AS thumb_url, kd.doc_name
                    FROM fleet.fleet_'.$fleetGroup.' fd
                    LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                    LEFT JOIN public.ref_sub_category rsc ON rsc.id=fd.sub_category_id
                    LEFT JOIN public.ref_sub_category_type rsct ON rsct.id=fd.sub_category_type_id
                    LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                    LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                    LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                    LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                    JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                    LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                    LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                    LEFT JOIN kenderaans.dokumens kd ON kd.fleet_'.$fleetGroup.'_id = fd.id AND kd.is_primary = true
                    '.$joinProject.'
                    WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4) '.$queryCreatedBy.'
                    AND ('.$searchStringCondition.')
                    '.$queryOwner.'
                    '.$queryState.'
                    '.$queryVType.'
                    '.$orderBy.'
                    '.$paginate.'

                    ');

                    $query = DB::select($sql);

                }


            }





        }


        if($request->mode == 'query'){
            // Log::info('haas => '.$sql);
            // $sql = str_replace( array('"'), "'", $sql);
            return $sql;
        } else {
            return $query;
        }


    }

    public function getTotalVehicleDistrict($status,$searchString, $fleetGroup, $offset, $limit, $xid, $opt){

        Log::info('status -> '.$status);

        $currentYear = date('Y');

        $queryCreatedBy = "";

        if(Auth::user()->isPublic()){
            $queryCreatedBy = " and fd.created_by =".Auth::user()->id;
        }

        $mapStatus = [
            'draf' => '2',
            'verification' => '3',
            'approval' => '4',
            'approved' => '7'
        ];

        if($searchString == null || $searchString == ''){

            if($opt == 00){
                $sql= '
                SELECT fd.id, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3) '.$queryCreatedBy.'
                OFFSET ?
                LIMIT ?
                ' ;
            }else{
                $sql= '
                SELECT fd.id, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3) AND fd.placement_id = '.$opt.' '.$queryCreatedBy.'
                OFFSET ?
                LIMIT ?
                ' ;
            }

            Log::info($sql);

            $query = DB::select(DB::raw($sql),[$offset, $limit]);


        }else{


            $searchString = strtoupper('%'.$searchString.'%');


            if($xid == 0){

                $query = DB::select(DB::raw('
                SELECT fd.id, rvs.code AS vehicle_status_code, no_pendaftaran,disaster_ready,  ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3) '.$queryCreatedBy.'
                AND (
                    UPPER(no_pendaftaran) LIKE (?) OR
                    UPPER(no_jkr) LIKE (?) OR
                    UPPER(fp.desc) LIKE (?) OR
                    UPPER(rs.desc) LIKE (?) OR
                    UPPER(rb.desc) LIKE (?)
                )
                OFFSET ?
                LIMIT ?

                '),[$searchString, $searchString, $searchString,  $searchString, $searchString, $offset, $limit]);

            }else{

                $searchStringCondition = '';

                switch ($xid) {
                    case 1:
                        $searchStringCondition = 'UPPER(no_pendaftaran) LIKE (?)';

                        break;

                    case 2:
                        $searchStringCondition = 'UPPER(no_jkr) LIKE (?)';
                        //no jkr
                        break;

                    case 3:
                        $searchStringCondition = 'UPPER(fp.desc) LIKE (?)';
                        // lokasi
                        break;

                    case 4:
                        $searchStringCondition = 'UPPER(rs.desc) LIKE (?)';
                        //negeri
                        break;

                    case 5:
                        $searchStringCondition = 'UPPER(rb.desc) LIKE (?)';
                        //cawangan
                        break;


                }

                //$searchString = strtoupper('%'.$searchString.'%');

                $query = DB::select(DB::raw('
                SELECT fd.id, rvs.code AS vehicle_status_code, no_pendaftaran,disaster_ready,  ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4) '.$queryCreatedBy.'
                AND ('.$searchStringCondition.')
                OFFSET ?
                LIMIT ?

                '),[$searchString, $offset, $limit]);


            }





        }

        Log::info($query);
        return $query;


    }

    public function getTotalVehicleNoOffset($status, $searchString, $fleetGroup, $xid, $ownerType, Request $request){

        $ownerId = $request->owner_id ? $request->owner_id : null;
        $sql = "";

        if(Auth::user()->detail->branch_id){
            $ownerId = Auth::user()->detail->branch_id;
        }

        $currentYear = date('Y');

        $queryCreatedBy = "";
        $queryOwnerTypeBy = "";
        $queryOwner = "";
        $queryState = "";
        $queryVType = "";

        if(Auth::user()->isPublic()){
            $queryCreatedBy = " and fd.created_by =".Auth::user()->id;
        }

        if($ownerType){
            $queryOwnerTypeBy = "and fd.owner_type_id =".$ownerType->id;
        }

        if($ownerId){
            $queryOwner = "and fd.cawangan_id =".$ownerId;
        }

        if($request->state_id){
            $queryState = "and fd.state_id =".$request->state_id;
        }

        if($request->type_id){
            $queryVType = "and fd.sub_category_type_id =".$request->type_id;
        }

        Log::info('fleetGroup --> '.$fleetGroup);

        $mapStatus = [
            'draf' => '2',
            'verification' => '3',
            'approval' => '4',
            'approved' => '7'
        ];

        if($searchString == null || $searchString == ''){

            if(in_array($status, ['draf','verification', 'approval'])){

                $query = DB::select(DB::raw('
                SELECT fd.id, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_department fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'

                UNION

                SELECT fd.id, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_public fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'


                '));

            } else {
                $query = DB::select(DB::raw('
                SELECT fd.id, disaster_ready, no_pendaftaran, ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'

                '));
            }


        }else{

            $searchString = strtoupper('%'.$searchString.'%');

            if($xid == 0){

                Log::info('by carian -> '.$xid);

                $query = DB::select(DB::raw('
                SELECT fd.id, rvs.code AS vehicle_status_code, no_pendaftaran,disaster_ready,  ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                AND (
                    UPPER(no_pendaftaran) LIKE (?) OR
                    UPPER(no_jkr) LIKE (?) OR
                    UPPER(fp.desc) LIKE (?) OR
                    UPPER(rot.desc_bm) LIKE (?) OR
                    UPPER(rc.name) LIKE (?) OR
                    UPPER(rs.desc) LIKE (?) OR
                    UPPER(rb.desc) LIKE (?)
                    )
                    '.$queryCreatedBy.'
                    '.$queryOwnerTypeBy.'
                    '.$queryOwner.'
                    '.$queryState.'
                    '.$queryVType.'

                '),[$searchString, $searchString, $searchString,  $searchString, $searchString, $searchString, $searchString]);

                Log::info($query);

            }else{


                $searchStringCondition = '';

                switch ($xid) {
                    case 1:
                        $searchStringCondition = 'UPPER(no_pendaftaran) LIKE (?)';

                        break;

                    case 2:
                        $searchStringCondition = 'UPPER(no_jkr) LIKE (?)';
                        //no jkr
                        break;

                    case 3:
                        $searchStringCondition = 'UPPER(fp.desc) LIKE (?)';
                        // lokasi
                        break;

                    case 4:
                        $searchStringCondition = 'UPPER(rot.desc_bm) LIKE (?)';
                        //milik
                        break;

                    case 5:
                        $searchStringCondition = 'UPPER(rc.name) LIKE (?)';
                        //jenis
                        break;
                    case 6:
                        $searchStringCondition = 'UPPER(rs.desc) LIKE (?)';
                        //negeri
                        break;
                    case 7:
                        $searchStringCondition = 'UPPER(rb.desc) LIKE (?)';
                        //cawangan
                        break;


                }

                //$searchString = strtoupper('%'.$searchString.'%');

                Log::info('siisss');

                $query = DB::select(DB::raw('
                SELECT fd.id, rvs.code AS vehicle_status_code, no_pendaftaran,disaster_ready,  ('.$currentYear.'-manufacture_year) AS age, rc.name AS category_name, rot.code AS ownership_code, rot.desc_bm AS ownership , rb.desc AS branch_name, fp.desc AS placement_name, b.name AS brand_name, vm.name AS model_name
                FROM fleet.fleet_'.$fleetGroup.' fd
                LEFT JOIN public.ref_category rc ON rc.id=fd.category_id
                LEFT JOIN public.ref_owner_type rot ON rot.id=fd.owner_type_id
                LEFT JOIN public.ref_branch rb ON rb.id=fd.cawangan_id
                LEFT JOIN fleet.fleet_placement fp ON fp.id=fd.placement_id
                LEFT JOIN public.ref_state rs ON rs.id=fp.ref_state_id
                JOIN public.ref_vehicle_status rvs ON rvs.id = fd.vehicle_status_id
                LEFT JOIN vehicles.brands b ON b.id=fd.brand_id
                LEFT JOIN vehicles.vehicle_models vm ON vm.id=fd.model_id
                WHERE fd.vapp_status_id IN ('.$mapStatus[$status].') AND fd.vehicle_status_id IN (1,2,3,4)
                '.$queryCreatedBy.'
                '.$queryOwnerTypeBy.'
                '.$queryOwner.'
                '.$queryState.'
                '.$queryVType.'
                AND ('.$searchStringCondition.')

                '),[$searchString]);



            }




        }

        return $query;

    }


    public function totalFleet($fleetGroup){


        $query = DB::select(DB::raw('
            SELECT count(fd.id) AS total_fleet
            FROM fleet.fleet_'.$fleetGroup.' fd
            WHERE fd.vapp_status_id=7

            '));


            return $query;

    }

    public function externalCount($plateNumber, $fleetId){

        Log::info('$fleetId => '.$fleetId);

        $query = DB::select(DB::raw('
            SELECT
            (SELECT coalesce(count(id),0) FROM fleet.fleet_department WHERE id = ? AND vapp_status_id = 7) AS total_department,
            (
                SELECT coalesce(count(a.id),0) FROM saman.maklumat_kenderaan_saman a
                JOIN saman.status_saman b ON b.id = a.status_saman_id
                WHERE a.pendaftaran_id = ? AND b.code IN (\'02\')) AS total_summons



            '),[$fleetId, $fleetId]);


            return $query;



    }


}
