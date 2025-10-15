<?php

namespace App\Http\Controllers;

use App\Models\PorsiCbgs;
use Illuminate\Http\Request;

class PorsiCbgsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $porsi_cbgs = PorsiCbgs::orderBy('created_at', 'desc')->paginate(10);
        return view('master-data.porsi-cbgs.index', compact('porsi_cbgs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'porsi' => 'required|numeric|min:0|max:100',
            'nilai' => 'required|numeric|min:0',
        ]);

        try {
            PorsiCbgs::create($request->all());
            
            return redirect()->route('porsi-cbgs.index')->with('success', 'Data porsi CBGs berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data porsi CBGs: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PorsiCbgs $porsiCbgs)
    {
        $request->validate([
            'porsi' => 'required|numeric|min:0|max:100',
            'nilai' => 'required|numeric|min:0',
        ]);

        try {
            $porsiCbgs->update($request->all());
            
            return redirect()->route('porsi-cbgs.index')->with('success', 'Data porsi CBGs berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data porsi CBGs: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $porsiCbgs = PorsiCbgs::find($id);

            if (!$porsiCbgs) {
                if (request()->ajax() || request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data tidak ditemukan'
                    ], 404);
                }

                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }

            $porsiCbgs->delete();

            // Check if this is an AJAX request
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data porsi CBGs berhasil dihapus!'
                ]);
            }

            return redirect()->route('porsi-cbgs.index')->with('success', 'Data porsi CBGs berhasil dihapus!');
        } catch (\Exception $e) {
            // Check if this is an AJAX request
            if (request()->ajax() || request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data porsi CBGs: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus data porsi CBGs: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $porsiCbgs = PorsiCbgs::findOrFail($id);
            return response()->json($porsiCbgs);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}
