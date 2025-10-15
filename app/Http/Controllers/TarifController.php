<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;
use Illuminate\Support\Facades\DB;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tarifs = Tarif::orderBy('created_at', 'desc')->paginate(10);
        return view('master-data.tarif.index', compact('tarifs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_tarif' => 'required|string|max:50|unique:tarif,kode_tarif',
            'kode' => 'required|string|max:20',
            'instansi' => 'required|string|max:100',
            'instansi_pelaksana' => 'required|string|max:100',
            'kelompok_tindakan' => 'required|string|max:100',
            'nama_tindakan' => 'required|string|max:255',
            'detail_tindakan' => 'nullable|string',
            'js' => 'required|numeric|min:0',
            'jp' => 'required|numeric|min:0',
            'tarif' => 'required|numeric|min:0',
        ]);

        try {
            Tarif::create($request->all());
            
            return redirect()->route('tarif.index')->with('success', 'Data tarif berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data tarif: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_tarif' => 'required|string|max:50|unique:tarif,kode_tarif,' . $id,
            'kode' => 'required|string|max:20',
            'instansi' => 'required|string|max:100',
            'instansi_pelaksana' => 'required|string|max:100',
            'kelompok_tindakan' => 'required|string|max:100',
            'nama_tindakan' => 'required|string|max:255',
            'detail_tindakan' => 'nullable|string',
            'js' => 'required|numeric|min:0',
            'jp' => 'required|numeric|min:0',
            'tarif' => 'required|numeric|min:0',
        ]);

        try {
            $tarif = Tarif::findOrFail($id);
            $tarif->update($request->all());
            
            return redirect()->route('tarif.index')->with('success', 'Data tarif berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data tarif: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $tarif = Tarif::findOrFail($id);
            $tarif->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data tarif berhasil dihapus!']);
            }

            return redirect()->route('tarif.index')->with('success', 'Data tarif berhasil dihapus!');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data tarif: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus data tarif: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $tarif = Tarif::findOrFail($id);
            return response()->json($tarif);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}