<?php

namespace App\Http\Controllers;

use App\Models\PorsiJpTmo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PorsiJpTmoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $porsi_jp_tmo = PorsiJpTmo::paginate(10);
        return view('master-data.porsi-jp-tmo.index', compact('porsi_jp_tmo'));
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
            'kode' => 'required|string|max:20|unique:porsi_jp_tmo,kode',
            'jenis_tmo' => 'required|string|max:100',
            'penerima_jp' => 'required|string|max:100',
            'porsi_jp' => 'required|numeric|min:0|max:100'
        ], [
            'kode.required' => 'Kode harus diisi',
            'kode.unique' => 'Kode sudah ada',
            'jenis_tmo.required' => 'Jenis TMO harus diisi',
            'penerima_jp.required' => 'Penerima JP harus diisi',
            'porsi_jp.required' => 'Porsi JP harus diisi',
            'porsi_jp.numeric' => 'Porsi JP harus berupa angka',
            'porsi_jp.min' => 'Porsi JP minimal 0',
            'porsi_jp.max' => 'Porsi JP maksimal 100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambah data porsi JP TMO. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            PorsiJpTmo::create($request->all());
            return redirect()->route('porsi-jp-tmo.index')->with('success', 'Data porsi JP TMO berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambah data porsi JP TMO. Silakan coba lagi.');
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
            $porsiJpTmo = PorsiJpTmo::findOrFail($id);
            return response()->json($porsiJpTmo);
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
            'kode' => ['required', 'string', 'max:20', Rule::unique('porsi_jp_tmo')->ignore($id)],
            'jenis_tmo' => 'required|string|max:100',
            'penerima_jp' => 'required|string|max:100',
            'porsi_jp' => 'required|numeric|min:0|max:100'
        ], [
            'kode.required' => 'Kode harus diisi',
            'kode.unique' => 'Kode sudah ada',
            'jenis_tmo.required' => 'Jenis TMO harus diisi',
            'penerima_jp.required' => 'Penerima JP harus diisi',
            'porsi_jp.required' => 'Porsi JP harus diisi',
            'porsi_jp.numeric' => 'Porsi JP harus berupa angka',
            'porsi_jp.min' => 'Porsi JP minimal 0',
            'porsi_jp.max' => 'Porsi JP maksimal 100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate data porsi JP TMO. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            $porsiJpTmo = PorsiJpTmo::findOrFail($id);
            $porsiJpTmo->update($request->all());
            return redirect()->route('porsi-jp-tmo.index')->with('success', 'Data porsi JP TMO berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data porsi JP TMO. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $porsiJpTmo = PorsiJpTmo::findOrFail($id);
            $porsiJpTmo->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data porsi JP TMO berhasil dihapus']);
            }

            return redirect()->route('porsi-jp-tmo.index')->with('success', 'Data porsi JP TMO berhasil dihapus');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data porsi JP TMO. Silakan coba lagi.'], 500);
            }

            return redirect()->route('porsi-jp-tmo.index')->with('error', 'Gagal menghapus data porsi JP TMO. Silakan coba lagi.');
        }
    }
}
