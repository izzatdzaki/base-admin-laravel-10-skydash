<?php

namespace App\Http\Controllers;

use App\Models\Paramedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ParamedisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paramedis = Paramedis::paginate(10);
        return view('master-data.paramedis.index', compact('paramedis'));
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
            'kode' => 'required|string|max:20|unique:paramedis,kode',
            'nama_paramedis' => 'required|string|max:100',
            'ruang_unit' => 'required|string|max:100'
        ], [
            'kode.required' => 'Kode harus diisi',
            'kode.unique' => 'Kode sudah ada',
            'nama_paramedis.required' => 'Nama paramedis harus diisi',
            'ruang_unit.required' => 'Ruang/Unit harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambah data paramedis. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            Paramedis::create($request->all());
            return redirect()->route('paramedis.index')->with('success', 'Data paramedis berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambah data paramedis. Silakan coba lagi.');
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
            $paramedis = Paramedis::findOrFail($id);
            return response()->json($paramedis);
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
            'kode' => ['required', 'string', 'max:20', Rule::unique('paramedis')->ignore($id)],
            'nama_paramedis' => 'required|string|max:100',
            'ruang_unit' => 'required|string|max:100'
        ], [
            'kode.required' => 'Kode harus diisi',
            'kode.unique' => 'Kode sudah ada',
            'nama_paramedis.required' => 'Nama paramedis harus diisi',
            'ruang_unit.required' => 'Ruang/Unit harus diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate data paramedis. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            $paramedis = Paramedis::findOrFail($id);
            $paramedis->update($request->all());
            return redirect()->route('paramedis.index')->with('success', 'Data paramedis berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data paramedis. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $paramedis = Paramedis::findOrFail($id);
            $paramedis->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data paramedis berhasil dihapus']);
            }

            return redirect()->route('paramedis.index')->with('success', 'Data paramedis berhasil dihapus');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data paramedis. Silakan coba lagi.'], 500);
            }

            return redirect()->route('paramedis.index')->with('error', 'Gagal menghapus data paramedis. Silakan coba lagi.');
        }
    }
}
