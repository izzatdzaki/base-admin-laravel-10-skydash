<?php

namespace App\Http\Controllers;

use App\Models\KelompokTindakan;
use Illuminate\Http\Request;

class KelompokTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelompok_tindakan = KelompokTindakan::orderBy('created_at', 'desc')->paginate(10);
        return view('master-data.kelompok-tindakan.index', compact('kelompok_tindakan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_tindakan' => 'required|string|max:50|unique:kelompok_tindakan,kode_tindakan',
            'kode_tarif' => 'required|string|max:50',
            'instalasi_induk' => 'required|string|max:100',
            'instansi_pelaksana' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'kelompok_tindakan' => 'required|string|max:100',
            'detail_tindakan' => 'nullable|string',
            'rincian_tindakan' => 'nullable|string',
        ]);

        try {
            KelompokTindakan::create($request->all());
            
            return redirect()->route('kelompok-tindakan.index')->with('success', 'Data kelompok tindakan berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data kelompok tindakan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kelompokTindakan = KelompokTindakan::findOrFail($id);
        
        $request->validate([
            'kode_tindakan' => 'required|string|max:50|unique:kelompok_tindakan,kode_tindakan,' . $kelompokTindakan->id,
            'kode_tarif' => 'required|string|max:50',
            'instalasi_induk' => 'required|string|max:100',
            'instansi_pelaksana' => 'required|string|max:100',
            'unit' => 'required|string|max:50',
            'kelompok_tindakan' => 'required|string|max:100',
            'detail_tindakan' => 'nullable|string',
            'rincian_tindakan' => 'nullable|string',
        ]);

        try {
            $kelompokTindakan->update($request->all());
            
            return redirect()->route('kelompok-tindakan.index')->with('success', 'Data kelompok tindakan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data kelompok tindakan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $kelompokTindakan = KelompokTindakan::findOrFail($id);
            $kelompokTindakan->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data kelompok tindakan berhasil dihapus!']);
            }

            return redirect()->route('kelompok-tindakan.index')->with('success', 'Data kelompok tindakan berhasil dihapus!');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data kelompok tindakan: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus data kelompok tindakan: ' . $e->getMessage());
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $tarif = KelompokTindakan::findOrFail($id);
            return response()->json($tarif);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}
