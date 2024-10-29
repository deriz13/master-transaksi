<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterChart;
use App\Models\MasterCategory;

class MasterChartController extends Controller
{
    public function index()
    {
        $data['master_charts'] = MasterChart::with('category')->get();
        return view('master.master_chart.index', $data);
    }

    public function create()
    {
        $data['category'] = MasterCategory::get();
        return view('master.master_chart.create',$data);
    }

    public function generateCode()
{
    $uniqueCode = false;
    $newCode = null;

    while (!$uniqueCode) {
        
        $newCode = random_int(1000, 9999);
        $existingCode = MasterChart::where('code', $newCode)->first();
        if (!$existingCode) {
            $uniqueCode = true;
        }
    }
    return str_pad($newCode, 4, '0', STR_PAD_LEFT);
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        try {
            MasterChart::create([
                'code' => $this->generateCode(),
                'name' => $request->name,
                'category_id' => $request->category_id,
            ]);

            return redirect()->route('master_chart.index')
                ->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }


    public function edit($id)
    {
        $data['master_charts'] = MasterChart::find($id);
        $data['category'] = MasterCategory::get();

        return view('master.master_chart.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);

        try {

            $masterChart = MasterChart::findOrFail($id);
            $masterChart->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
            ]);

            return redirect()->route('master_chart.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function destroy($id)
    {
        try {
            $masterChart = MasterChart::find($id);
            if (!$masterChart) {
                return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
            }
            $masterChart->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed', 'error' => $e->getMessage()], 500);
        }
    }
}
