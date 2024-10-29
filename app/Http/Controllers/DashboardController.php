<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index() {
        
        $data['transactions'] = Transaction::all();
        $data['totalDebit'] = Transaction::sum('debit');
        $data['totalCredit'] = Transaction::sum('credit');
    
        return view('dashboard.index', $data);
    }
}
