<?php

namespace App\Http\Controllers\Logistic\DisasterReady;

use App\Http\Controllers\Controller;
use App\Mail\module\logistic\SendEmailToUserWhenBookingStatusReject;
use App\Mail\module\logistic\SendEmailToVOfficerWhenBookingDisasterReadyStatusApproval;
use App\Models\DisasterReady\DisasterReadyBooking;
use App\Models\DisasterReady\DisasterReadyBookingTaskScan;
use App\Models\DisasterReady\DisasterReadyDocument;
use App\Models\DisasterReadyBookingStatus;
use App\Models\Fleet\FleetDepartment;
use App\Models\Logistic\LogisticDisasterReadyVehicle;
use App\Models\Logistic\LogisticDocument;
use App\Models\LogisticStayStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class DisasterReadyDAO extends Controller
{
    public $current_id = -1;
    public $detail;
    public $is_display = 0;
    public $booking_list;
    public $mode = 0777;
    public $totalProcess = 0;
    public $totalVerification = 0;
    public $totalDraft = 0;
    public $totalApproval = 0;
    public $totalCompleted = 0;
    public $stay_status_list;

    public function mount(Request $request){

        $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('04', '02');
        $status_code = $request->status_code ? $request->status_code : 'all_inprogress';

        $query = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->whereNotIn('code', ['00']);
        })->orderBy('updated_at', 'desc');

        Log::info('Auth::user()->id '.Auth::user()->id);

        $this->totalDraft = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['01']);
        })->where('created_by', Auth::user()->id);
        $this->totalVerification = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['02']);
        });
        $this->totalApproval = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['03']);
        });

        $this->totalCompleted = DisasterReadyBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['06']);
        });

        if($status_code == 'all_inprogress'){

            if(Auth::user()->isAdmin() || $TaskFlowAccessVehicle->mod_fleet_verify || $TaskFlowAccessVehicle->mod_fleet_approval){

                $query->whereHas('hasBookingStatus', function($q){
                    $q->whereNotIn('code', ['00', '01', '04', '06']);
                });

                $this->filterByVehicle($query, $request);
                $this->searching($query, $request);
                
                $query->orWhereHas('hasBookingStatus', function($q) use($request){
                    $q->where('code', '01');
                })->where('created_by', Auth::user()->id);

                
                $this->filterByVehicle($this->totalDraft, $request);
                $this->totalDraft->orWhereHas('hasBookingStatus', function($q) use($request){
                    $q->where('code', '01');
                })->where('created_by', Auth::user()->id);

                $this->filterByVehicle($this->totalVerification, $request);
                $this->filterByVehicle($this->totalApproval, $request);
                $this->filterByVehicle($this->totalCompleted, $request);
    
            } else {
                $query->where('created_by', Auth::user()->id);
                $this->totalVerification->where('created_by', Auth::user()->id);
                $this->totalApproval->where('created_by', Auth::user()->id);
                $this->totalCompleted->where('created_by', Auth::user()->id);
            }

        }

        else if($status_code == '01'){

            $query->whereHas('hasBookingStatus', function($q) use($request){
                $q->where('code', '01');
            })->where('created_by', Auth::user()->id);

            if(Auth::user()->isAdmin() || $TaskFlowAccessVehicle->mod_fleet_verify || $TaskFlowAccessVehicle->mod_fleet_approval){

                $this->filterByVehicle($query, $request);
                $this->searching($query, $request);
                
                $query->orWhereHas('hasBookingStatus', function($q) use($request){
                    $q->where('code', '01');
                })->where('created_by', Auth::user()->id);

                $this->filterByVehicle($this->totalVerification, $request);
                $this->filterByVehicle($this->totalApproval, $request);
                $this->filterByVehicle($this->totalCompleted, $request);
    
            } else {
                $query->where('created_by', Auth::user()->id);
                $this->totalVerification->where('created_by', Auth::user()->id);
                $this->totalApproval->where('created_by', Auth::user()->id);
                $this->totalCompleted->where('created_by', Auth::user()->id);
            }
            
        }
        else if(in_array($status_code, ['02','03','06'])){

            $query->whereHas('hasBookingStatus', function($q) use($status_code){
                $q->where('code', $status_code);
            });

            if(Auth::user()->isAdmin() || $TaskFlowAccessVehicle->mod_fleet_verify || $TaskFlowAccessVehicle->mod_fleet_approval){

                $this->filterByVehicle($query, $request);
                $this->searching($query, $request);

                $this->filterByVehicle($this->totalVerification, $request);
                $this->filterByVehicle($this->totalApproval, $request);
                $this->filterByVehicle($this->totalCompleted, $request);
    
            } else {
                $query->where('created_by', Auth::user()->id);
                $this->totalVerification->where('created_by', Auth::user()->id);
                $this->totalApproval->where('created_by', Auth::user()->id);
                $this->totalCompleted->where('created_by', Auth::user()->id);
            }
            
        }

        $this->searching($query, $request);

        $this->totalDraft = $this->totalDraft->count();
        $this->totalVerification = $this->totalVerification->count();
        $this->totalApproval = $this->totalApproval->count();
        $this->totalCompleted = $this->totalCompleted->count();

        $this->totalProcess = $this->totalDraft + $this->totalVerification + $this->totalApproval;
        
        Log::info($query->toSql());
        $this->booking_list = $query->paginate(5);
    }

    public function filterByVehicle($query, Request $request){
        return $query->whereHas('hasManyVehicle', function($q){
            if(Auth::user()->isAdmin()){

            } else if(Auth::user()->detail->hasWorkshop){
                $q->whereHas('hasPlacement', function($q2){
                    $q2->wherehas('hasState', function($q3){
                        $q3->where('id', Auth::user()->detail->hasWorkshop->hasState->id);
                    });
                });
            }
        });
    }

    private function searching($query, Request $request){
        if($request->search){
            $filter_date = $request->search;
            return $query->whereDate('created_at', '=', Carbon::parse($filter_date)->toDateString());
        } else {
            return $query;
        }
    }

    public function generateQRCode(Request $request){

        $qrImgUrl = "";
        $checkExistBooking = DisasterReadyBooking::find($request->booking_id);

        if($checkExistBooking && $checkExistBooking->hasBookingStatus->code == '06'){
            $finggerPrintId = request()->fingerprint();
            $url = route('logistic.driver-task.detail', ['finger_print_id' => $finggerPrintId, 'booking_id' => $request->booking_id, 'category' => 'disaster']);
            $qrImgUrl = 'images/qrcode-disaster-'.$finggerPrintId.'-'.$request->booking_id.'.png';

            $path = public_path().'/images';
            $isExists = File::exists(public_path($path));
            if($isExists){
                QrCode::size(500)
                ->format('png')
                ->generate(route('.redirect', ['redirectTo' => $url]), public_path($qrImgUrl));

                DisasterReadyBookingTaskScan::create([
                    'finger_print_id' => $finggerPrintId,
                    'booking_id' => $request->booking_id,
                    'created_by' => Auth::user()->id
                ]);
            }else{
                File::makeDirectory($path, $this->mode, true, true);
                QrCode::size(500)
                ->format('png')
                ->generate(route('.redirect', ['redirectTo' => $url]), public_path($qrImgUrl));

                DisasterReadyBookingTaskScan::create([
                    'finger_print_id' => $finggerPrintId,
                    'booking_id' => $request->booking_id,
                    'created_by' => Auth::user()->id
                ]);
            }
        }

        return $qrImgUrl;
    }

    private function createDoc($file){
        $docFormat = $file->getClientOriginalExtension();
        $fileName = Str::random(9).'.'.$docFormat;

        if($file != null){

            Log::info($file);
            Log::info($docFormat);

            $path = 'public/dokumen/logistic/booking/';

            $file->storeAs($path, $fileName);

            $data = [
                'doc_path' => 'dokumen/logistic/booking/',
                'doc_type' => 'work_ins_letter',
                'doc_format' => $docFormat,
                'doc_name' => $fileName,
                'created_by' => auth()->user()->id,
            ];

            $LogisticDocument =  DisasterReadyDocument::create($data);
            Log::info("ID. ".$LogisticDocument->id);
            return $LogisticDocument->id;
        }
    }

    public function saveDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'hasNewDocWorkInsLetter' => 'required',
            'booking_person_name' => 'required',
            'agency' => 'required',
            'tel_no' => 'required',
            'booking_person_email' => 'required',
            // 'work_ins_letter' =>  'required_if:hasNewDocWorkInsLetter,1|mimetypes:application/pdf|max:10000',
        ],
        [
            'booking_person_name.required' => 'Sila Isi Nama',
            'agency.required' => 'Sila Pilih Agensi',
            'tel_no.required' => 'Sila Isi Nombor Telefon',
            'booking_person_email.required' => 'Sila Isi Email',
            // 'work_ins_letter.required_if' =>  'Sila Masukkan Surat Arahan Kerja',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $this->current_id = session()->get('disasterready_current_detail_id');

        $data = [
            'booking_person_name' => $request['booking_person_name'],
            'agency_id' => $request['agency'],
            'tel_no' => $request['tel_no'],
            'booking_person_email' => $request['booking_person_email']
        ];

        $data['booking_by'] = auth()->user()->id;

        $DisasterReadyBooking = DisasterReadyBooking::find($this->current_id);

        Log::info($DisasterReadyBooking);

        if($DisasterReadyBooking){
            $DisasterReadyBooking->update($data);
        } else {
            $data['created_by'] = auth()->user()->id;

            $status_id = $this->bookingStatus("01");
            $data['status_id'] = $status_id;
            $inserted = DisasterReadyBooking::create($data);
            $this->current_id = $inserted->id;
        }

        if(!empty($DisasterReadyBooking->hasManyVehicle)){
            $countVehicle = count($DisasterReadyBooking->hasManyVehicle);
        }else{
            $countVehicle = 0;
        }

        return [
            'url' => route('logistic.disasterready.detail', ['id' => $this->current_id, 'tab' => ($countVehicle > 0 ? 2 :1)])
        ];

    }

    public function saveJourney(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hasNewDocWorkInsLetter' => 'in:1,0',
            'disaster_center' => 'required',
            'assembly_location' => 'required',
            'assembly_datetime' => 'required',
            'destination' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required',
            'trip_expense_type' => 'required',
            'work_ins_letter' =>  'required_if:hasNewDocWorkInsLetter,1|mimetypes:application/pdf|max:10000',
        ],
        [
            'disaster_center.required' => 'Sila Isi Pusat Bencana',
            'assembly_location.required' => 'Sila Isi Tempat Berkumpul',
            'assembly_datetime.required' => 'Sila Isi Tarikh Berkumpul',
            'destination.required' => 'Sila Isi Destinasi',
            'start_datetime.required' => 'Sila Isi Tarikh Mula Misi',
            'end_datetime.required' => 'Sila Isi Tarikh Tamat Misi',
            'trip_expense_type.required' => 'Sila Pilih Jenis Perbelanjaan',
            'work_ins_letter.required' =>  'Sila Masukkan Surat Arahan Kerja',
            'work_ins_letter.mimetypes' => 'Sila Masukkan PDF Sahaja',
            'work_ins_letter.max' => 'Sila Masukkan Kurang daripada 10 megabait sahaja',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $this->current_id = session()->get('disasterready_current_detail_id');

        $data = [
            'disaster_center' => $request->disaster_center,
            'assembly_location' => $request->assembly_location,
            'assembly_datetime' => $request->assembly_datetime,
            'destination' => $request->destination,
            'start_datetime' => $request->start_datetime,
            'end_datetime' => $request->end_datetime,
            'trip_expense_type' => $request->trip_expense_type,
        ];

        $DisasterReady = DisasterReadyBooking::find($this->current_id);

        if($DisasterReady){
            $data['work_ins_letter_id'] = $DisasterReady->work_ins_letter_id;
        }

        if($request->work_ins_letter){
            $work_ins_letter_id = $this->createDoc($request->work_ins_letter);
            $data['work_ins_letter_id'] = $work_ins_letter_id;
        }

        $DisasterReady->update($data);

        return [
            'url' => route('logistic.disasterready.register', ['id' => $this->current_id, 'tab' => 2])
        ];

    }

    public function read($id){

        $query = DisasterReadyBooking::find($id);
        session()->put('disasterready_current_detail_id', $id);
        $this->current_id = $id;
        $this->detail = $query;

        $this->applicant = [
            'name' =>  ( $query && $query->hasApplicant ? $query->hasApplicant->name : Auth::user()->name),
            'tel_no' => ( $query &&  $query->hasApplicant ? $query->hasApplicant->tel_no : Auth::user()->detail->telbimbit),
            'email' =>  ( $query && $query->hasApplicant? $query->hasApplicant->email : Auth::user()->email),
            'department' => $query && $query->hasApplicant? $query->hasApplicant->hasDepartment : null
        ];

        $this->stay_status_list = LogisticStayStatus::all();

        if(auth()->user()->isDriver() && $query->hasBookingStatus->code == '07'){
            $this->is_display = 1;
        }
        return $this->detail;
    }

    private function bookingStatus($code){
        $status = DisasterReadyBookingStatus::where('code',$code)->first();

        return $status->id;
    }

    public function submitForApproval(Request $request)
    {
        $result = 0;
        $ids = $request->input('ids');

        $table = DisasterReadyBooking::class;

        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'submitted_by' => Auth::user()->id,
            'submitted_dt' => Carbon::now(),
            'status_id' => $this->bookingStatus('03')
        ]);

        $emailBody = [
            'title' => 'Maklumat Siap Siaga Bencana Kenderaan',
            'subject' => 'Maklumat Siap Siaga Bencana Kenderaan '.Carbon::now()->format('d/m/Y').' yang perlu disahkan',
            'booking_list' => $query->get(),
        ];

        $userEmail = ['farid.developer.1992@gmail.com'];

        // $VOfficer = User::all();

        // foreach ($query->get() as $data) {
        //     array_push($userEmail, $data->bookingBy->email);
        // }


        $userApproval = new User();
        foreach ($query->get() as $data) {
            $userApprovalList = $userApproval->hasManyApprovalByModuleFilterAgency('04','02', $data->hasAgency->id);

            foreach ($userApprovalList as $userApproval) {
                foreach ($userApproval->hasManyRoles as $roles) {
                    array_push($userEmail, $roles->hasUser->email);
                }
            }

            Log::info($userEmail);
            Log::info($emailBody);

            //Mail::to($userEmail)->send(new SendEmailToVOfficerWhenBookingDisasterReadyStatusApproval($emailBody));

        }

        return [
            'url' => route('logistic.disasterready.list')
        ];
    }

    public function reject(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'note' => 'required',
        ],
        [
            'note.required' => 'Sila nyatakan sebab.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $result = 0;
        $ids = $request->input('ids');

        $table = DisasterReadyBooking::class;
        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'status_id' => $this->bookingStatus('04'),
            'note' => $request->note
        ]);

        $emailBody = [
            'title' => 'Maklumat Tempahan Kenderaan',
            'subject' => 'Maklumat Tempahan Kenderaan '.Carbon::now()->format('d/m/Y').' yang ditolak',
            'booking_list' => $query->get(),
        ];

        $userEmail = ['farid.developer.1992@gmail.com'];

        foreach ($query->get() as $data) {
            array_push($userEmail, $data->bookingBy->email);
        }

        Mail::to($userEmail)->send(new SendEmailToUserWhenBookingStatusReject($emailBody));

        return [
            'url' => route('logistic.disasterready.list')
        ];
    }

    public function approve(Request $request)
    {
        $result = 0;
        $ids = $request->input('ids');

        $table = DisasterReadyBooking::class;
        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'approved_by' => Auth::user()->id,
            'approved_dt' => Carbon::now(),
            'status_id' => $this->bookingStatus('06')
        ]);

        return [
            'url' => route('logistic.disasterready.list')
        ];
    }

    public function delete(Request $request){
        $ids = $request->ids;

        $query = DisasterReadyBooking::whereIn('id', $ids);
        $query->update([
            'status_id' => $this->bookingStatus('00')
        ]);

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

    }

    public function vehicleList(Request $request){
        $table = new FleetDepartment();
        $query = $table->setTable('fleet.fleet_department as fd')
        ->select('fd.id AS id', 'fd.no_pendaftaran', 'fd.category_id', 'fd.sub_category_id', 'fd.sub_category_type_id', 'fd.owner_type_id','placement_id',
        'fd.manufacture_year', 'fd.brand_id', 'fd.model_id', 'fd.cawangan_id', 'fd.state_id', 'disaster_ready', 'ro.id as ro_id')
        ->where([
            'disaster_ready' => true,
            'is_maintenance' => false,
            'is_evaluation' => false
        ])
        ->leftJoin('ref_sub_category_type AS rsc', 'rsc.id', 'fd.sub_category_type_id')
        ->leftJoin('ref_state AS rs', 'rs.id', 'fd.state_id')
        ->leftJoin('ref_owner_type AS rot', 'rot.id', 'fd.owner_type_id')
        ->leftJoin('ref_owner AS ro', 'ro.id', 'fd.cawangan_id');

        if(Auth::user()->isAdmin()){

        }
        elseif(Auth::user()->isVehicleOfficer()){

            if(Auth::user()->detail->hasBranch){
                Log::info('DisasterReady => vehicleList => Branch => '.Auth::user()->detail->hasBranch);
                $query->where('fd.cawangan_id', Auth::user()->detail->hasBranch->id);
            } elseif(Auth::user()->detail->hasWorkshop){
                Log::info('DisasterReady => vehicleList => Workshop => fd.state_id => '.Auth::user()->detail->hasWorkshop->state_id);
                $query->where('fd.state_id', Auth::user()->detail->hasWorkshop->state_id);
            } else {
                Log::info('DisasterReady => vehicleList => fd.state_id => '.Auth::user()->detail->state_id);
                $query->where('fd.state_id', Auth::user()->detail->state_id);
            }
        } else {
            Log::info('Bukan Pegawai Kenderaan => DisasterReady => vehicleList => fd.state_id => '.Auth::user()->detail->state_id);
            $query->where('fd.state_id', Auth::user()->detail->state_id);
        }

        if($request->search){
            $request->search = strtoupper($request->search);

            switch ($request->filterOpt) {
                case 'flt-plateno':
                    $query->whereRaw("upper(fd.no_pendaftaran) LIKE '%".$request->search."%'");
                    break;
                case 'flt-negeri':
                    $query->whereRaw("upper(rs.desc) LIKE '%".$request->search."%'");
                    break;
                case 'flt-jenis':
                    $query->whereRaw("upper(rsc.name) LIKE '%".$request->search."%'");
                    break;
                default:
                    $query->whereRaw("(upper(fd.no_pendaftaran) LIKE '%".$request->search."%' OR upper(rs.desc) LIKE '%".$request->search."%' OR upper(rsc.name) LIKE '%".$request->search."%')");
                    break;
            }
        }

        $query
        ->orderByRaw('ro.code=\'0125\' desc')
        ->orderBy('fd.no_pendaftaran', 'asc')
        ->orderBy('rs.id', 'desc')
        ->orderBy('rsc.id', 'desc');

        Log::info($query->toSql());
        
        return $query->paginate($request->limit ?:10);
    }

    public function vehicleReportList(Request $request){

        $list = DB::table('fleet.fleet_department AS a')
        ->select(DB::raw('b.id, 
        b.code,
        CASE 
            WHEN b.code = \'14\' THEN \'JKR WOKSYOP PERSEKUTUAN\' 
            WHEN b.code != \'14\' THEN b.desc     
        END AS state_name'),  DB::raw('count(*) as total'))
        ->join('public.ref_state AS b', 'b.id', 'a.state_id')
        ->leftJoin('ref_sub_category_type AS c', 'c.id', 'a.sub_category_type_id')
        ->leftJoin('ref_owner_type AS d', 'd.id', 'a.owner_type_id')
        ->leftJoin('ref_owner AS e', 'e.id', 'a.cawangan_id')
        ->where('a.disaster_ready', true)
        // ->whereIn('b.code', ['01','02'])
        ->groupBy('b.id')
        ->orderByRaw('b.code=\'14\' desc, b.code');

        if(Auth::user()->isAdmin()){

        }
        elseif(Auth::user()->isVehicleOfficer()){

            if(Auth::user()->detail->hasBranch){
                Log::info('DisasterReady => vehicleList => Branch => '.Auth::user()->detail->hasBranch);
                $list->where('fd.cawangan_id', Auth::user()->detail->hasBranch->id);
            } elseif(Auth::user()->detail->hasWorkshop){
                Log::info('DisasterReady => vehicleList => Workshop => fd.state_id => '.Auth::user()->detail->hasWorkshop->state_id);
                $list->where('fd.state_id', Auth::user()->detail->hasWorkshop->state_id);
            } else {
                Log::info('DisasterReady => vehicleList => fd.state_id => '.Auth::user()->detail->state_id);
                $list->where('fd.state_id', Auth::user()->detail->state_id);
            }
        } else {
            Log::info('Bukan Pegawai Kenderaan => DisasterReady => vehicleList => fd.state_id => '.Auth::user()->detail->state_id);
            $list->where('fd.state_id', Auth::user()->detail->state_id);
        }

        if($request->search){
            $request->search = strtoupper($request->search);

            switch ($request->filterOpt) {
                case 'flt-plateno':
                    $list->whereRaw("upper(a.no_pendaftaran) LIKE '%".$request->search."%'");
                    break;
                case 'flt-negeri':
                    $list->whereRaw("upper(b.desc) LIKE '%".$request->search."%'");
                    break;
                case 'flt-jenis':
                    $list->whereRaw("upper(c.name) LIKE '%".$request->search."%'");
                    break;
                default:
                    $list->whereRaw("(upper(a.no_pendaftaran) LIKE '%".$request->search."%' OR upper(b.desc) LIKE '%".$request->search."%' OR upper(c.name) LIKE '%".$request->search."%')");
                    break;
            }
        }


        return [
            'list' => $list->get()
        ];
    }

    public function hasManyDisasterReady($stateId){
        return FleetDepartment::where([
            'state_id' => $stateId,
            'disaster_ready' => true
        ])->get();
    }

    public function vehicleTypeList(Request $request){
        $this->current_id = session()->get('disasterready_current_detail_id');
        $query = LogisticDisasterReadyVehicle::where('booking_id', $this->current_id)
        ->whereHas('hasStatus', function($q){
            $q->whereIn('code', ['01']);
        });
        if(Auth::user()->detail->hasPlacement){
            $query->whereHas('hasPlacement', function($q2){
                $q2->where('id', Auth::user()->detail->hasPlacement ? Auth::user()->detail->hasPlacement->id : -1);
            });
        } else {
            $query->whereHas('hasPlacement', function($q2){
                $q2->whereHas('hasState', function($q3){
                    $q3->where('id', Auth::user()->detail->hasWorkshop ? Auth::user()->detail->hasWorkshop->hasState->id : -1);
                });
            });
        }

        $query->orWhere('created_by', Auth::user()->id)
        ->where('booking_id', $this->current_id)
        ->whereHas('hasStatus', function($q){
            $q->whereIn('code', ['01']);
        });

        return $query->orderBy('is_need_driver', 'desc')
        ->orderBy('updated_at','desc')
        ->paginate(5);
    }

}
