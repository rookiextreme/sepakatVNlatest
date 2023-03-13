<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\Identifier\Jawatan;
use App\Models\Identifier\IdentityType;
use App\Models\Identifier\Jabatan;
use App\Models\Location\Cawangan;
use App\Repositories\Auth\RegisterRepository;
use App\Models\Identifier\Kementerian;
use App\Models\RefAgency;
use App\Models\RefBranch;
use App\Models\RefDivision;
use App\Models\RefOwner;
use App\Models\RefOwnerType;
use App\Models\RefSector;
use App\Models\RefUnit;
use App\Models\RefUnitSub;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Testing\Fakes\MailFake;

use Faker\Factory as Faker;

class Daftar extends Component
{
    public $lang = 'bm';
    public $ttlDaftar;
    public $ttlComp;
    public $lblFullName;
    public $lblIdentityNo;
    public $lblEmail = "Email";
    public $lblMobile = "Handphone Number";
    public $lblOffice = "Office Phone Number";
    public $lblRegisterPurpose = "Registration purpose";

    //purpose registration
    public $lblJKR = "JKR";
    public $lblGoverAgency = "Government Agency (Except JKR)";
    public $lblContractor = "Contractor";
    public $lblPublic = "Public";
    public $owner_type_list;

    //lblRegisterPurpose == is_jkr
    public $lblOwnership = "Ownership";
    public $owner_type_id;
    public $lblOwnershipFederal = "Persekutuan";
    public $lblOwnershipState = "Negeri";
    public $owner_branch_list;

    public $lblDesignation = "Designation";
    public $lblAgency = "Agency";
    public $lblBranch = "Branch";
    public $lblDivision = "Division";
    public $lblUnit = "Unit";
    public $lblSubUnit = "Sub Unit";
    public $lblCompName;
    public $lblSSM;
    public $lblProject;
    public $lblGovern;
    public $trdParty;
    public $lblCitizen;
    public $lblDaftar;
    public $lblReset;
    public $lblLogin;
    public $lblTerma;
    public $lblSyarat;

    public $isDemo = false;
    public $email;
    public $name;
    public $identity;
    public $identityNo;
    public $office;
    public $phone;
    public $registerPurpose;
    public $gover = false;
    public $jkr = false;

    public $designation;
    public $division_desc;
    public $jabatan_id;
    //public $unit;
    public $ministry_id;
    //public $branch;
    public $agency_id;
    public $branch_id;
    public $division_id;
    public $unit_id;
    public $unit_sub_id;

    public $companyName;
    public $ssm_no;
    public $latest_project_name;
    public $companyKem;

    public $jawatans;
    public $jabatans = [];
    public $branch = [];
    public $division = [];
    public $unit = [];
    public $unit_sub = [];
    public $identities;
    public $cawangan;
    public $ministryLists;
    public $sector_list;
    public $agency_list;
    public $code;
    public $captcha_verified = false;
    public $response;
    public $err  = false;

    public $er = 'test';

    public $idLabel = 'No Kad Pengenalan';


    protected $rules = [];
    protected $message = [];

    public function mount()
    {

        Log::info(App::environment());
        if (App::environment(['local'])) {
            Log::info('saya local');
            $this->isDemo = true;
        }

        if(Request('lang')){
            $this->lang = Request('lang');
        }

        $this->languageProps($this->lang);

        Log::info("masuk");
        Log::info('$registerPurpose --> '.$this->registerPurpose);

        $this->jawatans = Jawatan::all();
        $this->identities = IdentityType::all();
        $this->cawangan = Cawangan::all();
        $this->ministryLists = RefAgency::all();

        $faker = Faker::create();

        if($this->isDemo){
            Log::info($faker->email);
            $this->name = "Muhamad Fariduddin Bin Hashim";
            $this->email = $faker->email;
            $this->identity = 3;
            $this->UpdateLabel();
            $this->identityNo = "920414-10-5577";
            $this->office = "03918282818";
            $this->phone = "0166279246";
        }

    }

    public function registerPurposeChanged(){
        Log::info('call func :: registerPurposeChanged() '.$this->registerPurpose);

        if($this->registerPurpose == 'is_jkr'){
            $this->owner_type_list = RefOwnerType::where([
                'status' => 1,
                'display_for' => 'user_register'
            ])->get();
        } else if($this->registerPurpose == 'is_gover_agency'){
            // $this->sector_list = RefSector::all();
            $this->agency_list = RefAgency::all();
        }

        $this->emit('registerPurposeChanged', $this->registerPurpose);
    }

    public function ownershipChanged(){

        Log::info('call func :: ownershipChanged()');

        $this->getOwnerBranch();

        $this->emit('ownershipChanged', $this->owner_type_id);
    }

