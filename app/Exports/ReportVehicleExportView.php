<?php

namespace App\Exports;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Http\Controllers\Report\ReportVehicleDAO;
use App\Http\Controllers\Vehicle\VehicleDAO;
use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportVehicleExportView implements FromView, WithEvents, WithStyles, ShouldAutoSize, WithColumnWidths
{

    public function __construct(Request $request)
    {
        $this->total_row = 0;
        $this->footer = 0;
        $this->view = $request->view;
        $this->request = $request;
        $this->search = $request->search;
        $this->xid = $request->xid;
    }

    public function view(): View
    {
        $ReportVehicleDAO = new ReportVehicleDAO();
        $VehicleDAO = new VehicleDAO();
        Log::info($this->view);
        if (ob_get_contents()) {ob_end_clean();}
        switch ($this->view) {
            case 'report_vehicle_list':
                ini_set('max_execution_time', 180);
                Log::info('ini_get("max_execution_time") '.ini_get("max_execution_time"));
                $status = $this->request->status ? $this->request->status: 'approved';
                $listFleets = $VehicleDAO->getTotalVehicle($status,$this->search,$this->request->fleet_view,$this->request->offset,$this->request->limit, $this->xid, $this->request->ownerType, $this->request);
                $obj = [
                    'listFleets' => $listFleets,
                ];
                return view('vehicle.vehicle-list-alternate_excel', $obj);
                break;
            case 'report_vehicle_jkr_workshop':
                $obj = $ReportVehicleDAO->reportVehicleByWorkshop();
                return view('report.report_vehicle_jkr_by_workshop_excel', $obj);
                break;
            case 'report_vehicle_jkr_workshop_ownership':
                $obj = $ReportVehicleDAO->reportVehicleByWorkshopOwnership();
                return view('report.report_vehicle_jkr_by_workshop_ownership_excel', $obj);
                break;

            case 'report_vehicle_jkr_cat_type':
                $obj = $ReportVehicleDAO->reportVehicleByCatType($this->request);
                return view('report.report_vehicle_jkr_by_cat_type_excel', $obj);
                break;

            default:
                return [];
                break;
        }

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                switch ($this->view) {

                    case 'report_vehicle_list':

                        $event->sheet->getDelegate()->getStyle('A:V')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:V')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:V')->getAlignment()->setWrapText(true);
                    break;

                    case 'report_vehicle_jkr_workshop':

                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setWrapText(true);
                    break;

                    case 'report_vehicle_jkr_workshop_ownership':

                        $event->sheet->getDelegate()->getStyle('A:I')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:I')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:I')->getAlignment()->setWrapText(true);
                    break;


                    default:
                        # code...
                        break;
                }

            }
        ];

    }

    public function styles(Worksheet $sheet)
    {

        switch ($this->view) {
            case 'report_summons_jkr_branch':

                return [
                    // // Style the first row as bold text.
                ];
            break;

        }

    }

    public function columnWidths(): array
    {
        $list = [];
        $HelpersFunction = new HelpersFunction();
        for ($i=2; $i < 10; $i++) {
            $list[$HelpersFunction->getAlpha($i)] = 15;
        }

        Log::info($list);
        return $list;
    }
}
