<?php

use App\Http\Controllers\Assessment\Currvalue\Vehicle\AssessmentCurrvalueVehicleDAO;
use App\Http\Controllers\Assessment\GovLoan\Vehicle\AssessmentGovLoanVehicleDAO;
use App\Http\Controllers\Assessment\New\Vehicle\AssessmentNewVehicleDAO;
use App\Http\Controllers\Assessment\Safety\Vehicle\AssessmentSafetyVehicleDAO;
use App\Http\Controllers\JasperController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Mailjet\Resources;
use App\Http\Livewire\Auth\Daftar;
use App\Models\Location\Negeri;
use App\Models\RefStatus;
use App\Models\RefSubCategoryType;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/test.php';

Route::any('captcha-test', function() {
    if (request()->getMethod() == 'POST') {
        Log::info(request());
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(request()->all(), $rules);
        Log::info($validator->fails());
        if ($validator->fails()) {
            echo '<p style="color: #ff0000;">111!</p>';
        } else {
            echo '<p style="color: #00ff30;">Matched :)</p>';
        }
    }

    $form = '<form method="post" action="captcha-test">';
    $form .= '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    $form .= '<p>' . captcha_img() . '</p>';
    $form .= '<p><input type="text" name="code"></p>';
    $form .= '<p><button type="submit" name="check">Check</button></p>';
    $form .= '</form>';
    return $form;
});

Route::get('/reload-captcha', function(){

    $Daftar = new Daftar();
    $res = $Daftar->reloadCapcha();

    return $res;
})->name('reload.captcha');

Route::get('/test', function(){

    $user = User::query()->orderBy('id','desc')->first();
    echo $user;


    // $data = DB::select("select a.email from users.users a
    // join model_has_roles b on b.model_id = a.id
    // join roles c on c.id = b.role_id
    // join ref_role d on d.code = c.name
    // join ref_role_access e on e.id = d.ref_role_access_id
    // where e.code in ('03')");

    $refStatusCode = "06";
    $data = RefStatus::where('code', $refStatusCode)->first();
    Log::info($data);

    return $data;

    // $query = DB::select(DB::raw('WITH ranges AS (
    //     SELECT (fromAge)::text||\'-\'||(untilAge)::text AS range,
    //   fromAge AS r_min, untilAge AS r_max
    //       FROM (VALUES (0,1),(1,5),(6,10),(11,20),(21,30),(31,50),(51,100)) AS t(fromAge, untilAge) )
    // SELECT r.r_min, r.range AS "name", count(fd.*) AS total
    //   FROM ranges r
    //   LEFT JOIN "fleet"."fleet_department" fd ON (date_part(\'year\', CURRENT_DATE)-fd.manufacture_year)
    //   BETWEEN r.r_min AND r.r_max
    //  GROUP BY r.range, r.r_min
    //  ORDER BY r.r_min ASC'));

    //  return $query;
});

Route::get('/', function () {
    return view('index');
});

Route::get('/checkSession', function(){
    return Session()->get('session_user_id');
});

Route::get('/redirect', function () {
    Log::info(Request('search'));
    Log::info(Request('redirectTo'));

    $redirectTo = Request('redirectTo');

    $regextComma = "/[,]/";
    $redirectTo = preg_replace($regextComma, '&', $redirectTo);

    Session()->put('session_redirectTo', $redirectTo);
    Session()->put('session_search', Request('search'));
    return Redirect::to('/dashboard');
})->name('.redirect');

require __DIR__.'/auth.php';
require __DIR__.'/dashboards.php';

Route::get('/ajax/lookup/users', function (Request $request) {

    $users = User::select(
        'users.users.id AS id',
        'users.users.name AS name',
        'users.users.email AS email'
    );

    $search = $request->search;
    $filter_by_role = $request->filter_by_role;

    if(!empty($search)){
        $users->whereRaw("lower(name) like '%" . strtolower($search) . "%'");
    }

    Log::info($filter_by_role);

    if(!empty($filter_by_role)){
        $users->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.users.id');
        $users->join('ref_role', 'ref_role.id', '=', 'model_has_roles.role_id');
        $users->where('ref_role.code', $filter_by_role);
    }

    Log::info($users->toSql());

    return view('components.ajax.ajax-user-list', [
        'users' => $users->paginate(5),
        'field_name' => $request->field_name
    ]);
})->middleware(['auth'])->name('ajax.lookup.users');