    public function languageProps($lang){
        switch ($lang) {
            case 'en':
                $this->ttlDaftar = "New User";
                $this->ttlComp = "New User";
                $this->lblFullName = "Full Name";
                $this->lblIdentityNo = "MyKad / Passport / Police No. / MyTentera";
                $this->lblEmail = "Email";
                $this->lblMobile = "Handphone Number";
                $this->lblOffice = "Office Phone Number";
                $this->lblRegisterPurpose = "Registration purpose";
                $this->lblOfficial = "Official";
                $this->lblThirdParty = "Third Party";
                $this->lblDesignation = "Designation";
                $this->lblAgency = "Agency";
                $this->lblBranch = "Branch";
                $this->lblDivision = "Division";
                $this->lblUnit = "Unit";
                $this->lblSubUnit = "Sub Unit";
                $this->trdParty = "Third Party";
                $this->lblContractor = "Contractor";
                $this->lblCitizen = "Citizen";
                $this->lblDaftar = "Register";
                $this->lblReset = "Reset";
                $this->lblLogin = "Log In";
                $this->lblTerma = "Terms";
                $this->lblSyarat = "Conditions";
                $this->lblCompName = "Company Name";
                $this->lblSSM = "SSM No";
                $this->lblProject = "Current Project Name";
                $this->lblGovern = "Government";
                break;

            default:
                $this->ttlDaftar = "Pengguna Baharu";
                $this->ttlComp = "Pengguna Baharu";
                $this->lblFullName = "Nama Penuh";
                $this->lblIdentityNo = "MyKad / Pasport / No. Polis / MyTentera";
                $this->lblEmail = "Emel";
                $this->lblMobile = "Tel Bimbit";
                $this->lblOffice = "Tel Pejabat";
                $this->lblRegisterPurpose = "Tujuan Mendaftar";

                $this->lblJKR = "JKR";
                $this->lblGoverAgency = "Agensi Kerajaan (Selain JKR)";
                $this->lblContractor = "Kontraktor";
                $this->lblPublic = "Orang Awam";
                $this->lblOwnership = "Pemilikan";

                $this->lblDesignation = "Jawatan";
                $this->lblAgency = "Agensi";
                $this->lblBranch = "Cawangan";
                $this->lblDivision = "Bahagian";
                $this->lblUnit = "Unit";
                $this->lblSubUnit = "Sub Unit";
                $this->trdParty = "Pihak Ketiga";
                $this->lblContractor = "Kontraktor";
                $this->lblCitizen = "Orang Awam";
                $this->lblDaftar = "Daftar";
                $this->lblReset = "Set Semula";
                $this->lblLogin = "Log Masuk";
                $this->lblTerma = "Terma";
                $this->lblSyarat = "Syarat";
                $this->lblCompName = "Nama Syarikat";
                $this->lblSSM = "No SSM";
                $this->lblProject = "Nama Projek Terkini";
                $this->lblGovern = "Kementerian";
                break;
        }
    }

    public function getOwnerBranch() {
        Log::info('$this->owner_type_id --> '.$this->owner_type_id);
        $refOwnerType = RefOwnerType::find($this->owner_type_id);

        Log::info($refOwnerType);

        $this->lblBranch = $refOwnerType['desc_'.$this->lang];
        if($refOwnerType->code == '01'){
            $this->lblBranch = $this->lang == 'en' ? 'Branch' : 'Cawangan';
        } else if($refOwnerType->code == '02'){
            $this->lblBranch = $this->lang == 'en' ? 'State' : 'Negeri';
        }

        $this->owner_branch_list = RefOwner::where('owner_type_id', $this->owner_type_id)->get();

    }

    public function getBranch() {
        $this->branch_id = null;
        $this->branch = RefBranch::orderBy('desc', 'asc');
        $this->branch = RefBranch::where('agency_id', $this->agency_id);
        Log::info($this->branch->toSql());
        $this->branch = $this->branch->get();
        Log::info($this->branch);
        $this->initSelect2();
    }

    public function getDivision() {
        $this->division_id = null;
        $this->division = RefDivision::orderBy('desc', 'asc');
        $this->division = RefDivision::where('branch_id', $this->branch_id);
        $this->division = $this->division->get();
        $this->initSelect2();
    }

    public function getUnit() {
        $this->unit_id = null;
        $this->unit = RefUnit::where('division_id', $this->division_id);
        $this->unit = $this->unit->get();
        $this->initSelect2();
    }

    public function getUnitSub() {
        $this->unit_sub_id = null;
        $this->unit_sub = RefUnitSub::where('unit_id', $this->unit_id);
        $this->unit_sub = $this->unit_sub->get();
        $this->initSelect2();
    }

    public function initSelect2(){
        Log::info('init :: initSelect2');
        $this->emit('initSelect2', true);
    }

    function reloadCapcha(){
        $this->emit('reloadCaptcha', true);
        return captcha_src('capcha');
    }

