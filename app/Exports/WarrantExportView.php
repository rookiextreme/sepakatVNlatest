<?php

namespace App\Exports;

use App\Http\Controllers\Maintenance\Warrant\WarrantDistributionDAO;
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

class WarrantExportView implements FromView,WithStyles,WithColumnWidths,WithEvents
{

    public function __construct(Request $request)
    {
        $this->month = $request->selectedMonth;
        $this->year = $request->selectedYear;
        $this->tab = $request->activeTab;
        $this->selectedWorkshopId = $request->selectedWorkshopId;
        $this->selectedWorkshop = $request->selectedWorkshop;
        $this->selectedWaranId = $request->selectedWaranId;
        $this->selectedOsol = $request->selectedOsol;
        $this->selectedOsolId = $request->selectedOsolId;
        $this->selectedWaran = $request->selectedWaran;
        $this->request = $request;
    }

    public function view(): View
    {

        if (ob_get_contents()) {ob_end_clean();}
        
        $monthDesc = [
            '0' => 'Sepanjang Tahun',
            '1' => 'Januari',
            '2' => 'Febuari',
            '3' => 'March',
            '4' => 'April',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Julai',
            '8' => 'Ogos',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Disember'
    
        ];
        

        switch ($this->tab) {
            case 'MHPV':
               
                $vehicleDepreciationDAO = new WarrantDistributionDAO();
                $osol26 = $vehicleDepreciationDAO->getWarrantDataByOsolType(1,$this->year,$this->month);
                $osol28 = $vehicleDepreciationDAO->getWarrantDataByOsolType(2,$this->year,$this->month);
        
                $osolSum26 = $vehicleDepreciationDAO->getWarrantSumMHPV('01',$this->year,$this->month);
                $osolSum28 = $vehicleDepreciationDAO->getWarrantSumMHPV('02',$this->year,$this->month);
                $osolTotal = $vehicleDepreciationDAO->getWarrantTotalSumAll($this->year,$this->month);
        
                return view('maintenance.warrant.excel_view.mhpv-excel', [
                    'selectedMonth' => 10,
                    'selectedYear' => 2021,
                    'osol26' => $osol26,
                    'osolSum26' => $osolSum26,
                    'osol28' => $osol28,
                    'osolSum28' => $osolSum28,
                    'osolTotal' => $osolTotal,
                    'monthDesc' => $monthDesc
                ]);

            case 'KKR': 

                $vehicleDepreciationDAO = new WarrantDistributionDAO();
                $osolKKR = $vehicleDepreciationDAO->getWarrantDataByWaranType(2,$this->year,$this->month);
                $osolSumKKR = $vehicleDepreciationDAO->getWarrantSum('02',$this->year,$this->month);

                return view('maintenance.warrant.excel_view.kkr-excel', [
                    'selectedMonth' => $this->month,
                    'selectedYear' => $this->year,
                    'osolKKR' => $osolKKR,
                    'osolSumKKR' => $osolSumKKR,
                    'monthDesc' => $monthDesc
                ]);
                break;


            case 'AGENSI LUAR': 

                $vehicleDepreciationDAO = new WarrantDistributionDAO();

                $osolExternal = $vehicleDepreciationDAO->getWarrantDataByWaranType(3,$this->year,$this->month);
                $osolSumExternal = $vehicleDepreciationDAO->getWarrantSum('03',$this->year,$this->month);

                return view('maintenance.warrant.excel_view.agency-luar-excel', [
                    'selectedMonth' => $this->month,
                    'selectedYear' => $this->year,
                    'osolExternal' => $osolExternal,
                    'osolSumExternal' => $osolSumExternal,
                    'monthDesc' => $monthDesc
                ]);
                break;


            case 'PENYATA PERBELANJAAN': 

                $vehicleDepreciationDAO = new WarrantDistributionDAO();

                if ($this->selectedWorkshopId != 0 && $this->selectedWaranId != 0 ) {
                    $listStatement = $vehicleDepreciationDAO->getStatement($this->request, 'report');
                }else {
                    $listStatement = [];
                }

                return view('maintenance.warrant.excel_view.penyata-perbelanjaan-excel', [
                    'selectedMonth' => $this->month,
                    'selectedYear' => $this->year,
                    'listStatement' => $listStatement,
                    'selectedWaran' => $this->selectedWaran,
                    'monthDesc' => $monthDesc
                ]);
                break;

            case 'UNJURAN': 

                $vehicleDepreciationDAO = new WarrantDistributionDAO();

                $osolProjectionSet = $vehicleDepreciationDAO->getOsolProjectionSet();
                $osol26Projectionpercent = $vehicleDepreciationDAO->getOsolProjectionPercent('01',$this->year);
                $osol28Projectionpercent = $vehicleDepreciationDAO->getOsolProjectionPercent('02',$this->year);

                return view('maintenance.warrant.excel_view.unjuran-osol-excel', [
                    'selectedMonth' => $this->month,
                    'selectedYear' => $this->year,
                    'osolProjectionSet' => $osolProjectionSet,
                    'osol26Projectionpercent' => $osol26Projectionpercent,
                    'osol28Projectionpercent' => $osol28Projectionpercent,
                    'monthDesc' => $monthDesc
                ]);
                break;
            
            default:
                $vehicleDepreciationDAO = new WarrantDistributionDAO();

                $osol26 = $vehicleDepreciationDAO->getWarrantDataByOsolType(1,$this->year,$this->month);
                $osol28 = $vehicleDepreciationDAO->getWarrantDataByOsolType(2,$this->year,$this->month);
        
                $osolSum26 = $vehicleDepreciationDAO->getWarrantSumMHPV('01',$this->year,$this->month);
                $osolSum28 = $vehicleDepreciationDAO->getWarrantSumMHPV('02',$this->year,$this->month);
                $osolTotal = $vehicleDepreciationDAO->getWarrantTotalSumAll($this->year,$this->month);
        
                return view('maintenance.warrant.excel_view.mhpv-excel', [
                    'selectedMonth' => $this->month,
                    'selectedYear' => $this->year,
                    'osol26' => $osol26,
                    'osolSum26' => $osolSum26,
                    'osol28' => $osol28,
                    'osolSum28' => $osolSum28,
                    'osolTotal' => $osolTotal,
                    'monthDesc' => $monthDesc
                ]);
                break;
        }

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                switch ($this->tab) {
                    case 'MHPV':
                                //Osol 26000       
                                $event->sheet->getDelegate()->getStyle('A3:L4')->ApplyFromArray([

                                    'borders' => [
                                        'allBorders' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['rgb' => '000000']
                                        ]],

                                ]);

                                $event->sheet->getDelegate()->getStyle('A18:L18')->ApplyFromArray([

                                    'borders' => [
                                        'allBorders' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['rgb' => 'FFFFFF']
                                        ]],

                                ]);
                
