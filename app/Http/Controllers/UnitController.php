<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::orderBy('created_at', 'desc')->paginate(10);
        return view('master-data.unit.index', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:units,kode',
            'ruang_unit' => 'required|string|max:100',
            'instalasi' => 'required|string|max:100',
        ]);

        try {
            Unit::create($request->all());
            
            return redirect()->route('unit.index')->with('success', 'Data unit berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data unit: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:units,kode,' . $unit->id,
            'ruang_unit' => 'required|string|max:100',
            'instalasi' => 'required|string|max:100',
        ]);

        try {
            $unit->update($request->all());
            
            return redirect()->route('unit.index')->with('success', 'Data unit berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data unit: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data unit berhasil dihapus!']);
            }

            return redirect()->route('unit.index')->with('success', 'Data unit berhasil dihapus!');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data unit: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus data unit: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            return response()->json($unit);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}
