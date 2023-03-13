<?php

namespace App\Http\Livewire\Vehicle;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Location\Negeri;
use App\Models\Location\Cawangan;
use App\Models\Location\Daerah;
use App\Models\Kenderaan\Kategori\Kategori;
use App\Models\Kenderaan\Kategori\SubKategori;
use App\Models\Vehicle\Brand;
use App\Models\Vehicle\VehicleModel;
use App\Models\Kenderaan\Pendaftaran;
use App\Models\Kenderaan\Dokumen;
use App\Models\Location\Placement;
use App\Models\RefCategory;
use App\Models\RefSubCategory;
use App\Models\RefSubCategoryType;
use App\Repositories\Kenderaan\PendafaranRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleRegister extends Component
{
    use WithFileUploads;

    public $isEdit = false;
    public $is_display = false;
    public $currentId = -1;
    public $negeris;
    public $cawangan;
    public $placement_list;
    public $daerah;
    public $location;
    public $categoryList;
    public $subCategoryList;
    public $subCategoryTypeList;
    public $brands;
    public $models;
    public $image;
    public $doc_id = -1;

    public $reg;
    public $maklumat;
    public $tambahan;
    public $kenderaan;
    public $documents;

    public $succes;

    public $fails;
    public $photo;

    protected $regrepo;
    public $tab = 'pendaftaran';

    protected $rules = [];
    protected $message = [];
    protected $listeners = [];

    public function mount(Request $request)
    {
        if($request->input('success')){
            $this->succes = $request->input('success');
        }

        if($request->input('currentTab')){
            $this->tab = request('currentTab');
        }
        Log::info('$this->tab  --> '.$this->tab);

        $this->is_display = $request->input('is_display');
        $checkCurrentData = Pendaftaran::where('id', $request->id)->first();

        if(!empty($checkCurrentData)){
            $this -> isEdit = true;
            $this-> currentId = $checkCurrentData-> id;
        }

        Log::info($this -> isEdit);

        $this->negeris = Negeri::all();
        $this->cawangan = Cawangan::all();
        $this->placement_list = FleetPlacement::all();
        $this->daerah = Daerah::all();
        $this->categoryList = RefCategory::all();

        $this->kategori = Kategori::all();
        $this->subKategori = SubKategori::all();
        $this->brands = Brand::all();
        $this->models = VehicleModel::all();


        $this->load();
    }

    public function changeCategory()
    {
        Log::info('masuk --> changeCategory');
        $this->subCategoryList = RefSubCategory::where('category_id', $this->maklumat['category_id'])->get();
    }

    public function changeSubCategory()
    {
        Log::info('masuk --> changeSubCategory');
        Log::info($this->maklumat['sub_category_id']);
        $this->subCategoryTypeList = RefSubCategoryType::where('sub_category_id', $this->maklumat['sub_category_id'])->get();

        Log::info($this->subCategoryTypeList);
    }

    public function updateDate($field, $value){
        Log::info('field '.$field. ' value --> '.$value);
    }

    public function repo()
    {
        return new PendafaranRepository();
    }

    public function pendaftaran()
    {

        //Trigger auto save
        $data = [
            'state_id' => isset($this->reg['negeri']) ? $this->reg['negeri'] : '',
            'cawangan_id' => isset($this->reg['cawangan']) ? $this->reg['cawangan'] : '',
            'hak_milik' => isset($this->reg['hak']) ? $this->reg['hak'] : '',
            'daerah_id' => isset($this->reg['lokasi']) ? $this->reg['lokasi'] : '',
            'no_pendaftaran' => isset($this->reg['no']) ? $this->reg['no'] : '',
            'no_id_pemunya' => isset($this->reg['noid']) ? $this->reg['noid'] : '',
            'no_jkr' => isset($this->reg['jkr']) ? $this->reg['jkr'] : '',
        ];

        if($this -> isEdit){
            $response = $this->repo()->updateData($data, $this->currentId);
            return redirect()->route('vehicle.register', ['id' => $this->currentId]);
        } else {
            $response = $this->repo()->pendaftaran($data);
            return redirect()->route('vehicle.register', ['id' => $response['pendaftaran_id']]);
        }

    }

    public function kenderaan()
    {
       $data = [
            'pendaftaran_id' => isset($this->reg['id']) ? $this->reg['id'] : '',
            'category_id' => isset($this->maklumat['category_id']) ? $this->maklumat['category_id'] : '',
            'sub_category_id' => isset($this->maklumat['sub_category_id']) ? $this->maklumat['sub_category_id'] : '',
            'brand_id' => isset($this->maklumat['pembuat']) ? $this->maklumat['pembuat'] : '',
            'model_id' => isset($this->maklumat['model']) ? $this->maklumat['model'] : '',
            'no_chasis' => isset($this->maklumat['chasis']) ? $this->maklumat['chasis'] : '',
            'no_engine' => isset($this->maklumat['engine']) ? $this->maklumat['engine'] : '',
            'status' => isset($this->maklumat['vehicle']) ? $this->maklumat['vehicle'] : '',
            'tarikh_belian' => isset($this->maklumat['tarikhbelian']) ? $this->maklumat['tarikhbelian'] : null,
            'no_resit' => isset($this->maklumat['noresit']) ? $this->maklumat['noresit'] : '',
            'pembeli' => isset($this->maklumat['penerima']) ? $this->maklumat['penerima'] : '',
       ];

       $photo = $this->photo;
        if($photo != null){

            $path = "public/vehicle/dokumen/".$this->reg['id'];
            $fileName = Str::random(9).'.'.$photo->getClientOriginalExtension();
            $photo->storeAs($path, $fileName);

            $path = "dokumen/".$this->reg['id'];
            $data['kenderaan'] = [
                'doc_path' => $path,
                'doc_type' => 'gambarKenderaan',
                'doc_name' => $fileName
            ];
            $this->photo = null;
        }

       $response = $this->repo()->kenderaan($data);

       return redirect()->route('vehicle.register', [
           'id' => $this->currentId,
           'is_display' => $this->is_display,
           'currentTab' => 'maklumat',
            'success' => $response['message']
           ]);

    }

    public function tambahan()
    {
        $this->rules = [
            'tambahan.cukaiJalan' => 'required'
        ];

        $this->messages = [
            'tambahan.cukaiJalan.required' => 'Sila Masukkan Tarikh Cukai Jalan'
        ];

        $this->validate();
        $data = [
            'pendaftaran_id' => isset($this->reg['id']) ? $this->reg['id'] : '',
            'no_id_pemunya' => isset($this->tambahan['idJabatan']) ? $this->tambahan['idJabatan'] : '',
            'no_jkr' => isset($this->tambahan['noJkr']) ? $this->tambahan['noJkr'] : '',
            'no_loji' => isset($this->tambahan['noLoji']) ? $this->tambahan['noLoji'] : '',
            'tarikh_cukai_jalan'  => isset($this->tambahan['cukaiJalan']) ? $this->tambahan['cukaiJalan'] : '',
            'harga_perolehan' => isset($this->tambahan['hargaPerolehan']) ? $this->tambahan['hargaPerolehan'] : '',
            'tarikh_pembelian_kenderaan' => isset($this->tambahan['tarikhPembelian']) ? $this->tambahan['tarikhPembelian'] : '',
            'no_lo' => isset($this->tambahan['noLo']) ? $this->tambahan['noLo'] : '',
            'tarikh_pemeriksaan_fizikal' => isset($this->tambahan['pemeriksaanFizikal']) ? $this->tambahan['pemeriksaanFizikal'] : '',
            'tarikh_pemeriksaan_keselamatan' => isset($this->tambahan['pemeriksaanKeselamatan']) ? $this->tambahan['pemeriksaanKeselamatan'] : '',
            // 'tarikh_kemaskini' => isset($this->tambahan['kemaskini']) ? $this->tambahan['kemaskini'] : '',
            'tarikh_kemaskini' => Carbon::now()->format('y-m-d'),
            // 'kemaskini_oleh' => isset($this->tambahan['kemaskiniOleh']) ? $this->tambahan['kemaskiniOleh'] : ''
        ];

        Log::info($data);

        $response = $this->repo()->tambahan($data, $this -> isEdit, $this->currentId);

        $this->succes = $response['message'];

    }

    public function load()
    {
        if(!empty(request('id')))
        {
            $pe = Pendaftaran::find(request('id'));

            Log::info('State Name : '. $pe->negeri->negeri);
            Log::info('Branch Name : '.$pe->negeri->negeri);

            $this->reg = [
                'id' => isset($pe->id) ? $pe->id : '',
                'negeri' => isset($pe->state_id) ? $pe->state_id : '',
                'stateName' => isset($pe->negeri->negeri) ? $pe->negeri->negeri : '',
                'cawangan' => isset($pe->cawangan_id) ? $pe->cawangan_id : '',
                'branchName' => isset($pe->cawangan->cawangan) ? $pe->cawangan->cawangan : '',
                'hak' => isset($pe->hak_milik) ? $pe->hak_milik : '',
                'lokasi'=> isset($pe->daerah_id) ? $pe->daerah_id : '',
                'locationName' => isset($pe->daerah->daerah) ? $pe->daerah->daerah : '',
                'no' => isset($pe->no_pendaftaran) ? $pe->no_pendaftaran : '',
                'noid' => isset($pe->no_id_pemunya) ? $pe->no_id_pemunya : '',
                'jkr' => isset($pe->no_jkr) ? $pe->no_jkr : '',
            ];

            if(!empty($pe->maklumat))
            {
                Log::info($pe->maklumat->category_id);
                Log::info($pe->maklumat->sub_category_id);
                Log::info($pe->maklumat->brand);

                $this->maklumat = [
                    'category_id' => isset($pe->maklumat->category_id) ? $pe->maklumat->category_id : null,
                    'categoryMame' => isset($pe->maklumat->kategori->name) ? $pe->maklumat->kategori->name: null,
                    'sub_category_id' => isset($pe->maklumat->sub_category_id) ? $pe->maklumat->sub_category_id: null,
                    'subCategoryMame' => isset($pe->maklumat->subKategori->sub_kategori) ? $pe->maklumat->subKategori->sub_kategori: null,
                    'pembuat' => isset($pe->maklumat->brand_id) ? $pe->maklumat->brand_id : null,
                    'brandName' => isset($pe->maklumat->brand->name) ?  $pe->maklumat->brand->name : null,
                    'model' => isset($pe->maklumat->model_id) ? $pe->maklumat->model_id : null,
                    'modelName' => isset($pe->maklumat->brandModel->model) ? $pe->maklumat->brandModel->model : null,
                    'chasis' => isset($pe->maklumat->no_chasis) ? $pe->maklumat->no_chasis : null,
                    'engine' => isset($pe->maklumat->no_engine) ? $pe->maklumat->no_engine : null,
                    'vehicle' => isset($pe->maklumat->status) ? $pe->maklumat->status : null,
                    'tarikhbelian' => isset($pe->maklumat->tarikh_belian) ? $pe->maklumat->tarikh_belian : null,
                    'noresit' => isset($pe->maklumat->no_resit) ? $pe->maklumat->no_resit : null,
                    'penerima' => isset($pe->maklumat->pembeli) ? $pe->maklumat->pembeli : null
                ];
            }

            if(!empty($pe->maklumatTambahan))
            {
                $this->tambahan = [
                    'idJabatan' => isset($pe->maklumatTambahan->no_id_pemunya ) ? $pe->maklumatTambahan->no_id_pemunya : null,
                    'noJkr' => isset($pe->maklumatTambahan->no_jkr) ? $pe->maklumatTambahan->no_jkr : null,
                    'noLoji' => isset($pe->maklumatTambahan->no_loji) ? $pe->maklumatTambahan->no_loji : null,
                    'cukaiJalan' => isset($pe->maklumatTambahan->tarikh_cukai_jalan) ? $pe->maklumatTambahan->tarikh_cukai_jalan : null,
                    'hargaPerolehan' => isset($pe->maklumatTambahan->harga_perolehan) ? $pe->maklumatTambahan->harga_perolehan : null,
                    'tarikhPembelian'=>  isset($pe->maklumatTambahan->tarikh_pembelian_kenderaan) ? $pe->maklumatTambahan->tarikh_pembelian_kenderaan : null,
                    'noLo' => isset($pe->maklumatTambahan->no_lo) ? $pe->maklumatTambahan->no_lo : null,
                    'pemeriksaanFizikal'=> isset($pe->maklumatTambahan->tarikh_pemeriksaan_fizikal) ? $pe->maklumatTambahan->tarikh_pemeriksaan_fizikal : null,
                    'pemeriksaanKeselamatan' => isset($pe->maklumatTambahan->tarikh_pemeriksaan_keselamatan) ? $pe->maklumatTambahan->tarikh_pemeriksaan_keselamatan : null,
                    'kemaskini' => isset($pe->maklumatTambahan->tarikh_kemaskini) ? $pe->maklumatTambahan->tarikh_kemaskini : null,
                    'kemaskiniOleh'=> isset($pe->maklumatTambahan->kemaskini_oleh) ? $pe->maklumatTambahan->kemaskini_oleh : null,
                ];
            }

            if(!empty($pe->dokumen))
            {
                Log::info($pe->dokumen);
                $this->documents = $pe->dokumen;
            }
        }
    }

    public function dokumen()
    {

        $path = "public/vehicle/dokumen/".$this->reg['id'];


        if($this->maklumat['vehicle'] == 'lupus')
        {

            $kewpa13Count = isset($fails['kewpa13']) ? count($fails['kewpa13']) : 0;
            $kewpa23Count = isset($fails['kewpa23']) ? count($fails['kewpa23']) : 0;
            $suratPermohonanCount = isset($fails['suratPermohonan']) ? count($fails['suratPermohonan']) : 0;
            $resitJualanCount = isset($fails['resitJualan']) ? count($fails['resitJualan']) : 0;

            $data = ['pendaftaran_id' => $this->reg['id']];

            // Store file information
            $path = "dokumen/".$this->reg['id'];

            if($kewpa13Count>0){
                $kewpa13 = $this->fails['kewpa13'];
                $kewpa13->storeAs($path, $kewpa13->getClientOriginalName());
                array_push($data,
                    [
                        'kewpa13' => [
                            'doc_path' => $path,
                            'doc_type' => 'kewpa13',
                            'doc_name' => $kewpa13->getClientOriginalName()
                        ]
                    ]
                );
            }

            if($kewpa23Count>0){
                $kewpa23 = $this->fails['kewpa23'];
                $kewpa23->storeAs($path, $kewpa23->getClientOriginalName());
                array_push($data,
                    [
                        'kewpa23' => [
                            'doc_path' => $path,
                            'doc_type' => 'kewpa23',
                            'doc_name' => $kewpa23->getClientOriginalName()
                        ]
                    ]
                );
            }

            if($suratPermohonanCount>0){
                $suratpemohonan = $this->fails['suratpemohonan'];
                $kewpa23->storeAs($path, $kewpa23->getClientOriginalName());
                array_push($data,
                    [
                        'suratpemohonan' => [
                            'doc_path' => $path,
                            'doc_type' => 'suratpemohonan',
                            'doc_name' => $suratpemohonan->getClientOriginalName()
                        ]
                    ]
                );
            }

            $kewpa13 = $this->fails['kewpa13'];
            $kewpa23 = $this->fails['kewpa23'];
            $suratPermohonan = $this->fails['suratpemohonan'];
            $resitJualan = $this->fails['resitjualan'];

            // Store file information
            $kewpa13->storeAs($path, $kewpa13->getClientOriginalName());
            $kewpa23->storeAs($path, $kewpa23->getClientOriginalName());
            $suratPermohonan->storeAs($path, $suratPermohonan->getClientOriginalName());
            $resitJualan->storeAs($path, $resitJualan->getClientOriginalName());

            $data = [
                'kewpa13' => [
                    'doc_path' => $path,
                    'doc_type' => 'kewpa13',
                    'doc_name' => $kewpa13->getClientOriginalName()
                ],

                'kewpa23' => [
                    'doc_path' => $path,
                    'doc_type' => 'kewpa23',
                    'doc_name' => $kewpa23->getClientOriginalName()
                ],

                'suratPermohonan' => [
                    'doc_path' => $path,
                    'doc_type' => 'suratPermohonan',
                    'doc_name' => $suratPermohonan->getClientOriginalName()
                ],

                'resitJualan' => [
                    'doc_path' => $path,
                    'doc_type' => 'resitJualan',
                    'doc_name' => $resitJualan->getClientOriginalName()
                ],

                'pendaftaran_id' => $this->reg['id'],

            ];

        }else{

            //file upload
            $kewpa3Count = isset($fails['kewpa3']) ? count($fails['kewpa3']) : 0;
            $geranCount = isset($fails['geran']) ? count($fails['geran']) : 0;

            $data = ['pendaftaran_id' => $this->reg['id']];

            // Store file information
            $path = "dokumen/".$this->reg['id'];

            if($kewpa3Count>0){
                $kewpa3 = $this->fails['kewpa3'];
                $kewpa3->storeAs($path, $kewpa3->getClientOriginalName());
                array_push($data,
                    [
                        'kewpa3' => [
                            'doc_path' => $path,
                            'doc_type' => 'kewpa3',
                            'doc_name' => $kewpa3->getClientOriginalName()
                        ]
                    ]
                );
            }

            if($geranCount>0){
                $geran = $this->fails['geran'];
                $geran->storeAs($path, $geran->getClientOriginalName());
                array_push($data,
                    [
                        'geran' => [
                            'doc_path' => $path,
                            'doc_type' => 'geranKenderaan',
                            'doc_name' => $geran->getClientOriginalName()
                        ]
                    ]
                );
            }

        }

        $response = $this->repo()->dokumen($data);

        Log::info($data);
        $this->succes = $response['message'];

    }

    public function render()
    {
        return view('livewire.vehicle.vehicle-register-old');
    }
}
