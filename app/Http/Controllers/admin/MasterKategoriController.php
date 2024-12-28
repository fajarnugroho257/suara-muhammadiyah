<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Kategori;
use Illuminate\Http\Request;

class MasterKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Kategori';
        $data['rs_kategori'] = Kategori::paginate('10');
        return view('admin.kategori.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Add Kategori';

        return view('admin.kategori.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'status' => 'required',
            'kategori_nama' => 'required',
        ]);
        $kategori_id = $this->last_id();
        $validated['kategori_id'] = $kategori_id;
        if (Kategori::create($validated)) {
            return redirect()->route('dataKategori')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('addKategori')->with('error', 'Data gagal disimpan');
        }
    }
    public function last_id()
    {
        $last_data = Kategori::orderBy('kategori_id', 'DESC')->first();
        $newNumber = str_pad((int) $last_data->kategori_id + 1, 3, '0', STR_PAD_LEFT);
        return $newNumber;
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
        $data['title'] = 'Edit Kategori';
        $detail = Kategori::where('kategori_id', $id)->first();
        if (empty($detail)) {
            return redirect()->route('dataKategori')->with('error', 'Data tidak ditemukan');
        }
        $data['detail'] = $detail;
        //
        return view('admin.kategori.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required',
            'kategori_nama' => 'required',
        ]);
        // detail data
        $detail = Kategori::find($request->id);
        if (empty($detail)) {
            return redirect()->route('dataKategori')->with('error', 'Data tidak ditemukan');
        }
        // edit
        $detail->kategori_nama = $request->kategori_nama;
        $detail->status = $request->status;
        if ($detail->update()) {
            return redirect()->route('dataKategori')->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('dataKategori')->with('error', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detail = Kategori::find($id);
        if (empty($detail)) {
            return redirect()->route('dataKategori')->with('error', 'Data tidak ditemukan');
        }
        if ($detail->delete()) {
            return redirect()->route('dataKategori')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('dataKategori')->with('error', 'Data gagal dihapus');
        }
    }
}