Route::get('/ajax/lookup/vehicleTypes', function (Request $request) {

    $vehicleTypes = RefSubCategoryType::select('id','code','name');

    $search = $request->search;

    if(!empty($search)){
        $vehicleTypes->whereRaw("lower(name) like '%" . strtolower($search) . "%'");
    }

    return view('components.ajax.ajax-vehicle-type-list', [
        'vehicleTypes' => $vehicleTypes->paginate(5),
        'field_name' => $request->field_name
    ]);
})->middleware(['auth'])->name('ajax.lookup.vehicleType');

Route::get('/underconstruction', function () {
    return view('dashboards.underconstruction');
})->middleware(['auth'])->name('underconstruction');

Route::get('/login', function(){
    return view('auth.login');
})->middleware('guest')->name('login');

//sso-login
require __DIR__.'/sso-login.php';

Route::get('/register', function(){
    return view('auth.daftar');
})->middleware('guest')->name('register');

Route::get('/forgot', function(){
    return view('auth.forgot');
})->middleware('guest')->name('forgot');

Route::get('/forgot-account', function(){
    return view('auth.forgot-account');
})->middleware('guest')->name('forgot.account');

Route::get('/forgot-request-success', function(){
    $email = '';
    if(session()->get('sess_req_email')){
        $email = session()->get('sess_req_email');
    }
    return view('auth.forgot-request-success', [
        'email' => $email
    ]);
})->middleware('guest')->name('forgot.request.success');

Route::get('/forgot-account-request-success', function(){
    $email = '';
    if(session()->get('sess_req_email')){
        $email = session()->get('sess_req_email');
    }
    return view('auth.forgot-account-request-success', [
        'email' => $email
    ]);
})->middleware('guest')->name('forgot.account.request.success');

Route::get('/success', function(){
    $email = '';
    if(session()->get('sess_req_email')){
        $email = session()->get('sess_req_email');
    }
    return view('auth.daftar-berjaya', [
        'email' => $email
    ]);
})->middleware('guest')->name(".success");

Route::get('/signin', function(){
    return view('auth.signin');
})->middleware('guest')->name('signin');

Route::get('/activation-user', function(){
    return view('auth.activation.user');
})->middleware('guest')->name('activation.user');

Route::get('/change-password-user', function(){
    return view('auth.activation.user');
})->middleware('auth')->name('change.password.user');