                                $event->sheet->getDelegate()->getStyle('A3:L4')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('FAFAD2');

                                $event->sheet->getDelegate()->getStyle('A18:L18')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('3F464B');

                                $event->sheet->getDelegate()->getStyle('A18:L18')
                                        ->getFont()
                                        ->getColor()
                                        ->setARGB('FFFFFF');


                                //Osol 28000        
                                $event->sheet->getDelegate()->getStyle('A22:L23')->ApplyFromArray([

                                            'borders' => [
                                                'allBorders' => [
                                                    'borderStyle' => Border::BORDER_THIN,
                                                    'color' => ['rgb' => '000000']
                                                ]],
                        
                                        ]);

                                $event->sheet->getDelegate()->getStyle('A37:L37')->ApplyFromArray([

                                            'borders' => [
                                                'allBorders' => [
                                                    'borderStyle' => Border::BORDER_THIN,
                                                    'color' => ['rgb' => 'FFFFFF']
                                                ]],
                        
                                        ]);

                                $event->sheet->getDelegate()->getStyle('A22:L23')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('FAFAD2');

                                $event->sheet->getDelegate()->getStyle('A37:L37')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('3F464B');

                                $event->sheet->getDelegate()->getStyle('A37:L37')
                                        ->getFont()
                                        ->getColor()
                                        ->setARGB('FFFFFF');

                                //Osol Total
                                $event->sheet->getDelegate()->getStyle('A41:L42')->ApplyFromArray([

                                            'borders' => [
                                                'allBorders' => [
                                                    'borderStyle' => Border::BORDER_THIN,
                                                    'color' => ['rgb' => '000000']
                                                ]],
                        
                                        ]);

                                $event->sheet->getDelegate()->getStyle('A45:L45')->ApplyFromArray([

                                    'borders' => [
                                        'allBorders' => [
                                            'borderStyle' => Border::BORDER_THIN,
                                            'color' => ['rgb' => 'FFFFFF']
                                        ]],

                                ]);

                                $event->sheet->getDelegate()->getStyle('A41:L42')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('FAFAD2');

                                $event->sheet->getDelegate()->getStyle('A45:L45')
                                        ->getFill()
                                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                        ->getStartColor()
                                        ->setARGB('3F464B');

                                $event->sheet->getDelegate()->getStyle('A45:L45')
                                        ->getFont()
                                        ->getColor()
                                        ->setARGB('FFFFFF');

                            break;

