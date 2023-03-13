<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use App\Models\Assessment\AssessmentAccidentVehicle;
use App\Models\Assessment\AssessmentCurrvalueVehicle;
use App\Models\Assessment\AssessmentDisposalVehicle;
use App\Models\Assessment\AssessmentGovLoanVehicle;
use App\Models\Assessment\AssessmentSafetyVehicle;
use App\Models\Assessment\AssessmentType;
use App\Models\Fleet\FleetLookupVehicle;
use Illuminate\Support\Facades\Log;

class HelpersFunction extends Controller
{
    public function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
    }

    public function getAlpha($num){
        $alpha = null;
        $count = 0;
        for($letter = 'A'; $letter <= 'Z'; $letter++){
            if($count == $num){
                $alpha = $letter;
                break;
            }
            $count = $count + 1;
        }
        return $alpha;
    }

    public function checkingVehicleInAssessment($plate_no, $assessment_type){

        $disposal = AssessmentDisposalVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $safety = AssessmentSafetyVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $accident = AssessmentAccidentVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $currvalue = AssessmentCurrvalueVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $gov_loan = AssessmentGovLoanVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $checkingVehicleInAssessment = $gov_loan
                    ->union($currvalue)
                    ->union($accident)
                    ->union($safety)
                    ->union($disposal)
                    ->get();

        Log::info('checking union all vehicle in assesment');
        Log::info($checkingVehicleInAssessment);

        return $checkingVehicleInAssessment;

    }

    public function checkingVehicleEverEvaluated($plate_no, $assessment_type){

        $disposal = AssessmentDisposalVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $safety = AssessmentSafetyVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $accident = AssessmentAccidentVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $currvalue = AssessmentCurrvalueVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $gov_loan = AssessmentGovLoanVehicle::select('plate_no', 'engine_no', 'chasis_no', 'vehicle_brand_id', 'model_name', 'manufacture_year', 'registration_vehicle_dt',
                                                    'category_id', 'sub_category_id', 'sub_category_type_id')
                                            ->whereHas('hasAssessmentVehicleStatus', function($q){
                                                $q->whereNotIn('code', ['00']);
                                                })->whereHas('hasAssessmentDetail.hasStatus', function($q1){
                                                    $q1->whereIn('code', ['01','02', '03', '04', '05']);
                                            })->where('plate_no', $plate_no);
        $checkingVehicleEverEvaluated = $gov_loan
                    ->union($currvalue)
                    ->union($accident)
                    ->union($safety)
                    ->union($disposal)
                    ->get();

        Log::info('checking union all vehicle ever evaluated');
        Log::info($checkingVehicleEverEvaluated);

        return $checkingVehicleEverEvaluated;

    }

    public function getExistedRegPlateNo($assessment_type){
        switch ($assessment_type) {
            case 'value':
                # code...
                break;

            default:
                # code...
                break;
        }
    }

    public function findPlateNoAndUpdateSafetyDt($plate_no, $dt){
        $existed = FleetLookupVehicle::where('table_type', 'department')
            ->whereRaw("TRIM(UPPER(no_pendaftaran)) = '".trim(strtoupper($plate_no))."'")
            ->first();

        Log::info($existed);

        if($existed){
            $existed->hasMoreDetail->update([
                'tarikh_pemeriksaan_keselamatan' => $dt,
            ]);
        }
    }
}
