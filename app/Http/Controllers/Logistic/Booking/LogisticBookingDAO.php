<?php

namespace App\Http\Controllers\Logistic\Booking;

use App\Http\Controllers\Controller;
use App\Mail\module\logistic\SendEmailToUserWhenBookingStatusReject;
use App\Mail\module\logistic\SendEmailToVOfficerWhenBookingStatusApproval;
use App\Models\Fleet\FleetGrant;
use App\Models\FleetPlacement;
use App\Models\Logistic\LogisticApplicant;
use App\Models\Logistic\LogisticBooking;
use App\Models\Logistic\LogisticBookingTaskScan;
use App\Models\Logistic\LogisticBookingVehicle;
use App\Models\Logistic\LogisticDocument;
use App\Models\Logistic\LogisticPassenger;
use App\Models\LogisticBookingStatus;
use App\Models\LogisticStayStatus;
use App\Models\RefState;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class LogisticBookingDAO extends Controller
{
    public $current_id = -1;
    public $detail;
    public $applicant;
    public $is_display = 0;
    public $stay_status_list;
    public $booking_list;
    public $mode = 0777;
    public $totalProcess = 0;
    public $totalDraft = 0;
    public $totalVerification = 0;
    public $totalApproval = 0;
    public $totalCompleted = 0;

    public function mount(Request $request){

        $TaskFlowAccessVehicle = auth()->user()->vehicleWorkFlow('04', '01');
        $status_code = $request->status_code ? $request->status_code : 'all_inprogress';
        $search = $request->search ? $request->search : null;
        $searchid = $request->searchid ? $request->searchid : null;

        $query = LogisticBooking::whereHas('hasBookingStatus', function($q){
                    $q->whereNotIn('code', ['00']);
                })->orderBy('updated_at', 'desc');

        Log::info('Auth::user()->id '.Auth::user()->id);

        $this->totalDraft = LogisticBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['01']);
        })->where('created_by', Auth::user()->id);
        $this->totalVerification = LogisticBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['02']);
        });
        $this->totalApproval = LogisticBooking::whereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['03']);
        });

        $this->totalCompleted = LogisticBooking::whereHas('hasBookingStatus', function($q){
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

        $this->totalCompleted->orWhereHas('hasBookingStatus', function($q){
            $q->whereIn('code', ['06']);
        })->where('created_by', Auth::user()->id);

        if($status_code == '06'){
            $query->orWhereHas('hasBookingStatus', function($q){
                $q->whereIn('code', ['06']);
            })->where('created_by', Auth::user()->id);
        }

        $this->searching($query, $request);

        $this->totalDraft = $this->totalDraft->count();
        $this->totalVerification = $this->totalVerification->count();
        $this->totalApproval = $this->totalApproval->count();
        $this->totalCompleted = $this->totalCompleted->count();

        $this->totalProcess = $this->totalDraft + $this->totalVerification + $this->totalApproval;
        // dd($request->all());
        // if($searchid != null){

        //     switch ($search) {
        //         case '1':
        //             $query->whereHas('hasApplication', function ($q) use ($search){
        //                 $q->whereHas('hasDepartment', function ($q) use ($search){
        //                     $q->whereRaw("upper(name) LIKE '%".strtoupper($search)."%' ");
        //                 });
        //             });
        //             break;

        //         default:
        //             # code...
        //             break;
        //     }
        // }

        Log::info($query->toSql());
        $this->booking_list = $query->paginate(5);
    }

    public function filterByVehicle($query, Request $request){

        Log::info('$totalVerification toSql => '.$query->toSql());
        Log::info('$totalVerification getBindings => ', $query->getBindings());

        $query->whereHas('hasManyVehicle', function($q){
            if(Auth::user()->isAdmin()){

            } elseif(Auth::user()->detail->hasBranch){
                $q->whereHas('hasBranch', function($q2){
                    $q2->where('id', Auth::user()->detail->hasBranch->id);
                });
            } else if(Auth::user()->detail->hasWorkshop){
                $q->whereHas('hasPlacement', function($q2){
                    $q2->wherehas('hasState', function($q3){
                        $q3->where('id', Auth::user()->detail->hasWorkshop->hasState->id);
                    });
                });
            }
        });

        return $query;
    }

    private function searching($query, Request $request){
        if($request->search || $request->search_date){
            $filter_date = $request->search_date;
            $query->whereDate('created_at', '=', Carbon::parse($filter_date)->toDateString());

            if($request->searchid != null){
                $searchid = $request->searchid;
                $search = $request->search;
                switch ($searchid) {
                    case '1':
                        $query->whereHas('hasApplicant', function ($q) use ($search){
                            $q->whereHas('hasDepartment', function ($q) use ($search){
                                $q->whereRaw("upper(name) LIKE '%".strtoupper($search)."%' ");
                            });
                        });
                        break;

                    default:
                        # code...
                        break;
                }
            }
        }

        return $query;

    }

    public function generateQRCode(Request $request){

        $qrImgUrl = "";
        $checkExistBooking = LogisticBooking::find($request->booking_id);

        if($checkExistBooking && $checkExistBooking->hasBookingStatus->code == '06'){
            $finggerPrintId = request()->fingerprint();
            $url = route('logistic.driver-task.detail', ['finger_print_id' => $finggerPrintId, 'booking_id' => $request->booking_id, 'category' => 'booking']);
            $qrImgUrl = 'images/qrcode-booking-'.$finggerPrintId.'-'.$request->booking_id.'.png';

            Log::info($url);

            $path = public_path().'/images';
            $isExists = File::exists(public_path($path));
            if(!$isExists){
                QrCode::size(500)
                ->format('png')
                ->generate(route('.redirect', ['redirectTo' => $url]), public_path($qrImgUrl));

                LogisticBookingTaskScan::create([
                    'finger_print_id' => $finggerPrintId,
                    'booking_id' => $request->booking_id,
                    'created_by' => Auth::user()->id
                ]);
            }else{
                File::makeDirectory($path, $this->mode, true, true);
                QrCode::size(500)
                ->format('png')
                ->generate(route('.redirect', ['redirectTo' => $url]), public_path($qrImgUrl));

                LogisticBookingTaskScan::create([
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

            Log::info($data);

            return LogisticDocument::create($data);
        }
    }

    public function saveDetail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'department_id' => 'required',
            'tel_no' => 'required',
            'email' => 'required'
        ],
        [
            'name.required' => 'Sila Masukkan Nama',
            'department_id.required' => 'Sila Pilih Cawangan/Jabatan',
            'tel_no.required' => 'Sila Masukkan Telefon No',
            'email.required' => 'Sila Masukkan Emel'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $this->current_id = session()->get('booking_current_detail_id');

        Log::info('booking_current_detail_id --> '.$this->current_id);

        Log::info($request);

        $applicant = [
            'name' => $request['name'],
            'department_id' => $request['department_id'],
            'tel_no' => $request['tel_no'],
            'email' => $request['email']
        ];

        $data = [
            'booking_person_name' => $request['name'],
            'tel_no' => $request['tel_no'],
            'booking_person_email' => $request['email'],
            'booking_by' => auth()->user()->id,
        ];

        // $data['booking_by'] = auth()->user()->id;

        $LogisticBooking = LogisticBooking::find($this->current_id);

        if($LogisticBooking){

            if($LogisticBooking->hasApplicant){
                $LogisticBooking->hasApplicant->update($applicant);
            } else {
                $applicantInserted = LogisticApplicant::create($applicant);
                $data['appl_id'] = $applicantInserted->id;
            }

            $LogisticBooking->update($data);
        } else {
            $data['created_by'] = auth()->user()->id;
            Log::info($data);
            $status_id = $this->bookingStatus("01");
            $data['status_id'] = $status_id;

            $applicantInserted = LogisticApplicant::create($applicant);
            $data['appl_id'] = $applicantInserted->id;

            $inserted = LogisticBooking::create($data);

            $this->current_id = $inserted->id;
            session()->put('booking_current_detail_id', $this->current_id);

        }

        if(!empty($LogisticBooking->hasManyVehicle)){
            $countVehicle = count($LogisticBooking->hasManyVehicle);
        }else{
            $countVehicle = 0;
        }

        return [
            'url' => route('logistic.booking.detail', ['id' => $this->current_id, 'tab' => ($countVehicle > 0 ? 2 :1)])
        ];

    }

    public function vehicleTypeList(Request $request){
        $this->current_id = session()->get('booking_current_detail_id');
        $query = LogisticBookingVehicle::where('booking_id', $this->current_id)
        ->whereHas('hasStatus', function($q){
            $q->whereIn('code', ['01']);
        });

        if(Auth::user()->isAdmin()){

        } else if(Auth::user()->detail->hasPlacement){
            $query->whereHas('hasPlacement', function($q2){
                $q2->where('id', Auth::user()->detail->hasPlacement ? Auth::user()->detail->hasPlacement->id : -1);
            });
        }
        else if(Auth::user()->detail->hasBranch){
            $query->whereHas('hasBranch', function($q2){
                $q2->where('id', Auth::user()->detail->hasBranch ? Auth::user()->detail->hasBranch->id : -1);
            });
        }
        else {
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

    public function vehicleTypePassengerList(Request $request){
        session()->put('current_booking_vehicle_id', $request->booking_vehicle_id);
        $booking_vehicle_id = $request->booking_vehicle_id;
        return LogisticPassenger::where('logistic_booking_vehicle_id', $booking_vehicle_id)->paginate(5);
    }

    public function saveJourney(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hasNewDocWorkInsLetter' => 'in:1,0',
            'work_ins_letter' => 'required_if:hasNewDocWorkInsLetter,1|mimetypes:application/pdf|max:10000',
            'destination' => 'required',
            'reason' => 'required',
            'start_destination' => 'required',
            'end_destination' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required'
        ],
        [
            'work_ins_letter.required_if' => 'Sila Masukkan Surat Arahan Kerja',
            'destination.required' => 'Sila Masukkan Destinasi',
            'reason.required' => 'Sila Masukkan Tujuan',
            'start_destination.required' => 'Sila Masukkan Tempat Menunggu (Pergi)',
            'end_destination.required' => 'Sila Masukkan Tempat Menunggu (Balik',
            'start_datetime.required' => 'Sila Masukkan Masa & Tarikh Perjalanan (Pergi)',
            'end_datetime.required' => 'Sila Masukkan Tempat Menunggu',
            'work_ins_letter.required' =>  'Sila Masukkan Surat Arahan Kerja',
            'work_ins_letter.mimetypes' => 'Sila Masukkan PDF Sahaja',
            'work_ins_letter.max' => 'Sila Masukkan Kurang daripada 10 megabait sahaja',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $this->current_id = session()->get('booking_current_detail_id');

        Log::info($request);

        $data = [
            'destination' => $request['destination'],
            'reason' => $request['reason'],
            'start_destination' => $request['start_destination'],
            'end_destination' => $request['end_destination'],
            'start_datetime' => $request['start_datetime'],
            'end_datetime' => $request['end_datetime'],
            'stay_id' => isset($request['stay_status_id']) ? $request['stay_status_id'] : null
        ];

        $LogisticBooking = LogisticBooking::find($this->current_id);

        if($LogisticBooking){
            $data['work_ins_letter_id'] = $LogisticBooking->work_ins_letter_id;
        }

        if($request->work_ins_letter){
            $work_ins_letter_id = $this->createDoc($request->work_ins_letter)->id;
            $data['work_ins_letter_id'] = $work_ins_letter_id;
        }

        $LogisticBooking->update($data);

        return [
            'url' => route('logistic.booking.detail', ['id' => $this->current_id, 'tab' => 2])
        ];
    }

    public function saveInfo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hasNewDocWorkInsLetter' => 'in:1,0',
            'work_ins_letter' => 'required_if:hasNewDocWorkInsLetter,1|mimetypes:application/pdf|max:10000',
            'tel_no' => 'required',
            'reason' => 'required',
            'destination' => 'required',
            'start_destination' => 'required',
            'end_destination' => 'required',
            'start_datetime' => 'required',
            'end_datetime' => 'required'
        ],
        [
            'work_ins_letter.required_if' => 'Sila Masukkan Surat Arahan Kerja',
            'tel_no.required' => 'Sila Masukkan No Telefon',
            'reason.required' => 'Sila Masukkan Tujuan',
            'destination.required' => 'Sila Masukkan Destinasi',
            'start_destination.required' => 'Sila Masukkan Tempat Menunggu (Pergi)',
            'end_destination.required' => 'Sila Masukkan Tempat Menunggu (Balik',
            'start_datetime.required' => 'Sila Masukkan Masa & Tarikh Perjalanan (Pergi)',
            'end_datetime.required' => 'Sila Masukkan Tempat Menunggu'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $this->current_id = session()->get('booking_current_detail_id');

        Log::info($request);

        $data = [
            'vehicle_id' => $request['vehicle_id'],
            'driver_id' => $request['driver_id']
        ];

        $LogisticBooking = LogisticBooking::find($this->current_id);

        if($LogisticBooking){
            $data['work_ins_letter_id'] = $LogisticBooking->work_ins_letter_id;
        }

        if($request->work_ins_letter){
            $work_ins_letter_id = $this->createDoc($request->work_ins_letter)->id;
            $data['work_ins_letter_id'] = $work_ins_letter_id;
        }

        $LogisticBooking->update($data);

        return [
            'url' => route('logistic.booking.detail', ['id' => $this->current_id, 'tab' => 2])
        ];
    }

    public function read($id){

        $query = LogisticBooking::find($id);
        session()->put('booking_current_detail_id', $id);
        $this->current_id = $id;
        $this->detail = $query;

        Log::info('Auth::user()->name --> '.Auth::user()->name);

        $this->applicant = [
            'booking_person_name' => ($query && $query->booking_person_name ? $query->booking_person_name : Auth::user()->name),
            'booking_person_email' => ($query && $query->booking_person_email ? $query->booking_person_email : Auth::user()->email),
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

    public function vehicleGrantList(Request $request){
        $table = new FleetGrant();
        $query = $table->setTable('fleet.fleet_grant as fd')
        ->select('fd.id AS id', 'fd.no_pendaftaran', 'fd.category_id', 'fd.sub_category_id', 'fd.sub_category_type_id', 'fd.owner_type_id','placement_id',
        'fd.manufacture_year', 'fd.brand_id', 'fd.model_id', 'fd.cawangan_id', 'fd.state_id', 'disaster_ready')
        ->where([
            'is_maintenance' => false,
            'is_evaluation' => false
        ])
        ->leftJoin('ref_sub_category_type AS rsc', 'rsc.id', 'fd.sub_category_type_id')
        ->leftJoin('ref_state AS rs', 'rs.id', 'fd.state_id')
        ->leftJoin('ref_owner_type AS rot', 'rot.id', 'fd.owner_type_id')
        ->leftJoin('ref_owner AS ro', 'ro.id', 'fd.cawangan_id');

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

    private function bookingStatus($code){
        $status = LogisticBookingStatus::where('code',$code)->first();

        return $status->id;
    }

    public function submitForApproval(Request $request)
    {
        $result = 0;
        $ids = $request->input('ids');

        $table = LogisticBooking::class;

        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'submitted_by' => Auth::user()->id,
            'submitted_dt' => Carbon::now(),
            'status_id' => $this->bookingStatus('03')
        ]);

        Log::info($result);

        $emailBody = [
            'title' => 'Maklumat Tempahan Kenderaan',
            'subject' => 'Maklumat Tempahan Kenderaan '.Carbon::now()->format('d/m/Y').' yang perlu disahkan',
            'booking_list' => $query->get(),
        ];

        $userEmail = ['farid.developer.1992@gmail.com'];

        // $VOfficer = User::all();

        // foreach ($query->get() as $data) {
        //     array_push($userEmail, $data->bookingBy->email);
        // }

        $userApproval = new User();

        foreach ($query->get() as $data) {
            $userApprovalList = $userApproval->hasManyApprovalByModule('04','01', $data->hasApplicant->hasDepartment->id);
            foreach ($userApprovalList as $userApproval) {
                foreach ($userApproval->hasManyRoles as $roles) {
                    array_push($userEmail, $roles->hasUser->email);
                }
            }

            Log::info($userEmail);
            Log::info($emailBody);

            //Mail::to($userEmail)->send(new SendEmailToVOfficerWhenBookingStatusApproval($emailBody));

        }

        return [
            'url' => route('logistic.booking.list')
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

        $table = LogisticBooking::class;
        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'status_id' => $this->bookingStatus('04'),
            'note' => $request->note
        ]);

        Log::info($result);
        Log::info('stock sini');

        $emailBody = [
            'title' => 'Maklumat Tempahan Kenderaan',
            'subject' => 'Maklumat Tempahan Kenderaan '.Carbon::now()->format('d/m/Y').' yang ditolak',
            'booking_list' => $query->get(),
        ];

        $userEmail = ['farid.developer.1992@gmail.com'];

        foreach ($query->get() as $data) {
            array_push($userEmail, $data->bookingBy->email);
        }

        Log::info($userEmail);
        Log::info($emailBody);

        Mail::to($userEmail)->send(new SendEmailToUserWhenBookingStatusReject($emailBody));

        return [
            'url' => route('logistic.booking.list')
        ];
    }

    public function approve(Request $request)
    {
        $result = 0;
        $ids = $request->input('ids');

        $table = LogisticBooking::class;
        $query = $table::whereIn('id', $ids);
        $result = $query->update([
            'approved_by' => Auth::user()->id,
            'approved_dt' => Carbon::now(),
            'status_id' => $this->bookingStatus('06')
        ]);

        Log::info($result);

        return [
            'url' => route('logistic.booking.list')
        ];
    }

    public function delete(Request $request){
        $ids = $request->ids;
        Log::info($ids);
        $query = LogisticBooking::whereIn('id', $ids);
        $query->update([
            'status_id' => $this->bookingStatus('00')
        ]);
        Log::info($query->toSql());
        Log::info($query->get());

        $response = [
            'code' => 200,
            'message' => 'Maklumat berjaya dihapus'
        ];

        Log::info($response);
    }

}