Route::get('/checkEmail', function(){

    $data = array('name'=>"Virat Gandhi");

    $res = Mail::send(['text'=>'mail'], $data, function($message) {
        $message->to('farid.developer.1992@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
        $message->from('xyz@gmail.com','Virat Gandhi');
    });

    Log::info($res);

    return $data;
})->name('check.email');

Route::get('/usedbraw', function(){
    $negeri = 'KEDAH';
    $data = Negeri::select('negeri')->whereRaw("upper(negeri) = '".$negeri."' ")
    ->first();
    return $data;
})->middleware('auth')->name('testing.use.dbraw');

// Route::get('/checkMailConfig', function(){
//     dd(Config::get('mail'));
//     return 'as';
// })->middleware('auth')->name('login');

Route::get('send-mail', function () {

  $mj = new \Mailjet\Client('99a56cb1689ada9a64419d09581a6f4f','7df7692d49fa455b48b08252460ebed2',true,['version' => 'v3.1']);
  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "farid.developer.1992@gmail.com",
          'Name' => "farid"
        ],
        'To' => [
          [
            'Email' => "farid.developer.1992@gmail.com",
            'Name' => "farid"
          ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'TextPart' => "My first Mailjet email",
        'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);

  Log::info($response->getData());
  $response->success() && var_dump($response->getData());

});

//Global Route
Route::group(['prefix' => 'global', 'as' => 'global', 'middleware' => 'auth'], function(){

    Route::get('/search', function(){
        $search = session()->get('session_search');
        return view('dashboards.global-search', ['search' => $search]);
    })->name('.search');

});

//jgn kacau mockup farid
require __DIR__.'/module/module-farid-mockup.php';

require __DIR__.'/module/module-vehicle.php';
require __DIR__.'/module/module-logistic.php';
require __DIR__.'/module/module-reporting.php';

require __DIR__.'/module/module-maintenance.php';
require __DIR__.'/module/module-assessment.php';

require __DIR__.'/module/module-access.php';

require __DIR__.'/module/module-setting.php';

require __DIR__.'/module/module-reference.php';


// Route::group(['prefix' => 'new', 'as' => '.new', 'middleware' => 'guest'], function(){

Route::get('/assessment/new/vehicle-certificate-checkGenuine', function (Request $request) {
    $AssessmentNewVehicleDAO = new AssessmentNewVehicleDAO();
    $detail = $AssessmentNewVehicleDAO->checkGenuine($request);
    return view('assessment.new.new-vehicle-certificate-check-genuine', [
        'detail' => $detail
    ]);
})->middleware('guest')->name('assessment.new.vehicle-certificate.checkGenuine');

Route::get('/assessment/safety/vehicle-certificate-checkGenuine', function (Request $request) {
    $AssessmentSafetyVehicleDAO = new AssessmentSafetyVehicleDAO();
    $detail = $AssessmentSafetyVehicleDAO->checkGenuine($request);
    return view('assessment.safety.safety-vehicle-certificate-check-genuine', [
        'detail' => $detail
    ]);
})->middleware('guest')->name('assessment.safety.vehicle-certificate.checkGenuine');

Route::get('/assessment/currvalue/vehicle-certificate-checkGenuine', function (Request $request) {
    $AssessmentCurrvalueVehicleDAO = new AssessmentCurrvalueVehicleDAO();
    $detail = $AssessmentCurrvalueVehicleDAO->checkGenuine($request);
    return view('assessment.currvalue.currvalue-vehicle-certificate-check-genuine', [
        'detail' => $detail
    ]);
})->middleware('guest')->name('assessment.currvalue.vehicle-certificate.checkGenuine');

Route::get('/assessment/gov_loan/vehicle-certificate-checkGenuine', function (Request $request) {
    $AssessmentGovLoanVehicleDAO = new AssessmentGovLoanVehicleDAO();
    $detail = $AssessmentGovLoanVehicleDAO->checkGenuine($request);
    return view('assessment.gov_loan.gov-loan-vehicle-certificate-check-genuine', [
        'detail' => $detail
    ]);
})->middleware('guest')->name('assessment.gov_loan.vehicle-certificate.checkGenuine');

// });

Route::group(['prefix' => 'spakat', 'as' => 'spakat'], function(){

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/pengguna', function(){
            // $role = \Spatie\Permission\Models\Role::all()
            return view('dashboards.pengguna');
        })->name('.pengguna');

        Route::get('/pengguna/{id}', function(){
            // $role = \Spatie\Permission\Models\Role::all()
            return view('dashboards.pengguna.profile');
        })->name('.pengguna.profile');
    });
});

//admin
require __DIR__.'/base.php';

//Test Jasper
Route::get('/jasperReport', [JasperController::class, 'jasperReportAPI'])->middleware(['auth'])->name('jasperReport');



// Route::get('/assignRole', function(Request $request){
//     $user = User::find($request->id);
//     Log::info($user->roles);
//     $user->syncRoles(['04','03','02']);
//     return [
//         'isEngineer' => $user->isEngineer(),
//         'isAssistEngineer' => $user->isAssistEngineer()
//     ];
// })->middleware('auth')->name('assign.role');

Route::get('/switch-user', function(Request $request){

    $username = $request->username;

    if(auth()->user()->isAdmin() && $username){

        $user = User::where('username', $username)->first();
        Auth::login($user);
        Session::put('session_user_id', $user -> id);

        if (Auth::user()->roleAccess()->code == '01') {
            return redirect()->route('access.admin');
        } else if(Auth::user()->roleAccess()->code == '02'){
            return redirect()->route('access.management');
        } else if(Auth::user()->roleAccess()->code == '03'){
            return redirect()->route('access.operation');
        } else {
            return redirect()->route('access.public');
        }

    }
})->middleware('auth')->name('switch-user');

Route::post('/post-switch-user', function(Request $request){

    $username = $request->username;
    Log::info('$username =>'.$username);
    $session_prev_id = session()->get('session_switch_admin_id');

    if(auth()->user()->isAdmin() && $username || $session_prev_id){

        if($session_prev_id){
            $user = User::find($session_prev_id);
            Session::put('session_switch_admin_id',null);
        } else {
            $user = User::where('username', $username)->first();
        }

        Log::info(User::where('username', $username)->get());

        if(auth()->user()->isAdmin()){
            Session::put('session_switch_admin_id', auth()->user()->id);
        }

        Log::info('$user => ');
        Log::info($user);

        Auth::login($user);
        Session::put('session_user_id', $user -> id);

        if (Auth::user()->roleAccess()->code == '01') {
            Session::put('session_redirectTo', route('access.user.registered'));
            return route('access.admin');
        } else if(Auth::user()->roleAccess()->code == '02'){
            return route('access.management');
        } else if(Auth::user()->roleAccess()->code == '03'){
            return route('access.operation');
        } else {
            return route('access.public');
        }

    }
})->middleware('auth')->name('switch.user.post');

