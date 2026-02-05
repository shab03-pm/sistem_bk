<?php

namespace App\Http\Controllers;

use App\Models\Peminatan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $peminatans = Peminatan::with('kriterias')->get();
        return view('admin.kriteria.index', compact('peminatans'));
    }

    public function create()
    {
        $peminatans = Peminatan::all();
        $mapelList = [
            'matematika', 'fisika', 'kimia', 'biologi',
            'tik', 'binggris', 'sosiologi', 'ekonomi', 'geografi'
        ];
        return view('admin.kriteria.create', compact('peminatans', 'mapelList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminatan_id' => 'required|exists:peminatans,id',
            'mapel' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        // Cek apakah kriteria sudah ada untuk peminatan dan mapel ini
        if (Kriteria::where('peminatan_id', $request->peminatan_id)
                   ->where('mapel', $request->mapel)
                   ->exists()) {
            return back()->withErrors(['error' => 'Kriteria ini sudah ada untuk peminatan tersebut!']);
        }

        Kriteria::create($request->only(['peminatan_id', 'mapel', 'bobot']));
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria bobot berhasil ditambahkan!');
    }

    public function edit(Kriteria $kriteria)
    {
        $peminatans = Peminatan::all();
        $mapelList = [
            'matematika', 'fisika', 'kimia', 'biologi',
            'tik', 'binggris', 'sosiologi', 'ekonomi', 'geografi'
        ];
        return view('admin.kriteria.edit', compact('kriteria', 'peminatans', 'mapelList'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'peminatan_id' => 'required|exists:peminatans,id',
            'mapel' => 'required|string',
            'bobot' => 'required|numeric|min:0|max:1'
        ]);

        // Cek duplikasi (kecuali untuk record yang sedang diupdate)
        if (Kriteria::where('peminatan_id', $request->peminatan_id)
                   ->where('mapel', $request->mapel)
                   ->where('id', '!=', $kriteria->id)
                   ->exists()) {
            return back()->withErrors(['error' => 'Kriteria ini sudah ada untuk peminatan tersebut!']);
        }

        $kriteria->update($request->only(['peminatan_id', 'mapel', 'bobot']));
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria bobot berhasil diupdate!');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return back()->with('success', 'Kriteria bobot berhasil dihapus!');
    }
}