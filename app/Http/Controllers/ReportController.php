<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function index()
    {

        $profits = Transaction::with(['masterChart.category'])->get();
        $groupedProfits = [];
        $totalProfits = [];
        foreach ($profits as $profit) {
            $date = $profit->date;
            $categoryName = $profit->masterChart->category->name;
            if (!isset($groupedProfits[$categoryName])) {
                $groupedProfits[$categoryName] = [];
            }
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
        $dates = collect($profits)->pluck('date')->unique();
        $data['groupedProfits'] = $groupedProfits;
        $data['dates'] = $dates;
        $data['totalProfits'] = $totalProfits;

        return view('report.index', $data);
    }

    public function exportExcel()
    {
        $profits = Transaction::with(['masterChart.category'])->get();

        $groupedProfits = [];
        $totalProfits = [];
        $dates = [];

        foreach ($profits as $profit) {
            $date = $profit->date;
            $categoryName = $profit->masterChart->category->name;

            if (!in_array($date, $dates)) {
                $dates[] = $date;
            }

            if (!isset($groupedProfits[$categoryName])) {
                $groupedProfits[$categoryName] = [];
            }

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

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', '#');
        $sheet->setCellValue('B1', 'Kategori');

        foreach ($dates as $index => $date) {
            $sheet->setCellValue(chr(67 + $index) . '1', $date);
        }
        $sheet->setCellValue(chr(67 + count($dates)) . '1', 'Total');

        foreach ($dates as $index => $date) {
            $sheet->setCellValue(chr(67 + $index) . '2', 'Amount');
        }

        $row = 3;
        foreach ($groupedProfits as $category => $profits) {
            $sheet->setCellValue('A' . $row, $row - 2);
            $sheet->setCellValue('B' . $row, $category);
            $categoryTotal = 0;

            foreach ($dates as $date) {
                $profitValue = $profits[$date]['profit'] ?? 0;
                $formattedProfit = 'Rp. ' . number_format($profitValue, 0, ',', '.');
                $sheet->setCellValue(chr(67 + array_search($date, $dates)) . $row, $formattedProfit);
                $categoryTotal += $profitValue;
            }

            $sheet->setCellValue(chr(67 + count($dates)) . $row, 'Rp. ' . number_format($categoryTotal, 0, ',', '.'));
            $row++;
        }

        $sheet->getStyle('A1:' . chr(67 + count($dates)) . '2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:' . chr(67 + count($dates)) . '2')->getFill()->getStartColor()->setARGB('FFFFFF00');

        $sheet->setCellValue('A' . $row, 'Total Pendapatan Bersih');
        $sheet->mergeCells('A' . $row . ':B' . $row);
        foreach ($dates as $date) {
            $totalProfitValue = $totalProfits[$date]['total_profit'] ?? 0;
            $sheet->setCellValue(chr(67 + array_search($date, $dates)) . $row, 'Rp. ' . number_format($totalProfitValue, 0, ',', '.'));
        }
        $sheet->setCellValue(chr(67 + count($dates)) . $row, 'Rp. ' . number_format(array_sum(array_column($totalProfits, 'total_profit')), 0, ',', '.'));
        $sheet->getStyle('A' . $row . ':' . chr(67 + count($dates)) . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A' . $row . ':' . chr(67 + count($dates)) . $row)->getFill()->getStartColor()->setARGB('FFCCFFCC');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Laporan_Profit_' . date("Ymd") . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
}
