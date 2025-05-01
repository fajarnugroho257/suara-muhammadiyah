<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Kategori;
use App\Models\admin\Produk;
use App\Models\admin\Produk_image;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Produk';
        $data['rs_produk'] = Produk::with('kategori')->paginate('10');
        // dd($data);
        return view('admin.produk.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Produk';
        $data['rs_kategori'] = Kategori::all();
        return view('admin.produk.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'kategori_id' => 'required',
            'produk_nama' => 'required',
            'produk_rating' => 'required',
            'produk_deskripsi' => 'required',
            'produk_harga' => 'required',
            // 'produk_stok' => 'required',
            'produk_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //
        $produk_image = '';
        if ($request->hasFile('produk_image')) {
            $tujuan_upload = 'image/produk';
            $file = $request->file('produk_image');
            //
            if (!$file->move($tujuan_upload, $file->getClientOriginalName())) {
                return redirect()->route('addProduk')->with('error', 'Gagal simpan foto');
            }
            // name
            $produk_image = $file->getClientOriginalName();
        }
        //
        $st_produk = Produk::create([
            'kategori_id' => $request->kategori_id,
            'produk_nama' => $request->produk_nama,
            'produk_rating' => $request->produk_rating,
            'produk_deskripsi' => $request->produk_deskripsi,
            'produk_harga' => $request->produk_harga,
            'produk_stok' => 0,
            'produk_image' => $produk_image,
        ]);
        if ($st_produk) {
            // menyimpan data file yang diupload ke variabel $file
            $tujuan_upload = 'image/produk/detail';
            $file = $request->file('data_image');
            if ($request->hasFile('data_image')) {
                foreach ($request->file('data_image') as $image) {
                    // Unggah gambar ke folder `public/images`
                    $image->move($tujuan_upload, $image->getClientOriginalName());
                    $imageName[] = $image->getClientOriginalName(); // Simpan path ke dalam array
                }
                // insert
                // last id
                $last_id = Produk::orderBy('id', 'desc')->first();
                foreach ($imageName as $key => $value) {
                    Produk_image::create([
                        'produk_id' => $last_id->id,
                        'data_image' => $value,
                    ]);
                }
            }
            return redirect()->route('addProduk')->with('success', 'Data berhasil disimpan');
        } else {
            return redirect()->route('addProduk')->with('error', 'Data gagal disimpan');
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
    public function edit(string $slug)
    {
        $detail = Produk::where('slug', $slug)->first();
        if (empty($detail)) {
            return redirect()->route('dataProduk')->with('error', 'Data tidak ditemukan');
        }
        $data['title'] = 'Ubah Produk';
        $data['rs_kategori'] = Kategori::all();
        $data['detail'] = $detail;
        $data['rs_img'] = Produk_image::where('produk_id', '=', value: $detail->id)->get();
        // dd($data);
        return view('admin.produk.edit', $data);
    }

    public function delete_img(string $id)
    {
        $data = Produk_image::with('produk')->where('id', $id)->first();
        if (empty($data)) {
            return redirect()->route('dataProduk')->with('error', 'Data tidak ditemukan');
        }
        $slug = $data->produk->slug;
        if ($data->delete()) {
            return redirect()->route('updateProduk', ['slug' => $slug])->with('success', 'Image berhasil dihapus');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $detail = Produk::find($request->id);
        if (empty($detail)) {
            return redirect()->route('dataProduk')->with('error', 'Data tidak ditemukan');
        }
        $this->validate($request, [
            'id' => 'required',
            'kategori_id' => 'required',
            'produk_nama' => 'required',
            'produk_rating' => 'required',
            'produk_deskripsi' => 'required',
            'produk_harga' => 'required',
            // 'produk_stok' => 'required',
            'produk_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'data_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // file pertama
        $produk_image = $detail->produk_image;
        if ($request->hasFile('produk_image')) {
            $tujuan_upload = 'image/produk';
            $file = $request->file('produk_image');
            $st_file = $file->move($tujuan_upload, $file->getClientOriginalName());
            if (!$st_file) {
                return redirect()->route('updateProduk', ['slug' => $detail->slug])->with('error', 'Gagal update foto');
            }
            //
            $produk_image = $file->getClientOriginalName();
        }
        // params
        $detail->kategori_id = $request->kategori_id;
        $detail->produk_nama = $request->produk_nama;
        $detail->produk_rating = $request->produk_rating;
        $detail->produk_deskripsi = $request->produk_deskripsi;
        $detail->produk_harga = $request->produk_harga;
        $detail->produk_image = $produk_image;
        // update
        if ($detail->save()) {
            // menyimpan data file yang diupload ke variabel $file
            $tujuan_upload = 'image/produk/detail';
            if ($request->hasFile('data_image')) {
                foreach ($request->file('data_image') as $image) {
                    $image->move($tujuan_upload, $image->getClientOriginalName());
                    $imageName[] = $image->getClientOriginalName(); // Simpan path ke dalam array
                }
                // insert
                foreach ($imageName as $key => $value) {
                    Produk_image::create([
                        'produk_id' => $detail->id,
                        'data_image' => $value,
                    ]);
                }
            }
            return redirect()->route('updateProduk', ['slug' => $detail->slug])->with('success', 'Data berhasil disimpan');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $detail = Produk::where('slug', $slug);
        if (empty($detail)) {
            return redirect()->route('dataProduk')->with('error', 'Data tidak ditemukan');
        }
        if ($detail->delete()) {
            return redirect()->route('dataProduk')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('dataProduk')->with('error', 'Data tidak ditemukan');
        }
    }
}
