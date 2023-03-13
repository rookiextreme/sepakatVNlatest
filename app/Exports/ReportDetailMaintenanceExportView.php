<?php

namespace App\Exports;

use App\Http\Controllers\Report\ReportDetailMaintenanceDAO;
use App\Models\RefWorkshop;
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

class ReportDetailMaintenanceExportView implements FromView,WithColumnWidths,WithStyles,WithEvents
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->month = $request->selectedMonth;
        $this->year = $request->selectedYear;
        $this->selectedWorkshopId = $request->selectedWorkshopId;
        $this->selectedWorkshop = $request->selectedWorkshop;
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

        $reportDetailMaintenanceDAO = new ReportDetailMaintenanceDAO();
        $listYear = $reportDetailMaintenanceDAO-> getYear();
        $listReport = $reportDetailMaintenanceDAO-> getListReport($this->request, $this->year, $this->month,$this->selectedWorkshopId);
        $listWorkshop = $reportDetailMaintenanceDAO->getWorkshop();
        $selectedWorkshop = RefWorkshop::find($this->selectedWorkshopId);

        return view('report.excel_view.report_detail_maintenance_excel', [
            'monthDesc' => $monthDesc,
            'listYear' => $listYear,
            'selectedMonth' => $this->month,
            'selectedYear' => $this->year,
            'listReport' => $listReport,
            'listWorkshop' => $listWorkshop,
            'selectedWorkshop' => $selectedWorkshop->desc,
            'selectedWorkshopId' => $this->selectedWorkshopId
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A2:L2')->ApplyFromArray([

                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000']
                        ]],

                ]);

                $event->sheet->getDelegate()->getStyle('A2:L2')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('800080');

                $event->sheet->getDelegate()->getStyle('A2:L2')
                ->getFont()
                ->getColor()
                ->setARGB('FFFFFF');


            },
        ];

        return [
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // // Style the first row as bold text.

            1   => [
                'font' => [
                    'bold' => true,
                    'size' => 15
                ]],
            2   => [
                'font' => [
                    'bold' => false,
                    'size' => 12
                ]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 15,
            'C' => 20,
            'D' => 15,
            'E' => 15,
            'F' => 20,
            'G' => 30,
            'H' => 15,
            'I' => 15,
            'J' => 15,
            'K' => 20,
            'L' => 15,
            'M' => 17,
                    
        ];
    }

}