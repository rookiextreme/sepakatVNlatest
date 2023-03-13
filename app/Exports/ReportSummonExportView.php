<?php

namespace App\Exports;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Http\Controllers\Report\ReportSummonDAO;
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

class ReportSummonExportView implements FromView, WithEvents, WithStyles, ShouldAutoSize, WithColumnWidths
{

    public function __construct($view)
    {
        $this->total_row = 0;
        $this->footer = 0;
        $this->view = $view;
    }

    public function view(): View
    {
        $ReportSummonDAO = new ReportSummonDAO();
        Log::info($this->view);
        if (ob_get_contents()) {ob_end_clean();}
        switch ($this->view) {
            case 'report_summons_jkr_branch':
                $obj = $ReportSummonDAO->reportSummonByBranch();
                return view('report.report_summons_jkr_branch_excel', $obj);
                break;

            case 'report_summons_summary_branch':
                $obj = $ReportSummonDAO->reportSummonSummaryByBranch();
                return view('report.report_summons_summary_branch_excel', $obj);
                break;

            default:
                $obj = $ReportSummonDAO->reportSummonByBranch();
                return view('report.report_summons_jkr_branch_excel', $obj);
                break;
        }

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                switch ($this->view) {

                    case 'report_summons_jkr_branch':

                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setWrapText(true);
                    break;

                    case 'report_summons_summary_branch':

                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('C:N')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:N')->getAlignment()->setWrapText(true);
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
