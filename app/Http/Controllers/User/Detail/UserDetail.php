<?php

namespace App\Http\Controllers\User\Detail;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserDetail extends Controller
{
    public $detail;
    public $userId;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {

        $userId = -1;
        if(!empty($this->userId)){
            $this->detail = User::find($this->userId);
        }

        session()->put('session_detail_user_id', $userId);
    }

    public function getWorkshopIdByUserId($user_id){
        // dd($composition_by);
        Log::info('user_id --> '.$user_id);

        $query = DB::select(DB::raw('
        SELECT workshop_id FROM users.details WHERE user_id = ?
        '),[$user_id]);

        //Log::info($query);
        return $query;

    }
}
