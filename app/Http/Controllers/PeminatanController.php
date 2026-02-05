<?php

namespace App\Http\Controllers;

use App\Models\Peminatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeminatanController extends Controller
{
        public function index()
    {
        $peminatans = Peminatan::with('alokasis')->get();
        return view('admin.peminatan.index', compact('peminatans'));
    }

    /**
     */
    public function create()
    {
        return view('admin.peminatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:peminatans,nama',
            'kuota_maksimal' => 'required|integer|min:1|max:999'
        ], [
            'nama.required' => 'Nama peminatan wajib diisi.',
            'nama.unique' => 'Nama peminatan sudah ada.',
            'kuota_maksimal.required' => 'Kuota maksimal wajib diisi.',
            'kuota_maksimal.min' => 'Kuota minimal 1 siswa.',
            'kuota_maksimal.max' => 'Kuota maksimal 999 siswa.'
        ]);

        // Simpan data
        Peminatan::create($request->only(['nama', 'kuota_maksimal']));

        return redirect()->route('admin.peminatan.index')
                        ->with('success', 'Paket peminatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminatan $peminatan)
    {
        return view('admin.peminatan.show', compact('peminatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminatan $peminatan)
    {
        return view('admin.peminatan.edit', compact('peminatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminatan $peminatan)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255|unique:peminatans,nama,' . $peminatan->id,
            'kuota_maksimal' => 'required|integer|min:1|max:999'
        ], [
            'nama.required' => 'Nama peminatan wajib diisi.',
            'nama.unique' => 'Nama peminatan sudah ada.',
            'kuota_maksimal.required' => 'Kuota maksimal wajib diisi.',
            'kuota_maksimal.min' => 'Kuota minimal 1 siswa.',
            'kuota_maksimal.max' => 'Kuota maksimal 999 siswa.'
        ]);

        // Update data
        $peminatan->update($request->only(['nama', 'kuota_maksimal']));

        return redirect()->route('admin.peminatan.index')
                        ->with('success', 'Paket peminatan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminatan $peminatan)
    {
        // Cek apakah peminatan masih memiliki alokasi siswa
        if ($peminatan->alokasis()->count() > 0) {
            return back()->withErrors([
                'error' => 'Tidak bisa menghapus peminatan yang sudah memiliki siswa diterima!'
            ]);
        }

        // Hapus data
        $peminatan->delete();

        return back()->with('success', 'Paket peminatan berhasil dihapus!');
    }
}