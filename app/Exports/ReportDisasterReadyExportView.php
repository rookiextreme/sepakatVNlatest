<?php

namespace App\Exports;

use App\Http\Controllers\Helpers\HelpersFunction;
use App\Http\Controllers\Logistic\DisasterReady\DisasterReadyDAO;
use App\Http\Controllers\Report\ReportDisasterReadyDAO;
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

class ReportDisasterReadyExportView implements FromView, WithEvents, WithStyles, ShouldAutoSize, WithColumnWidths
{

    public function __construct($view, $request)
    {
        $this->total_row = 0;
        $this->footer = 0;
        $this->view = $view;
        $this->request = $request;
    }

    public function view(): View
    {
        $ReportDisasterReadyDAO = new ReportDisasterReadyDAO();
        Log::info($this->view);
        if (ob_get_contents()) {ob_end_clean();}
        switch ($this->view) {
            case 'report_vehicle_summary_vtype':
                $obj = $ReportDisasterReadyDAO->reportDisasterReadyByStateVType();
                $this->total_row = $obj['total_state'];
                $this->footer = $this->total_row + 5;
                return view('report.report_vehicle_summary_vtype_excel', $obj);
                break;
            case 'report_vehicle_summary_vcategories':
                $obj = $ReportDisasterReadyDAO->reportDisasterReadyByStateVcategories();
                $this->total_row = $obj['total_state'];
                $this->footer = $this->total_row + 6;
                return view('report.report_vehicle_summary_vcategories_excel', $obj);
                break;

            case 'report_vehicle_summary_vtypes':
                $obj = $ReportDisasterReadyDAO->reportDisasterReadyByStateVTypes();
                $this->total_row = $obj['total_state'];
                $this->footer = $this->total_row + 6;
                // dd($obj['categories']);
                return view('report.report_vehicle_summary_vtypes_excel', $obj);
                break;

            case 'logistic_vehicle_disaster_ready_by_state':
                $DisasterReadyDAO = new DisasterReadyDAO();
                $obj = $DisasterReadyDAO->vehicleReportList($this->request);
                return view('logistic.disasterready-vehicle-list-excel', $obj);
                break;

            default:
                $obj = $ReportDisasterReadyDAO->reportDisasterReadyByStateVcategories();
                return view('report.report_vehicle_summary_vcategories', $obj);
                break;
        }

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                switch ($this->view) {
                    case 'report_vehicle_summary_vtype':
                        $event->sheet->mergeCells('A1:L1');
                        $event->sheet->mergeCells('A2:L2');
                        $event->sheet->mergeCells('A3:L3');

                        $event->sheet->getDelegate()->getStyle('A3:L3')->ApplyFromArray([

                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_NONE,
                                    'color' => ['rgb' => '000000']
                                ]],

                        ]);

                        $event->sheet->getDelegate()->getStyle('A'.$this->footer.':L'.$this->footer)->ApplyFromArray([

                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ]

                        ]);
                    break;
                    case 'report_vehicle_summary_vtype':
                        $event->sheet->mergeCells('A1:L1');
                        $event->sheet->mergeCells('A2:L2');
                        $event->sheet->mergeCells('A3:L3');

                        $event->sheet->getDelegate()->getStyle('A3:L3')->ApplyFromArray([

                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_NONE,
                                    'color' => ['rgb' => '000000']
                                ]],

                        ]);

                        $event->sheet->getDelegate()->getStyle('A'.$this->footer.':L'.$this->footer)->ApplyFromArray([

                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ]

                        ]);
                        break;

                    case 'logistic_vehicle_disaster_ready_by_state':
                        $event->sheet->mergeCells('A1:G1');
                        // $event->sheet->mergeCells('A2:L2');
                        // $event->sheet->mergeCells('A3:L3');

                        $event->sheet->getDelegate()->getStyle('A3:G3')->ApplyFromArray([

                            'borders' => [
                                'outline' => [
                                    'borderStyle' => Border::BORDER_NONE,
                                    'color' => ['rgb' => '000000']
                                ]],

                        ]);

                        $event->sheet->getDelegate()->getStyle('A'.$this->footer.':G'.$this->footer)->ApplyFromArray([

                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ]

                        ]);

                        $event->sheet->getDelegate()->getStyle('A:G')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A:G')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                        $event->sheet->getDelegate()->getStyle('E')->getAlignment()->setWrapText(true);
                        
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

        ///$sheet->getStyle('D4')->getAlignment()->setWrapText(true);

        switch ($this->view) {
            case 'report_vehicle_summary_vtype':

                return [
                    // // Style the first row as bold text.

                    4  => [
                        'alignment' => ['wrapText' => true],
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],

                        'background' => [
                            'color'=> '#FAFAD2'
                        ]
                    ]
                ];
            break;

            case 'report_vehicle_summary_vcategories':

                return [
                    // // Style the first row as bold text.

                    4  => [
                        'alignment' => ['wrapText' => true],
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],

                        'background' => [
                            'color'=> '#FAFAD2'
                        ]
                    ],
                    5  => [
                        'alignment' => ['wrapText' => true],
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],

                        'background' => [
                            'color'=> '#FAFAD2'
                        ]
                    ]
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