                        case 'KKR': 
                            $event->sheet->getDelegate()->getStyle('A3:L4')->ApplyFromArray([

                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => '000000']
                                    ]],

                            ]);

                            $event->sheet->getDelegate()->getStyle('A18:L18')->ApplyFromArray([

                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => 'FFFFFF']
                                    ]],

                            ]);
            
                            $event->sheet->getDelegate()->getStyle('A3:L4')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('FAFAD2');

                            $event->sheet->getDelegate()->getStyle('A18:L18')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('3F464B');

                            $event->sheet->getDelegate()->getStyle('A18:L18')
                                    ->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                            
                            break;

                        case 'AGENSI LUAR': 
                            $event->sheet->getDelegate()->getStyle('A3:L4')->ApplyFromArray([

                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => '000000']
                                    ]],

                            ]);

                            $event->sheet->getDelegate()->getStyle('A18:L18')->ApplyFromArray([

                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => 'FFFFFF']
                                    ]],

                            ]);
            
                            $event->sheet->getDelegate()->getStyle('A3:L4')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('FAFAD2');

                            $event->sheet->getDelegate()->getStyle('A18:L18')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('3F464B');

                            $event->sheet->getDelegate()->getStyle('A18:L18')
                                    ->getFont()
                                    ->getColor()
                                    ->setARGB('FFFFFF');
                            
                            break;

                        case 'UNJURAN': 
                            $event->sheet->getDelegate()->getStyle('A3:M3')->ApplyFromArray([

                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => '000000']
                                    ]],

                            ]);
            
                            $event->sheet->getDelegate()->getStyle('A3:M3')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('FAFAD2');
                            
                            break;

                        case 'PENYATA PERBELANJAAN': 
                            $event->sheet->getDelegate()->getStyle('A3:D3')->ApplyFromArray([

                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['rgb' => '000000']
                                    ]],

                            ]);
            
                            $event->sheet->getDelegate()->getStyle('A3:D3')
                                    ->getFill()
                                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                    ->getStartColor()
                                    ->setARGB('FAFAD2');
                            
                            break;
                    default:
                        # code...
                        break;
                }

  
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {

        switch ($this->tab) {
            case 'MHPV':
                return [
                    // // Style the first row as bold text.
        
                    1   => [
                        'font' => [
                            'bold' => true,
                            'size' => 15
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],
                    3   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],

                    4   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],

                    20   => [
                        'font' => [
                            'bold' => true,
                            'size' => 15
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],

                    22   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],


                    23   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],

                    39   => [
                        'font' => [
                            'bold' => true,
                            'size' => 15
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],


                    41   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],


                    42   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],
    
                    // Styling an entire column.
                    'A'  => ['font' => ['bold' => 12]],
                ];
                break;

            case 'KKR': 
                return [
                    // // Style the first row as bold text.
        
                    1   => [
                        'font' => [
                            'bold' => true,
                            'size' => 15
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],
                    3   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],

                    4   => [
                        'font' => [
                            'bold' => true,
                            'size' => 12
                        ],
                        
                        'background' => [
                            'color'=> '#FAFAD2'
                        ]],
    
                    // Styling an entire column.
                    'A'  => ['font' => ['bold' => 12]],
                ];

                break;

                case 'AGENSI LUAR': 
                    return [
                        // // Style the first row as bold text.
            
                        1   => [
                            'font' => [
                                'bold' => true,
                                'size' => 15
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],
                        3   => [
                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],
    
                        4   => [
                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],
        
                        // Styling an entire column.
                        'A'  => ['font' => ['bold' => 12]],
                    ];
    
                break;

                case 'UNJURAN': 
                    return [
                        // // Style the first row as bold text.
            
                        1   => [
                            'font' => [
                                'bold' => true,
                                'size' => 15
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],
                        3   => [
                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],

        
                        // Styling an entire column.
                        'A'  => ['font' => ['bold' => 6]],
                    ];
    
                break;

                case 'PENYATA PERBELANJAAN': 
                    return [
                        // // Style the first row as bold text.
            
                        1   => [
                            'font' => [
                                'bold' => true,
                                'size' => 15
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],
                        3   => [
                            'font' => [
                                'bold' => true,
                                'size' => 12
                            ],
                            
                            'background' => [
                                'color'=> '#FAFAD2'
                            ]],
                    ];
    
                break;
            
            default:
                # code...
                break;
        }


    }

    public function columnWidths(): array
    {

        if ($this->tab == "MHPV" || $this->tab == "KKR" || $this->tab == "AGENSI LUAR") {
            return [
                'A' => 20,
                'B' => 15,
                'C' => 15,
                'D' => 15,
                'E' => 15,
                'F' => 15,
                'G' => 15,
                'H' => 15,
                'I' => 15,
                'J' => 15,
                'K' => 15,
                'L' => 15,
                'M' => 15,
                'N' => 15,
                        
            ];
        } else if ($this->tab == "UNJURAN") {
            return [
                'A' => 20,
                'B' => 15,
                'C' => 15,
                'D' => 15,
                'E' => 15,
                'F' => 15,
                'G' => 15,
                'H' => 15,
                'I' => 15,
                'J' => 15,
                'K' => 15,
                'L' => 15,
                'M' => 15,
                        
            ];
        } else if ($this->tab == "PENYATA PERBELANJAAN") {
            return [
                'A' => 25,
                'B' => 20,
                'C' => 20,
                'D' => 20,
                        
            ];
        } else {
            return [
                   
            ];
        }
    }
}
