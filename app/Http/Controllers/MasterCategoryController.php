<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCategory;

class MasterCategoryController extends Controller
{

    public function index()
    {
        $data['master_categories'] = MasterCategory::get();
        return view('master.master_category.index', $data);
    }

    public function create()
    {
        return view('master.master_category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            MasterCategory::create([
                'name' => $request->name,
            ]);

            return redirect()->route('master_category.index')
                ->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        }
    }


    public function edit($id)
    {
        $data['master_categories'] = MasterCategory::find($id);

        return view('master.master_category.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
        ]);

        try {

            $masterCategory = MasterCategory::findOrFail($id);
            $masterCategory->update([
                'name' => $request->name,
            ]);

            return redirect()->route('master_category.index')
                ->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Data gagal diperbarui');
        }
    }

    public function destroy($id)
    {
        try {
            $masterCategory = MasterCategory::find($id);
            if (!$masterCategory) {
                return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
            }
            $masterCategory->delete();
            return response()->json(['message' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed', 'error' => $e->getMessage()], 500);
        }
    }
}
