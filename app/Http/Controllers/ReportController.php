<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

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
            $groupedProfits[$categoryName][$date]['profit'] = $groupedProfits[$categoryName][$date]['debit'] - $groupedProfits[$categoryName][$date]['credit'];
            if (!isset($totalProfits[$date])) {
                $totalProfits[$date] = [
                    'total_debit' => 0,
                    'total_credit' => 0,
                    'total_profit' => 0,
                ];
            }
            $totalProfits[$date]['total_debit'] += $profit->debit;
            $totalProfits[$date]['total_credit'] += $profit->credit;
            $totalProfits[$date]['total_profit'] = $totalProfits[$date]['total_debit'] - $totalProfits[$date]['total_credit'];
        }
        $dates = collect($profits)->pluck('date')->unique();
        $data['groupedProfits'] = $groupedProfits;
        $data['dates'] = $dates;
        $data['totalProfits'] = $totalProfits;

        return view('report.index', $data);
    }
}
