<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('artikels')->latest()->get();
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategoris'
        ]);

        Kategori::create($request->only('nama_kategori'));
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate([
            'nama_kategori' => 'required|max:255|unique:kategoris,nama_kategori,' . $id
        ]);

        $kategori->update($request->only('nama_kategori'));
        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        if ($kategori->artikels()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan artikel');
        }
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus');
    }
}