Route::get('/download-apk-latest', function(Request $request){

    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    return response()->file($storagePath.'/apk/spakat_app.apk', [
        'Content-Type'=>'application/vnd.android.package-archive',
        'Content-Disposition'=> 'attachment; filename="spakat_app.apk"',
    ]);

})->middleware('auth')->name('download.apk.latest');

Route::get('/download-user-manual-logistic', function(Request $request){

    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    return response()->file($storagePath.'/apk/Manual_Pengguna_Modul_Logistik.pdf', [
        'Content-Type'=>'application/pdf',
        'Content-Disposition'=> 'attachment; filename="Manual_Pengguna_Modul_Logistik.pdf"',
    ]);

})->middleware('auth')->name('download.user.manual.logistic');

Route::get('/download-user-manual-assessment', function(Request $request){

    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    return response()->file($storagePath.'/apk/Manual_Pengguna_Modul_Penilaian.pdf', [
        'Content-Type'=>'application/pdf',
        'Content-Disposition'=> 'attachment; filename="Manual_Pengguna_Modul_Penilaian.pdf"',
    ]);

})->middleware('auth')->name('download.user.manual.assessment');

Route::get('/download-user-manual-maintenance', function(Request $request){

    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    return response()->file($storagePath.'/apk/Manual_Pengguna_Modul_Penyenggaraan.pdf', [
        'Content-Type'=>'application/pdf',
        'Content-Disposition'=> 'attachment; filename="Manual_Pengguna_Modul_Penyenggaraan.pdf"',
    ]);

})->middleware('auth')->name('download.user.manual.maintenance');

Route::get('/download-user-manual-vehicle', function(Request $request){

    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
    return response()->file($storagePath.'/apk/Manual_Pengguna_Modul_Rekod_Kenderaan.pdf', [
        'Content-Type'=>'application/pdf',
        'Content-Disposition'=> 'attachment; filename="Manual_Pengguna_Modul_Rekod_Kenderaan.pdf"',
    ]);

})->middleware('auth')->name('download.user.manual.vehicle');


Route::get('/test-jasper-api', function(Request $request){

    //http://spakat.test/test-jasper-api?report_name=test&report_type=pdf&title=1212

    $reportName = $request->report_name;
    $reportType = $request->report_type;
    $title = $request->title;
    $format = 'pdf';

    $filePath = app_path().'/jasper/'.$reportName.'.jasper';

    $endpoint = "http://sepakat/jasper/report";
    $client = new \GuzzleHttp\Client();

    $params['isStaging'] = 0;
    $params['jasper'] = 'test';
    $params['report_type'] = $reportType;
    $params['fullPath'] = $filePath;
    $params['host'] = 'jdbc:postgresql://'.env('DB_HOST').':'.env('DB_PORT').'/'.env('DB_DATABASE');
    $params['username'] = env('DB_USERNAME');
    $params['password'] = env('DB_PASSWORD');

    switch ($reportType) {
        case 'pdf':
            $params['report_type'] = $reportType;
            $titleWithFormat = $title.'.pdf';
            $headers = [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$titleWithFormat.'"'
            ];
            break;
        case 'excel':
            $format  = 'xls';
            $titleWithFormat = $title.'.xls';
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="'.$titleWithFormat.'"'
            ];
            break;
        case 'word':
            $format  = 'docx';
            $titleWithFormat = $title.'.docx';
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'Content-Disposition' => 'attachment; filename="'.$titleWithFormat.'"'
            ];
            break;

        default:
        $format  = 'pdf';
            break;
    }

    $options = [
        'query' => $params
    ];

    $response = $client->request('POST', $endpoint, $options);
    $body = $response->getBody();

    $filename = $reportName.'-'.date('d-m-y-h:m:s');
    $output = public_path().'/jasper/'.$filename;

    Log::info($headers);

    Storage::disk('local')->put($output.'.'.$format, $body);
    $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

    return response()->file($storagePath."/".$output.'.'.$format, $headers)->deleteFileAfterSend(true);

});
