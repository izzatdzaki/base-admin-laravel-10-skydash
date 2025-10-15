<?php

namespace App\Http\Controllers;

use App\Models\PorsiJp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PorsiJpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $porsi_jp = PorsiJp::paginate(10);
        return view('master-data.porsi-jp.index', compact('porsi_jp'));
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
            'kode_tarif' => 'required|string|max:20|unique:porsi_jp,kode_tarif',
            'instalasi_induk' => 'required|string|max:100',
            'instansi_pelaksana' => 'required|string|max:100',
            'kelompok_tindakan' => 'required|string|max:100',
            'jlp' => 'required|integer|min:0',
            'jla' => 'required|integer|min:0',
            'jtl_st' => 'required|integer|min:0',
            'jtl_p' => 'required|integer|min:0'
        ], [
            'kode_tarif.required' => 'Kode tarif harus diisi',
            'kode_tarif.unique' => 'Kode tarif sudah ada',
            'instalasi_induk.required' => 'Instalasi induk harus diisi',
            'instansi_pelaksana.required' => 'Instansi pelaksana harus diisi',
            'kelompok_tindakan.required' => 'Kelompok tindakan harus diisi',
            'jlp.required' => 'JLP harus diisi',
            'jlp.integer' => 'JLP harus berupa angka',
            'jlp.min' => 'JLP minimal 0',
            'jla.required' => 'JLA harus diisi',
            'jla.integer' => 'JLA harus berupa angka',
            'jla.min' => 'JLA minimal 0',
            'jtl_st.required' => 'JTL ST harus diisi',
            'jtl_st.integer' => 'JTL ST harus berupa angka',
            'jtl_st.min' => 'JTL ST minimal 0',
            'jtl_p.required' => 'JTL P harus diisi',
            'jtl_p.integer' => 'JTL P harus berupa angka',
            'jtl_p.min' => 'JTL P minimal 0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal menambah data porsi JP. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            PorsiJp::create($request->all());
            return redirect()->route('porsi-jp.index')->with('success', 'Data porsi JP berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambah data porsi JP. Silakan coba lagi.');
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
            $porsiJp = PorsiJp::findOrFail($id);
            return response()->json($porsiJp);
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
            'kode_tarif' => ['required', 'string', 'max:20', Rule::unique('porsi_jp')->ignore($id)],
            'instalasi_induk' => 'required|string|max:100',
            'instansi_pelaksana' => 'required|string|max:100',
            'kelompok_tindakan' => 'required|string|max:100',
            'jlp' => 'required|integer|min:0',
            'jla' => 'required|integer|min:0',
            'jtl_st' => 'required|integer|min:0',
            'jtl_p' => 'required|integer|min:0'
        ], [
            'kode_tarif.required' => 'Kode tarif harus diisi',
            'kode_tarif.unique' => 'Kode tarif sudah ada',
            'instalasi_induk.required' => 'Instalasi induk harus diisi',
            'instansi_pelaksana.required' => 'Instansi pelaksana harus diisi',
            'kelompok_tindakan.required' => 'Kelompok tindakan harus diisi',
            'jlp.required' => 'JLP harus diisi',
            'jlp.integer' => 'JLP harus berupa angka',
            'jlp.min' => 'JLP minimal 0',
            'jla.required' => 'JLA harus diisi',
            'jla.integer' => 'JLA harus berupa angka',
            'jla.min' => 'JLA minimal 0',
            'jtl_st.required' => 'JTL ST harus diisi',
            'jtl_st.integer' => 'JTL ST harus berupa angka',
            'jtl_st.min' => 'JTL ST minimal 0',
            'jtl_p.required' => 'JTL P harus diisi',
            'jtl_p.integer' => 'JTL P harus berupa angka',
            'jtl_p.min' => 'JTL P minimal 0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Gagal mengupdate data porsi JP. Silakan periksa kembali data yang dimasukkan.');
        }

        try {
            $porsiJp = PorsiJp::findOrFail($id);
            $porsiJp->update($request->all());
            return redirect()->route('porsi-jp.index')->with('success', 'Data porsi JP berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data porsi JP. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $porsiJp = PorsiJp::findOrFail($id);
            $porsiJp->delete();

            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data porsi JP berhasil dihapus']);
            }

            return redirect()->route('porsi-jp.index')->with('success', 'Data porsi JP berhasil dihapus');
        } catch (\Exception $e) {
            // Check if request is AJAX
            if (request()->expectsJson() || request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data porsi JP. Silakan coba lagi.'], 500);
            }

            return redirect()->route('porsi-jp.index')->with('error', 'Gagal menghapus data porsi JP. Silakan coba lagi.');
        }
    }
}
