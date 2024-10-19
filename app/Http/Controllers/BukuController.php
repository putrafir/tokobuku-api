<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {

        dd(Buku::all());
        return Buku::all()->with;
    }

    /**
     * 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|integer|exists:kategoris,id'
        ]);

        $buku = Buku::create($request->all());
        return response()->json($buku, 201);
    }

    public function search(Request $request)
    {


        $query = Buku::query();

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori')) {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', 'like', '%' . $request->kategori . '%');
            });
        }

        // Filter berdasarkan judul jika ada
        if ($request->has('judul')) {
            $query->where('judul', 'like', '%' . $request->judul . '%');
        }


        // Mendapatkan hasil dari query
        $bukus = $query->get();

        return response()->json($bukus);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