    public function save()
    {

        Log::info('designation --> '.$this->designation);

        $register = new RegisterRepository();
        // error_log('message here.');

        Log::info('branch_id => '.$this->branch_id);

        $this->rules = [
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email|unique:App\Models\User,email',
            'identityNo' => 'required',

            // 'identityNo' => 'required|regex:/^\d{6}-\d{2}-\d{4}$/',
            'phone' => 'required|numeric',
            'office'=> 'sometimes|present',
            'registerPurpose' => 'required',
            'owner_type_id' => 'required_if:registerPurpose,is_jkr',
            'designation' => 'required_if:registerPurpose,is_jkr,is_gover_agency',
            'branch_id' => 'required_if:registerPurpose,is_jkr',
            'agency_id' => 'required_if:registerPurpose,is_gover_agency',

            'companyName' => 'required_if:registerPurpose,is_contractor',
            'ssm_no' => 'required_if:registerPurpose,is_contractor',
            'latest_project_name' => 'required_if:registerPurpose,is_contractor',
            'companyKem' => 'required_if:registerPurpose,is_contractor',
            'code' => 'required'
        ];

        $this->messages = [
            'name.required' => $this->lang == 'bm' ? 'Sila masukkan nama anda' : 'Please enter your name',
            'name.regex' => $this->lang == 'bm' ? 'Sila masukkan nama anda hanya dalam huruf' : 'Please enter your name in letters only',
            'email.required' => $this->lang == 'bm' ? 'Sila masukkan emel anda' : 'Please enter your email',
            'email.email' => $this->lang == 'bm' ? 'Sila masukkan format emel yang betul' : 'Please enter the correct email format',
            'email.unique' => $this->lang == 'bm' ? 'Emel ini telah digunakan' : 'This email has already been used',
            'identityNo.required' => $this->lang == 'bm' ? 'Sila masukkan no MyKad / Pasport / MyTentera anda' : 'Please enter your MyKad / Passport / MyTentera number',
            // 'identityNo.regex' => $this->lang == 'bm' ? 'Sila masukkan format no MyKad yang betul' : 'Please enter the correct MyKad number format',
            'phone.required' => $this->lang == 'bm' ? 'Sila masukkan no telefon bimbit anda' : 'Please enter your mobile phone number',
            'phone.numeric' => $this->lang == 'bm' ? 'Sila masukkan nombor sahaja' : 'Please enter a number only',
            'registerPurpose.required' =>$this->lang == 'bm' ? 'Sila masukkan pilih tujuan mendaftar' : 'Please select the purpose of registering',

            'gover.in' => $this->lang == 'bm' ? 'Sila pilih tujuan mendaftar' : 'Please select the purpose of registering',
            'jkr.required_if' => $this->lang == 'bm' ? 'Sila pilih kategori pihak anda' : 'Please select your party category',
            'designation.required_if' => $this->lang == 'bm' ? 'Sila masukkan jawatan anda' : 'Please enter your designation',
            'owner_type_id.required_if' => $this->lang == 'bm' ? 'Sila Pilih Pemilikan' : 'Please Select Ownership',
            'agency_id.required_if' => $this->lang == 'bm' ? 'Sila pilih sektor' : 'Please select a sector',
            'branch_id.required_if' => $this->lang == 'bm' ? 'Sila pilih cawangan' : 'Sila pilih cawangan',
            'companyName.required_if' => $this->lang == 'bm' ? 'Sila masukkan nama syarikat anda' : 'Please enter your company name',
            'ssm_no.required_if' => $this->lang == 'bm' ? 'Sila masukkan no ssm syarikat anda' : 'Please enter your company\'\s ssm number',
            'latest_project_name.required_if' => $this->lang == 'bm' ? 'Sila masukkan nama projek terkini anda' : 'Please enter your current project name',
            'companyKem.required_if' => $this->lang == 'bm' ? 'Sila pilih kementerian' : 'Please select a ministry',
            'code.required' => $this->lang == 'bm' ? 'Sila Masukkan Captcha' : 'Please Enter Captcha'
        ];

        $this->registerPurposeChanged();

        $this->validate();

        Log::info($this->code);

        if(captcha_check($this->code)){
            $this->captcha_verified = true;
            $this->err = false;
            $this->response = '';
            $this->emit('captchaIsValid', true);
        } else {
            $this->captcha_verified = false;
            $this->err = true;
            $this->response = 'Invalid Captcha';
            $this->emit('reloadCaptcha', true);
        }

        Log::info('xle[as');
        Log::info($this->captcha_verified);
        Log::info($this->branch_id);

        if($this->captcha_verified){

            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'identity' => $this->identity,
                'identityNo' => $this->identityNo,
                'office' => $this->office,
                'phone' => $this->phone,
                'registerPurpose' => $this->registerPurpose,
                'owner_type_id' => $this->owner_type_id,
                'agency_id' => $this->agency_id,
                'designation' => $this->designation,
                'division_id' => $this->division_id,
                'division_desc' => $this->division_desc,
                'branch_id' => $this->branch_id,
                'unit' => $this->unit,
                'cawangan' => $this->branch,
                'company_name' => $this->companyName,
                'ssm_no' => $this->ssm_no,
                'latest_project_name' => $this->latest_project_name,
                'company_kem' => $this->companyKem
            ];

            Log::info($data);

            $reg = $register->register($data);

            if($reg['status'] == 200)
            {
                return redirect()->route('.success');
            }
        }
    }

    public function UpdateLabel()
    {
        if(!empty($this->identity))
        {
            foreach($this->identities as $id){

                if($this->identity == $id->id)
                {
                    $this->idLabel = $id->type;
                }
            }

        }
    }

    public function render()
    {
        return view('livewire.auth.daftar');
    }
}
