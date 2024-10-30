<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\MasterChart;

class ReportController extends Controller
{
    public function index()
    {
        $categories = MasterChart::with('category')->get();
        $profits = Transaction::with(['masterChart.category'])->get();

        $groupedProfits = [];
        $totalProfits = [];

        foreach ($categories as $category) {
            $categoryName = $category->category->name;
            $groupedProfits[$categoryName] = [];
        }

        foreach ($profits as $profit) {
            $date = \Carbon\Carbon::parse($profit->date)->format('Y-m');
            $categoryName = $profit->masterChart->category->name;

            if (!isset($groupedProfits[$categoryName][$date])) {
                $groupedProfits[$categoryName][$date] = [
                    'debit' => 0,
                    'credit' => 0,
                    'profit' => 0,
                ];
            }

            $groupedProfits[$categoryName][$date]['debit'] += $profit->debit;
            $groupedProfits[$categoryName][$date]['credit'] += $profit->credit;
            $groupedProfits[$categoryName][$date]['profit'] = $groupedProfits[$categoryName][$date]['credit'] - $groupedProfits[$categoryName][$date]['debit'];

            if (!isset($totalProfits[$date])) {
                $totalProfits[$date] = [
                    'total_debit' => 0,
                    'total_credit' => 0,
                    'total_profit' => 0,
                ];
            }
            $totalProfits[$date]['total_debit'] += $profit->debit;
            $totalProfits[$date]['total_credit'] += $profit->credit;
            $totalProfits[$date]['total_profit'] = $totalProfits[$date]['total_credit'] - $totalProfits[$date]['total_debit'];
        }

        $dates = collect($profits)->map(fn($profit) => \Carbon\Carbon::parse($profit->date)->format('Y-m'))->unique();

        $data['groupedProfits'] = $groupedProfits;
        $data['dates'] = $dates;
        $data['totalProfits'] = $totalProfits;

        return view('report.index', $data);
    }

    public function exportExcel()
    {
        $categories = MasterChart::with('category')->get();
        $profits = Transaction::with(['masterChart.category'])->get();

        $groupedProfits = [];
        $totalProfits = [];
        $months = [];

        foreach ($categories as $category) {
            $categoryName = $category->category->name;
            $groupedProfits[$categoryName] = [];
        }

        foreach ($profits as $profit) {
            $month = \Carbon\Carbon::parse($profit->date)->format('Y-m');
            $categoryName = $profit->masterChart->category->name;

            if (!in_array($month, $months)) {
                $months[] = $month;
            }

            if (!isset($groupedProfits[$categoryName][$month])) {
                $groupedProfits[$categoryName][$month] = [
                    'debit' => 0,
                    'credit' => 0,
                    'profit' => 0,
                ];
            }

            $groupedProfits[$categoryName][$month]['debit'] += $profit->debit;
            $groupedProfits[$categoryName][$month]['credit'] += $profit->credit;
            $groupedProfits[$categoryName][$month]['profit'] = $groupedProfits[$categoryName][$month]['credit'] - $groupedProfits[$categoryName][$month]['debit'];

            if (!isset($totalProfits[$month])) {
                $totalProfits[$month] = [
                    'total_debit' => 0,
                    'total_credit' => 0,
                    'total_profit' => 0,
                ];
            }

            $totalProfits[$month]['total_debit'] += $profit->debit;
            $totalProfits[$month]['total_credit'] += $profit->credit;
            $totalProfits[$month]['total_profit'] = $totalProfits[$month]['total_credit'] - $totalProfits[$month]['total_debit'];
        }

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Kategori');
        foreach ($months as $index => $month) {
            $sheet->setCellValue(chr(67 + $index) . '1', $month);
        }
        $sheet->setCellValue(chr(67 + count($months)) . '1', 'Total');
        $headerRange = 'A1:' . chr(67 + count($months)) . '1';
        $sheet->getStyle($headerRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');

        $row = 3;
        foreach ($groupedProfits as $category => $profits) {
            $sheet->setCellValue('A' . $row, $row - 2);
            $sheet->setCellValue('B' . $row, $category);
            $categoryTotal = 0;

            foreach ($months as $index => $month) {
                $profitValue = $profits[$month]['profit'] ?? 0;
                $sheet->setCellValue(chr(67 + $index) . $row, $profitValue);
                $categoryTotal += $profitValue;
            }

            $sheet->setCellValue(chr(67 + count($months)) . $row, $categoryTotal);

            if (in_array($category, ['Other Income', 'Meal Expense'])) {
                $row++;
                $sheet->setCellValue('B' . $row, 'Total ' . $category);
                $sheet->mergeCells('B' . $row . ':' . chr(66 + count($months)) . $row);

                foreach ($months as $index => $month) {
                    $subtotalValue = $profits[$month]['profit'] ?? 0;
                    $sheet->setCellValue(chr(67 + $index) . $row, $subtotalValue);
                }
                $sheet->setCellValue(chr(67 + count($months)) . $row, $categoryTotal);
            }

            $cellRange = 'A' . $row . ':' . chr(67 + count($months)) . $row;
            $sheet->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFF0F8FF'); // light blue for category rows

            $row++;
        }
        $sheet->setCellValue('A' . $row, 'Net Income');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        foreach ($months as $index => $month) {
            $totalProfitValue = $totalProfits[$month]['total_profit'] ?? 0;
            $sheet->setCellValue(chr(67 + $index) . $row, $totalProfitValue);
        }
        $sheet->setCellValue(chr(67 + count($months)) . $row, array_sum(array_column($totalProfits, 'total_profit')));

        $netIncomeRange = 'A' . $row . ':' . chr(67 + count($months)) . $row;
        $sheet->getStyle($netIncomeRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCFFCC'); // light green for net income row

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Profit_' . date("Ymd") . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
