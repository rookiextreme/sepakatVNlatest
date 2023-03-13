<?php

namespace App\Exports;

use App\Http\Controllers\Assessment\AssessmentDAO;
use App\Http\Controllers\Helpers\HelpersFunction;
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

class ReportAssessmentExportView implements FromView, WithEvents, WithStyles, ShouldAutoSize, WithColumnWidths
{

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->view = $request->view;
    }

    public function view(): View
    {
        if (ob_get_contents()) {ob_end_clean();}
        $AssessmentDAO = new AssessmentDAO();
        switch ($this->view) {
            case 'report_assessment_examination':
                $obj = $AssessmentDAO->reportOverall($this->request);
                return view('assessment.assessment-report-overall-excel', $obj);
                break;
            case 'report_assessment_agency_month':
                $obj = $AssessmentDAO->reportAgencyByMonth($this->request);
                return view('assessment.assessment-report-agency-month-excel', $obj);
                break;
            case 'report_assessment_branch_month':
                $obj = $AssessmentDAO->reportBranchByMonth($this->request);
                return view('assessment.assessment-report-branch-month-excel', $obj);
                break;
            case 'report_assessment_branch_year':
                $obj = $AssessmentDAO->reportBranchByYear($this->request);
                return view('assessment.assessment-report-branch-year-excel', $obj);
                break;

            case 'report_assessment_placement_state_assessment':
                $obj = $AssessmentDAO->reportPlacementStateByAssessment($this->request);
                return view('assessment.assessment-report-placement-state-assessment-excel', $obj);
                break;

            case 'report_vtl_cwgn':
                $obj = $AssessmentDAO->reportVtlCgwnExcel($this->request);
                return view('assessment.assessment-report-vtl-cgwn-assessment-excel', $obj);
                break;

            case 'report_vtl_ckmn':
                $obj = $AssessmentDAO->reportVtlCkmnExcel($this->request);
                return view('assessment.assessment-report-vtl-ckwn-assessment-excel', $obj);
                break;
        }

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                switch ($this->view) {

                    case 'report_assessment_examination':

                        $styleTitle = array(
                            'font'  => array(
                                'bold'  => true,
                                // 'color' => array('rgb' => 'black'),
                                'size'  => 20,
                                'name'  => 'Arial'
                            ),
                            'alignment' => array(
                                'indent' => 1
                            )
                        );

                        $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleTitle);
                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setWrapText(true);
                    break;

                    case 'report_assessment_agency_month':

                        $styleTitle = array(
                            'font'  => array(
                                'bold'  => true,
                                // 'color' => array('rgb' => 'black'),
                                'size'  => 20,
                                'name'  => 'Arial'
                            ),
                            'alignment' => array(
                                'indent' => 1
                            )
                        );

                        $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleTitle);
                        $event->sheet->getDelegate()->getStyle('A:O')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:O')->getAlignment()->setWrapText(true);
                    break;

                    case 'report_assessment_branch_month':

                        $styleTitle = array(
                            'font'  => array(
                                'bold'  => true,
                                // 'color' => array('rgb' => 'black'),
                                'size'  => 20,
                                'name'  => 'Arial'
                            ),
                            'alignment' => array(
                                'indent' => 1
                            )
                        );

                        $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleTitle);
                        $event->sheet->getDelegate()->getStyle('A:O')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:O')->getAlignment()->setWrapText(true);
                    break;
                    case 'report_assessment_branch_year':

                        $styleTitle = array(
                            'font'  => array(
                                'bold'  => true,
                                // 'color' => array('rgb' => 'black'),
                                'size'  => 20,
                                'name'  => 'Arial'
                            ),
                            'alignment' => array(
                                'indent' => 1
                            )
                        );

                        $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleTitle);
                        $event->sheet->getDelegate()->getStyle('B:O')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:O')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('B:O')->getAlignment()->setWrapText(true);
                    break;

                    case 'report_assessment_placement_state_assessment':

                        $styleTitle = array(
                            'font'  => array(
                                'bold'  => true,
                                // 'color' => array('rgb' => 'black'),
                                'size'  => 15,
                                'name'  => 'Arial'
                            ),
                            'alignment' => array(
                                'indent' => 1,
                                'wrapText' => true,
                                'vertical' => 'center',
                                'horizontal' => 'center'
                            )
                        );

                        $event->sheet->getDelegate()->getStyle('A1')->applyFromArray($styleTitle);
                        $event->sheet->getDelegate()->getStyle('A:E')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:E')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('B:E')->getAlignment()->setWrapText(true);
                    break;
                }

            }
        ];

    }

    public function styles(Worksheet $sheet)
    {

        switch ($this->view) {
            case 'report_assessment_examination':

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

        switch ($this->view) {
            case 'report_summons_jkr_branch':
                for ($i=2; $i < 10; $i++) {
                    $list[$HelpersFunction->getAlpha($i)] = 15;
                }
            break;

            case 'report_assessment_agency_month':
                for ($i=2; $i < 15; $i++) {
                    $list[$HelpersFunction->getAlpha($i)] = 10;
                }
                break;
            break;

            case 'report_assessment_branch_month':
                for ($i=2; $i < 15; $i++) {
                    $list[$HelpersFunction->getAlpha($i)] = 10;
                }
                break;
            break;
            case 'report_assessment_branch_year':
                for ($i=2; $i < 15; $i++) {
                    $list[$HelpersFunction->getAlpha($i)] = 10;
                }
                break;
            break;

            case 'report_assessment_placement_state_assessment':
                for ($i=2; $i < 15; $i++) {
                    $list[$HelpersFunction->getAlpha($i)] = 20;
                }
                break;
            break;

        }

        return $list;
    }
}
