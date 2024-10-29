<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterChart;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $data['transactions'] = Transaction::with(['masterChart.category'])->get();
        return view('transaction.index', $data);
    }

    public function create()
    {
        $data['master_charts'] = MasterChart::get();
        return view('transaction.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'master_charts_id' => 'required',
            'desc' => 'required',
        ]);

        try {
            Transaction::create([
                'date' => $request->date,
                'master_charts_id' => $request->master_charts_id,
                'desc' => $request->desc,
                'debit' => $request->debit,
                'credit' => $request->credit,
            ]);

            return redirect()->route('transaction.index')
                ->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }


    public function edit($id)
    {
        $data['transactions'] = Transaction::find($id);
        $data['master_charts'] = MasterChart::get();

        return view('transaction.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'date' => 'required',
            'master_charts_id' => 'required',
            'desc' => 'required',
        ]);

        try {

            $transactions = Transaction::findOrFail($id);
            $transactions->update([
                'date' => $request->date,
                'master_charts_id' => $request->master_charts_id,
                'desc' => $request->desc,
                'debit' => $request->debit,
                'credit' => $request->credit,
            ]);

            return redirect()->route('transaction.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function destroy($id)
    {
        try {
            $transactions = Transaction::find($id);
            if (!$transactions) {
                return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
            }
            $transactions->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed', 'error' => $e->getMessage()], 500);
        }
    }
}