<?php
namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Warrant\WarrantDistributionDAO;
use App\Http\Controllers\User\UserDAO;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Users\Detail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use phpseclib3\Crypt\Hash;
use Illuminate\Support\Str;

class TestController extends Controller
{
    //

    public function first(){

        //echo "<h1>Hello</h1>";
        Log::info("hello !");

        //return view("welcome"); //inside resources first.blade.php
        $posts = "dd";

        $qry = 'SELECT * FROM users.users WHERE id=1 ' ;
        $user = DB::select($qry);


        $alluser = User::whereHas('detail', function($q){
            $q->whereHas('refStatus', function($q2){
                $q2->where('code', '03');
            });
        })->paginate(5);



        Log::info("sample 1 : ".$user[0]->id);
        Log::info("sample 2 : ".$alluser[0]->id);

        return view("testcontroller",['posts'=>$alluser, 'users'=>$user]);
    }

    public function firstSecond($id, $name=null){

        echo "<h1>Hello : </h1>" .$id .$name;
        return view("first"); //inside resources first.blade.php
    }

    public function testDate(Request $request){
        $data = Carbon::now()->format('Y-m-d H:m:s');
        return $data;
    }

    public function OsolType(Request $request){

        $monthDesc = [
            '0' => 'Sepanjang Tahun',
            '1' => 'Januari',
            '2' => 'Febuari',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Julai',
            '8' => 'Ogos',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember'
    
        ];

        $selectedYear = 2021;
        $selectedMonth = 1;
        $vehicleDepreciationDAO = new WarrantDistributionDAO();
        $osol26 = $vehicleDepreciationDAO->getWarrantDataByOsolType(1,$selectedYear,$selectedMonth);
        $osol28 = $vehicleDepreciationDAO->getWarrantDataByOsolType(2,$selectedYear,$selectedMonth);
        $osolSum26 = $vehicleDepreciationDAO->getWarrantSumMHPV('01',$selectedYear,$selectedMonth);
        $osolSum28 = $vehicleDepreciationDAO->getWarrantSumMHPV('02',$selectedYear,$selectedMonth);
        return view('maintenance.job.examination.tab.preview.osol-type',[
            'selectedYear' => $selectedYear,
            'selectedMonth' => $selectedMonth,
            'monthDesc' => $monthDesc,
            'osol26' => $osol26,
            'osolSum26' => $osolSum26,
            'osol28' => $osol28,
            'osolSum28' => $osolSum28,
            'osol_type_code' => $request->osol_type_code
        ]);
    }

}
