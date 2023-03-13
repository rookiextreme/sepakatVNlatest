<?php
namespace App\Http\Controllers\SSO;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Maintenance\Warrant\WarrantDistributionDAO;
use App\Http\Controllers\Setting\SettingGeneralDAO;
use App\Http\Controllers\User\UserDAO;
use App\Models\RefAgency;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefWorkshop;
use App\Models\User;
use App\Models\Users\Detail;
use App\Repositories\Auth\RegisterRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use phpseclib3\Crypt\Hash;
use Illuminate\Support\Str;

class SSOLoginDAO extends Controller
{

    public function ssoLogin(Request $request){

        $data = [
            "rekod" => [
                "nama" => "MOHD YUSMAN BIN YUNUS",
                "kod_warganegara" => "Y",
                "agama" => "I",
                "mobile" => "010-2686740",
                "email" => "yusmanyunus@jkr.gov.my",
                "alamat" => "NO 548, JALAN S2F15, GARDEN HOMES, SEREMBAN 2 70300 SEREMBAN",
                "gred" => "JA36",
                "jawatan" => "PENOLONG JURUTERA (MEKANIKAL)",
                "tel_pejabat" => "03-26189547",
                "jantina" => "L",
                "gelaran_jawatan" => null,
                "kod_waran" => "050403100000",
                "jenis_jawatan" => "N",
                "kod_status_aktif" => "1",
                "kod_kumpulan" => "4",
                "sektor" => "Sektor Pakar",
                "cawneg" => "Cawangan Kejuruteraan Mekanikal",
                "bhgndaerah" => "Khidmat Pakar",
                "waran" => "JKR Woksyop Persekutuan (Bahagian Perkhidmatan Harta)"
            ],
            "ketua" => [[
                "nokp" => "691027115015",
                "nama" => "ADAM B SIDEK"
            ], [
                "nokp" => "890212035895",
                "nama" => "AFIQ BIN MOHAMAD JOHARI"
            ], [
                "nokp" => "930311145495",
                "nama" => "AIDIL MUZAMIL BIN JALANI"
            ], [
                "nokp" => "681230015766",
                "nama" => "AISHAH HAZLINA BINTI MD DEAN"
            ], [
                "nokp" => "830611125615",
                "nama" => "AL&#039; AZHARINO BIN AHMAD"
            ], [
                "nokp" => "790803065190",
                "nama" => "ANISAH BINTI IDRIS"
            ], [
                "nokp" => "750811025467",
                "nama" => "AZHARY BIN AWANG"
            ], [
                "nokp" => "620819035517",
                "nama" => "AZMI BIN MOHAMAD SALLEH"
            ], [
                "nokp" => "820120015535",
                "nama" => "AZRUL NIZAM BIN ADENAN"
            ], [
                "nokp" => "800113025227",
                "nama" => "BURQANUDIN BIN MOHD HUSSAIN"
            ], [
                "nokp" => "821130106101",
                "nama" => "FADZLI BIN MOHAMMAD NGIMRITI"
            ], [
                "nokp" => "770905075703",
                "nama" => "FAIZ BIN FADZIL"
            ], [
                "nokp" => "870802025074",
                "nama" => "HARIATUL BINTI MUSTAFA"
            ], [
                "nokp" => "711005016441",
                "nama" => "KHAIRUDDIN B IBRAHIM"
            ], [
                "nokp" => "780729035807",
                "nama" => "MOHAMAD NIZAM BIN IBRAHIM"
            ], [
                "nokp" => "830709145999",
                "nama" => "MOHAMED FATHUL HAKIMI BIN MOHAMED HANAN"
            ], [
                "nokp" => "850303015711",
                "nama" => "MOHD AMIRUL ASWAD BIN KHAIRUDDIN"
            ], [
                "nokp" => "840413145569",
                "nama" => "MOHD AZLAN BIN UMAR"
            ], [
                "nokp" => "791009086183",
                "nama" => "MOHD NAIMIE B MAZID"
            ], [
                "nokp" => "740824085865",
                "nama" => "MOHD NORDDIN B ISMAIL"
            ], [
                "nokp" => "890225115421",
                "nama" => "MUHAMMAD ABDILLAH BIN ALWI"
            ], [
                "nokp" => "920816086487",
                "nama" => "MUHAMMAD AL AMIRUL RASHID BIN MUHAMAD DAUD"
            ], [
                "nokp" => "891202145411",
                "nama" => "muhammad khalil bin mohd khir"
            ], [
                "nokp" => "820801075488",
                "nama" => "NOOR FADZLILY BINTI MOHD AMIN"
            ], [
                "nokp" => "830709145702",
                "nama" => "NORAINI BINTI ABD. RANI"
            ], [
                "nokp" => "740305025000",
                "nama" => "NOR HAYATI BINTI YAHYA"
            ], [
                "nokp" => "760217035397",
                "nama" => "NORHISHAM BIN LAUNAH"
            ], [
                "nokp" => "780201086913",
                "nama" => "NORIZALUDIN BIN ABD KARIM"
            ], [
                "nokp" => "940520106248",
                "nama" => "nur&#039;ayuni binti safari"
            ], [
                "nokp" => "790423086045",
                "nama" => "osman bin abdul wahid"
            ], [
                "nokp" => "800305065522",
                "nama" => "ROSMAWATI BT ZAHARI"
            ], [
                "nokp" => "801223145048",
                "nama" => "SAMSIAH BT OMAR"
            ], [
                "nokp" => "690325015886",
                "nama" => "SHARIFAH DZAIN SYED YUSOF"
            ], [
                "nokp" => "780809055322",
                "nama" => "SHIELA BT SHARIF"
            ], [
                "nokp" => "680110115055",
                "nama" => "SUHAILI BIN MANSOR"
            ], [
                "nokp" => "920205065484",
                "nama" => "SYARIFAH NORFATIN BINTI SYED IDRUS"
            ], [
                "nokp" => "851023036301",
                "nama" => "TS. MOHD BADRULHISYAM BIN MOHAMAD NOOR"
            ], [
                "nokp" => "861221296197",
                "nama" => "Y.M. RAJA SAIFUL SAFWAN BIN RAJA MUHAMMAD"
            ], [
                "nokp" => "701102105017",
                "nama" => "ZAILANI B NAGIN"
            ], [
                "nokp" => "640426065350",
                "nama" => "ZALINA BINTI MOHD YUSUF"
            ], [
                "nokp" => "670724065073",
                "nama" => "ZAMMERI BIN SAHAR"
            ], [
                "nokp" => "780622086137",
                "nama" => "zamri bin zulkipili"
            ], [
                "nokp" => "770529016223",
                "nama" => "ZULZANI BIN EBON"
            ]],
            "title" => "Butiran kakitangan di dalam Sistem MyKJ."
        ];

        $client_key = $request->client_key;
        Log::info('$client_key '.$client_key);

        if($client_key){
            $username = $request->username;
            $user = User::where([
                'username' => $username,
                'session_key' => $client_key
            ])->first();
            if($user){
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
        }
    }

    public function cbSSOLogin(Request $request){

        if($request->app_key != '10101010101010-sso-key'){
            return $response = [
                'message' => 'dont bypass'
            ];
        }

        $username = $request->username;
        $jawatan = $request->jawatan;
        //920414-10-5577
        Log::info($username);
        $user = null;
        if($username){
            $user = User::where('username', $username)->first();
        }

        if($user){

            $generate = Str::random(40);
            Session::put('session_key', $generate);
            $user->update([
                'session_key' => $generate
            ]);
            return [
                'url' => route('ssoLogin', ['username' => $user->username, 'client_key'=>$generate])
            ];

        } else {
            $response = [
                'message' => 'Tiada data'
            ];
        }

        return $response;

    }

    public function cbSSOLogin2(Request $request){

        Log::info($request);

        return view('auth.sso-login');

    }

    public function cbSSOLoginAction(Request $request){

        Log::info($request);
        //830709145999
        $username = $request->username;

        $endpoint = "http://api.jkr.gov.my/api/staffinfoall/nokp/".$username;
        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', $endpoint);

        $statusCode = $response->getStatusCode();
        $content = json_decode($response->getBody(), true);

        Log::info($statusCode);
        Log::info($content);

        if(500 === $statusCode){
            return 'Something went wrong';
        } else if(200 == $statusCode){
            if(isset($content['rekod'])){

                $record = $content['rekod'];
                Log::info('$record => ',$record);

                $ownerTypeByFederal = RefOwnerType::where([
                    'code' => '01',
                    'display_for' => 'user_register'
                ])->first();

                $ownerTypeByState = RefOwnerType::where([
                    'code' => '02',
                    'display_for' => 'user_register'
                ])->first();

                if(strtoupper($content['rekod']['sektor']) == 'NEGERI'){
                    $ownerTypeId = $ownerTypeByState->id;
                } else{
                    $ownerTypeId = $ownerTypeByFederal->id;
                }

                $roleMap = [
                    'JURUTERA MEKANIKAL' => '03',
                    'PENOLONG JURUTERA (MEKANIKAL)' => '04',
                    'PEMBANTU KEMAHIRAN' => '09'
                ];

                if(isset($roleMap[$content['rekod']['jawatan']])){

                    $branch= RefOwner::whereRaw("upper(name) = '".strtoupper(trim($content['rekod']['cawneg']))."'")
                    ->where('owner_type_id', $ownerTypeId)
                    ->first();

                    $branchId = $branch ? $branch->id : null;

                    $userDAO = new UserDAO();
                    $name = $content['rekod']['nama'];
                    $username = $username;
                    $email = $content['rekod']['email'];
                    $password = Str::random(10);
                    $register_purpose = "is_jkr";
                    $telbimbit = $content['rekod']['mobile'];
                    $telpejabat = $content['rekod']['tel_pejabat'];
                    $address = $content['rekod']['alamat'];
                    $departmentName = $content['rekod']['waran'];

                    $roleCode = $roleMap[$content['rekod']['jawatan']];
                    $workshop = RefWorkshop::where('code_warrant_ofs', $content['rekod']['kod_waran'])->first();

                    Log::info('default password sso => '.$password);

                    User::where([
                        'username' => $username,
                        'is_sso' => true,
                    ])->update([
                        'email' => $content['rekod']['email'],
                    ]);


                    if($username){
                        $user = User::where([
                            'username' => $username,
                            'email' => $content['rekod']['email'],
                        ])->orderBy('id','desc')->first();

                        $adminsy = ['820417086203'];

                        if(in_array($username, $adminsy)){
                            $roleCode = '01';
                        }

                        if(!$user){

                            $checkEmail = User::where('email', $content['rekod']['email'])->first();

                            if($checkEmail){
                                Log::info($email);
                                Log::info("email already exist and redirect cb.sso.login.response :: SSO Login");
                                Redirect::to(route('cb.sso.login.response', ['res_method' => 'email_duplicate']));
                                $notThisEmailUser = User::
                                    where('email', '!=',$content['rekod']['email'])
                                    ->where('username', $username);
                                $notThisEmailUser->update([
                                    'username' => 'xxx-'.$checkEmail->username,
                                    'email' => 'xxx-'.$checkEmail->email
                                ]);
                            }

                            switch ($roleCode) {
                                case '01':
                                    $user = $userDAO->createUserAdmin($name, $username, $email, $password, ($workshop ? $workshop->code : null), $register_purpose, $telbimbit, $roleCode);
                                    break;
                                case '03':
                                    $user = $userDAO->createUserEngineer($name, $username, $email, $password, ($workshop ? $workshop->code : null), $register_purpose, $telbimbit, $roleCode);
                                    break;

                                case '04':
                                    $user = $userDAO->createUserAssistEngineer($name, $username, $email, $password, ($workshop ? $workshop->code : null), $register_purpose, $telbimbit, $roleCode);
                                    break;

                                case '09':
                                    $user = $userDAO->createUserForemen($name, $username, $email, $password, ($workshop ? $workshop->code : null), $register_purpose, $telbimbit, $roleCode);
                                    break;

                                default:
                                    break;
                            }

                            $user->update([
                                'is_sso' => true
                            ]);

                            $user->detail()->update([
                                'identity_no' => $username,
                                'telpejabat' => $telpejabat,
                                'address' => $address,
                                'department_name' => $departmentName,
                                'owner_type_id' => $ownerTypeId
                            ]);

                            $detail = $user->detail;
                            $data = [
                                'owner_type_id' => $ownerTypeId,
                                'branch_id' => $branchId,
                                'division_desc' => $departmentName
                            ];

                            $SettingGeneralDAO = new SettingGeneralDAO();
                            $SettingGeneralDAO->jkr($detail, $data);

                        } else if($user){
                            Auth::login($user);
                            $user->update([
                                'is_sso' => true,
                                'login_from_sso' => true,
                                'is_login' => 1,
                            ]);
                            Session::put('session_user_id', $user -> id);

                            if (Auth::user()->roleAccess()->code == '01') {
                                return Redirect::to(route('access.admin'));
                            } else if(Auth::user()->roleAccess()->code == '02'){
                                return Redirect::to(route('access.management'));
                            } else if(Auth::user()->roleAccess()->code == '03'){
                                return Redirect::to(route('access.operation'));
                            } else {
                                return Redirect::to(route('access.public'));
                            }
                        }
                    } else {
                        return 'someting went wrong';
                    }

                } else {

                    $branch= RefOwner::whereRaw("upper(name) = '".strtoupper(trim($content['rekod']['cawneg']))."'")
                    ->where('owner_type_id', $ownerTypeId)
                    ->first();

                    $branchId = $branch ? $branch->id : null;

                    $userDAO = new UserDAO();
                    $name = $content['rekod']['nama'];
                    $username = $username;
                    $email = $content['rekod']['email'];
                    $password = Str::random(10);
                    $register_purpose = "is_jkr";
                    $telbimbit = $content['rekod']['mobile'];
                    $telpejabat = $content['rekod']['tel_pejabat'];
                    $address = $content['rekod']['alamat'];
                    $departmentName = $content['rekod']['waran'];

                    Log::info('default password sso'.$password);

                    $workshop = RefWorkshop::where('code_warrant_ofs', $content['rekod']['kod_waran'])->first();

                    if($username){
                        $user = User::where([
                            'username' => $username
                        ])->first();

                        if(!$user){
                            $user = User::where([
                                'email' => $email
                            ])->first();
                        }

                        if(!$user){
                            $user = $userDAO->createUserPublic($name, $username, $email, $password, ($workshop ? $workshop->code : null), 'is_public_jkr', $telbimbit);
                            //return 'Jawatan '.$content['rekod']['jawatan'].' tiada didalam sistem';
                            $user->update([
                                'is_sso' => true
                            ]);
                            $user->detail()->update([
                                'identity_no' => $username,
                                'telpejabat' => $telpejabat,
                                'address' => $address,
                                'department_name' => $departmentName,
                                'owner_type_id' => $ownerTypeId
                            ]);

                            $detail = $user->detail;
                            $data = [
                                'owner_type_id' => $ownerTypeId,
                                'branch_id' => $branchId,
                                'division_desc' => $departmentName
                            ];

                            $SettingGeneralDAO = new SettingGeneralDAO();
                            $SettingGeneralDAO->jkrPublicStaff($detail, $data);
                        }

                        if($user){
                            Auth::login($user);
                            $user->update([
                                'is_sso' => true,
                                'login_from_sso' => true,
                                'is_login' => 1,
                            ]);
                            Session::put('session_user_id', $user->id);

                            if (Auth::user()->roleAccess()->code == '01') {
                                return Redirect::to(route('access.admin'));
                            } else if(Auth::user()->roleAccess()->code == '02'){
                                return Redirect::to(route('access.management'));
                            } else if(Auth::user()->roleAccess()->code == '03'){
                                return Redirect::to(route('access.operation'));
                            } else {
                                return Redirect::to(route('access.public'));
                            }
                        }

                    }

                }

            } else {
                $target = route('cb.sso.login');
                return 'Login Ralat. Sila Cuba lagi. <a href="https://sso.jkr.gov.my/nidp/idff/sso?option=credential&target='.$target.'">Klik Di sini</a>';
            }
        }

    }

}
