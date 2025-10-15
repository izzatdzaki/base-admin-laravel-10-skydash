<?php

namespace App\Http\Controllers;

use App\Models\ParamedisPendamping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ParamedisPendampingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paramedis_pendamping = ParamedisPendamping::paginate(10);
        return view('master-data.paramedis-pendamping.index', compact('paramedis_pendamping'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_tarif' => 'required|string|max:20|unique:paramedis_pendamping,kode_tarif',
            'nama_pendamping' => 'required|string|max:100',
            'ruang_unit' => 'required|string|max:100'
        ], [
            'kode_tarif.required' => 'Kode tarif harus diisi',
            'kode_tarif.unique' => 'Kode tarif sudah ada',
            'nama_pendamping.required' => 'Nama pendamping harus diisi',
            'ruang_unit.required' => 'Ruang/Unit harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambah data paramedis pendamping. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            ParamedisPendamping::create($request->all());
            return redirect()->route('paramedis-pendamping.index')->with('success', 'Data paramedis pendamping berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambah data paramedis pendamping. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $paramedisPendamping = ParamedisPendamping::findOrFail($id);
            return response()->json($paramedisPendamping);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_tarif' => ['required', 'string', 'max:20', Rule::unique('paramedis_pendamping')->ignore($id)],
            'nama_pendamping' => 'required|string|max:100',
            'ruang_unit' => 'required|string|max:100'
        ], [
            'kode_tarif.required' => 'Kode tarif harus diisi',
            'kode_tarif.unique' => 'Kode tarif sudah ada',
            'nama_pendamping.required' => 'Nama pendamping harus diisi',
            'ruang_unit.required' => 'Ruang/Unit harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate data paramedis pendamping. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            $paramedisPendamping = ParamedisPendamping::findOrFail($id);
            $paramedisPendamping->update($request->all());
            return redirect()->route('paramedis-pendamping.index')->with('success', 'Data paramedis pendamping berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data paramedis pendamping. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $paramedisPendamping = ParamedisPendamping::findOrFail($id);
            $paramedisPendamping->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data paramedis pendamping berhasil dihapus']);
            }

            return redirect()->route('paramedis-pendamping.index')->with('success', 'Data paramedis pendamping berhasil dihapus');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data paramedis pendamping. Silakan coba lagi.'], 500);
            }

            return redirect()->route('paramedis-pendamping.index')->with('error', 'Gagal menghapus data paramedis pendamping. Silakan coba lagi.');
        }
    }
}
