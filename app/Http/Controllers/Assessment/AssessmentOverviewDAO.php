<?php

namespace App\Http\Controllers\Assessment;

use App\Models\Assessment\AssessmentAccident;
use App\Models\Assessment\AssessmentCurrvalue;
use App\Models\Assessment\AssessmentDisposal;
use App\Models\Assessment\AssessmentNew;
use App\Models\Assessment\AssessmentSafety;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentOverviewDAO
{

    public function New(Request $request)
    {

        $TaskFlowAccessAssessmentNew = auth()->user()->vehicleWorkFlow('02', '01');
        $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

        if (in_array($roleAccessCode, ['01'])){
            $TotalAssessmentNew = AssessmentNew::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });
            $TotalAssessmentNew->where('created_by', Auth::user()->id);
        }

        // if (in_array($roleAccessCode, ['01'])){
        //     $TotalAssessmentNew = AssessmentNew::whereHas('hasVehicle')->get();
        // }

        if (in_array($roleAccessCode, ['02'])){
            $TotalAssessmentNew = AssessmentNew::whereHas('hasStatus', function($q){
                $q->where('code', '05');
            });
        }

        if (in_array($roleAccessCode, ['03'])){

            //pembantu Kemahiran
            if(auth()->user()->isForemenAssessment()){
                $TotalAssessmentNew = AssessmentNew::whereHas('hasStatus', function($q){
                    $q->where('code', '03');
                });
            } else if($TaskFlowAccessAssessmentNew->mod_fleet_appointment) {
                $TotalAssessmentNew = AssessmentNew::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01','02']);
                });
            } else {
                $TotalAssessmentNew = AssessmentNew::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
        }

        if (in_array($roleAccessCode, ['04'])){
            $TotalAssessmentNew = AssessmentNew::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });

            $TotalAssessmentNew->where('created_by', Auth::user()->id);
        }

        return $TotalAssessmentNew;

    }

    public function Safety(Request $request)
    {

        $TaskFlowAccessAssessmentSafety = auth()->user()->vehicleWorkFlow('02', '01');
        $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

        if (in_array($roleAccessCode, ['01'])){
            $TotalAssessmentSafety = AssessmentSafety::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });
            $TotalAssessmentSafety->where('created_by', Auth::user()->id);
        }

        // if (in_array($roleAccessCode, ['01'])){
        //     $TotalAssessmentNew = AssessmentNew::whereHas('hasVehicle')->get();
        // }

        if (in_array($roleAccessCode, ['02'])){
            $TotalAssessmentSafety = AssessmentSafety::whereHas('hasStatus', function($q){
                $q->where('code', '05');
            });
        }

        if (in_array($roleAccessCode, ['03'])){

            //pembantu Kemahiran
            if(auth()->user()->isForemenAssessment()){
                $TotalAssessmentSafety = AssessmentSafety::whereHas('hasStatus', function($q){
                    $q->where('code', '03');
                });
            } else if($TaskFlowAccessAssessmentSafety->mod_fleet_appointment) {
                $TotalAssessmentSafety = AssessmentSafety::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01','02']);
                });
            } else {
                $TotalAssessmentSafety = AssessmentSafety::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
        }

        if (in_array($roleAccessCode, ['04'])){
            $TotalAssessmentSafety = AssessmentSafety::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });

            $TotalAssessmentSafety->where('created_by', Auth::user()->id);
        }

        return $TotalAssessmentSafety;

    }

    public function Currvalue(Request $request)
    {

        $TaskFlowAccessAssessmentCurrvalue = auth()->user()->vehicleWorkFlow('02', '01');
        $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

        if (in_array($roleAccessCode, ['01'])){
            $TotalAssessmentCurrvalue = AssessmentCurrvalue::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });
            $TotalAssessmentCurrvalue->where('created_by', Auth::user()->id);
        }

        // if (in_array($roleAccessCode, ['01'])){
        //     $TotalAssessmentNew = AssessmentNew::whereHas('hasVehicle')->get();
        // }

        if (in_array($roleAccessCode, ['02'])){
            $TotalAssessmentCurrvalue = AssessmentCurrvalue::whereHas('hasStatus', function($q){
                $q->where('code', '05');
            });
        }

        if (in_array($roleAccessCode, ['03'])){

            //pembantu Kemahiran
            if(auth()->user()->isForemenAssessment()){
                $TotalAssessmentCurrvalue = AssessmentCurrvalue::whereHas('hasStatus', function($q){
                    $q->where('code', '03');
                });
            } else if($TaskFlowAccessAssessmentCurrvalue->mod_fleet_appointment) {
                $TotalAssessmentCurrvalue = AssessmentCurrvalue::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01','02']);
                });
            } else {
                $TotalAssessmentCurrvalue = AssessmentCurrvalue::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
        }

        if (in_array($roleAccessCode, ['04'])){
            $TotalAssessmentCurrvalue = AssessmentCurrvalue::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });

            $TotalAssessmentCurrvalue->where('created_by', Auth::user()->id);
        }

        return $TotalAssessmentCurrvalue;

    }

    public function Accident(Request $request)
    {

        $TaskFlowAccessAssessmentAccident = auth()->user()->vehicleWorkFlow('02', '01');
        $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

        if (in_array($roleAccessCode, ['01'])){
            $TotalAssessmentAccident = AssessmentAccident::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });
            $TotalAssessmentAccident->where('created_by', Auth::user()->id);
        }

        // if (in_array($roleAccessCode, ['01'])){
        //     $TotalAssessmentNew = AssessmentNew::whereHas('hasVehicle')->get();
        // }

        if (in_array($roleAccessCode, ['02'])){
            $TotalAssessmentAccident = AssessmentAccident::whereHas('hasStatus', function($q){
                $q->where('code', '05');
            });
        }

        if (in_array($roleAccessCode, ['03'])){

            //pembantu Kemahiran
            if(auth()->user()->isForemenAssessment()){
                $TotalAssessmentAccident = AssessmentAccident::whereHas('hasStatus', function($q){
                    $q->where('code', '03');
                });
            } else if($TaskFlowAccessAssessmentAccident->mod_fleet_appointment) {
                $TotalAssessmentAccident = AssessmentAccident::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01','02']);
                });
            } else {
                $TotalAssessmentAccident = AssessmentAccident::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
        }

        if (in_array($roleAccessCode, ['04'])){
            $TotalAssessmentAccident = AssessmentAccident::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });

            $TotalAssessmentAccident->where('created_by', Auth::user()->id);
        }

        return $TotalAssessmentAccident;

    }

    public function GovLoan(Request $request)
    {

        $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
        $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

        if (in_array($roleAccessCode, ['01'])){
            $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });
            $TotalAssessmentDisposal->where('created_by', Auth::user()->id);
        }

        // if (in_array($roleAccessCode, ['01'])){
        //     $TotalAssessmentNew = AssessmentNew::whereHas('hasVehicle')->get();
        // }

        if (in_array($roleAccessCode, ['02'])){
            $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                $q->where('code', '05');
            });
        }

        if (in_array($roleAccessCode, ['03'])){

            //pembantu Kemahiran
            if(auth()->user()->isForemenAssessment()){
                $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                    $q->where('code', '03');
                });
            } else if($TaskFlowAccessAssessmentDisposal->mod_fleet_appointment) {
                $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01','02']);
                });
            } else {
                $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
        }

        if (in_array($roleAccessCode, ['04'])){
            $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });

            $TotalAssessmentDisposal->where('created_by', Auth::user()->id);
        }

        return $TotalAssessmentDisposal;

    }

    public function Disposal(Request $request)
    {

        $TaskFlowAccessAssessmentDisposal = auth()->user()->vehicleWorkFlow('02', '01');
        $roleAccessCode = Auth()->user()->roleAccess() ? Auth()->user()->roleAccess()->code: null;

        if (in_array($roleAccessCode, ['01'])){
            $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });
            $TotalAssessmentDisposal->where('created_by', Auth::user()->id);
        }

        // if (in_array($roleAccessCode, ['01'])){
        //     $TotalAssessmentNew = AssessmentNew::whereHas('hasVehicle')->get();
        // }

        if (in_array($roleAccessCode, ['02'])){
            $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                $q->where('code', '05');
            });
        }

        if (in_array($roleAccessCode, ['03'])){

            //pembantu Kemahiran
            if(auth()->user()->isForemenAssessment()){
                $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                    $q->where('code', '03');
                });
            } else if($TaskFlowAccessAssessmentDisposal->mod_fleet_appointment) {
                $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['01','02']);
                });
            } else {
                $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                    $q->whereIn('code', ['05']);
                });
            }
        }

        if (in_array($roleAccessCode, ['04'])){
            $TotalAssessmentDisposal = AssessmentDisposal::whereHas('hasStatus', function($q){
                $q->whereIn('code', ['01','02','03','04','05','08']);
            });

            $TotalAssessmentDisposal->where('created_by', Auth::user()->id);
        }

        return $TotalAssessmentDisposal;

    }
}
