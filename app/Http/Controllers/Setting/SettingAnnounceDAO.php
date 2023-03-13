<?php

namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use App\Models\RefTypeAnnouncement;
use App\Models\SettingAnnouncement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SettingAnnounceDAO extends Controller
{

    public $type_announce_list;
    public $announce_list_with_paging;
    public $current_id;

    public function mount(){

        $this->type_announce_list = RefTypeAnnouncement::all();

        $this->announce_list_with_paging = SettingAnnouncement::orderBy('status', 'desc')->orderBy('sorting', 'asc')->paginate(5);

    }

    public function getList(){

        $rangeDate = "(start_dt >= '".Carbon::now()->format('Y-m-d')."' AND '".Carbon::now()->format('Y-m-d')."' <= end_dt  AND status = 1) OR (start_dt >= '".Carbon::now()->format('Y-m-d')."' AND end_dt is null AND status = 1)";
        $query = SettingAnnouncement::whereRaw($rangeDate)->orderBy('status', 'desc')->orderBy('sorting', 'asc');
        Log::info($query->toSql());
        return $query->get();
    }

    public function setActive(Request $request)
    {
        $query = SettingAnnouncement::find($request->id);
        $data = [
            'status' => $request->status
        ];
        $query->update($data);
    }

    public function updateSorting(Request $request){
        Log::info($request);
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));

            foreach($arr as $sortOrder => $id){
                $announce = SettingAnnouncement::find($id);
                Log::info('$id --> '.$id);
                Log::info('$sortOrder --> '.$sortOrder);
                $announce->sorting = $sortOrder;
                $announce->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }

    public function setSessionDetailID(Request $request){
        session()->put('announcement_current_detail_id', $request->id);
        Log::info(session()->get('announcement_current_detail_id'));
    }

    private function convertDateToSQLDate($dateVal, $format){
        return Carbon::createFromFormat('d/m/Y', $dateVal)->format($format);
    }

    public function save(Request $request){

        $validator = Validator::make($request->all(), [
            'start_dt' => 'required',
            'type_announce_id' => 'required',
            'title_bm' => 'required',
            'desc_bm_1' => 'required'
        ],
        [
            'start_dt.required' => 'Sila Pilih Tarikh Mula',
            'type_announce_id.required' => 'Sila Pilih Jenis Pengumuman',
            'title_bm.required' => 'Sila Masukkan Tajuk Dalam Bahasa Melayu',
            'desc_bm_1.required' => 'Sila Masukkan Penerangan Dalam Bahasa Melayu 1'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = [
            'type_announce_id' => $request->type_announce_id,
            'start_dt' => $this->convertDateToSQLDate($request->start_dt, 'Y-m-d'),
            'end_dt' => $request->end_dt ? $this->convertDateToSQLDate($request->end_dt, 'Y-m-d') : null,
            'title_bm' => $request->title_bm,
            'title_en' => $request->title_en,
            'desc_bm_1' => $request->desc_bm_1,
            'desc_bm_2' => $request->desc_bm_2,
            'desc_en_1' => $request->desc_en_1,
            'desc_en_2' => $request->desc_en_2,
            'created_by' =>  Auth::user()->id
        ];

        $this->current_id = session()->get('announcement_current_detail_id');

        $query = SettingAnnouncement::find($this->current_id);
        if($query){
            $query->update($data);
        } else{
            SettingAnnouncement::create($data);
        }

    }

    public function delete(){

    }
}
