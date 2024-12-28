<?php

namespace App\Http\Controllers;

use App\Models\admin\Kategori;
use App\Models\admin\Pesanan;
use App\Models\admin\PesananData;
use App\Models\admin\Pref;
use App\Models\admin\Produk;
use App\Models\admin\Produk_image;
use App\Models\admin\UserData;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index($kategori = '')
    {
        $data['title'] = 'Beranda';

        $keyword = session()->get('keyword');
        $data['keyword'] = $keyword;
        $keyword = empty($keyword) ? '%' : '%' . $keyword . '%';
        //
        $dt_kate = Kategori::where('slug', $kategori)->first();
        if ($kategori == 'all-product' || $kategori == '') {
            $product = Produk::where('produk_nama', 'LIKE', $keyword)->get();
        } else {
            $product = Produk::where('kategori_id', $dt_kate->kategori_id)->where('produk_nama', 'LIKE', $keyword)->get();
        }
        //
        $data['rs_kategori'] = Kategori::where('status', 'yes')->get();
        $data['rs_produk'] = $product;
        if (Auth::check()) {
            $user = User::with('users_data')->where('user_id', Auth::user()->user_id)->first();
        } else {
            $user = array();
        }
        $data['user'] = $user;
        $data['kategori_slug'] = $kategori;
        // dd($product);
        return view('beranda.index', $data);
    }

    public function detail_produk(string $slug)
    {
        if (Auth::check()) {
            $user = User::with('users_data')->where('user_id', Auth::user()->user_id)->first();
        } else {
            $user = array();
        }
        $data['user'] = $user;
        // dd($data);
        $detail = Produk::with('kategori')->where('slug', $slug)->first();
        if (empty($detail)) {
            abort(404);
        }
        $data['rs_img'] = Produk_image::where('produk_id', '=', value: $detail->id)->get();
        $data['detail'] = $detail;
        if (Auth::check()) {
            $draft = PesananData::whereRelation('pesanan', 'pesanan_st', 'waiting')
                ->whereRelation('pesanan', 'user_id', Auth::user()->user_id)
                ->where('produk_id', $detail->id)
                ->first();
            // dd($draft);
        } else {
            $draft = array();
        }
        $data['draft'] = $draft;
        // dd($data);
        return view('beranda.detail', $data);
    }

    public function cart(Request $request)
    {
        // print_r($request->all());
        $detail = Produk::with('kategori')->where('slug', $request->slug)->first();
        // dd($detail);
        if (empty($detail)) {
            // abort(404);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak tersedia!',
            ]);
        }
        if (!Auth::check()) {
            // login dulu
            return response()->json([
                'success' => true,
                'message' => 'Anda harus login terlebih dahulu',
                'login' => false
            ]);
        }
        // masukkan ke tabel pesanan
        $tersedia = Pesanan::where('pesanan_st', 'waiting')->where('user_id', Auth::user()->user_id)->orderBy('pesanan_tgl', 'DESC')->first();
        if (!empty($tersedia)) {
            // last id
            $last_data = PesananData::
                whereRelation('pesanan', 'pesanan_id', '=', $tersedia->pesanan_id)
                ->orderBy('data_id', 'DESC')
                ->first();
            //
            if (empty($last_data)) {
                $last_id = $tersedia->pesanan_id . '-0001';
            } else {
                $last_number = substr($last_data->data_id, 10, 5) + 1;
                $zero = '';
                for ($i = strlen($last_number); $i <= 3; $i++) {
                    $zero .= '0';
                }
                $last_id = $tersedia->pesanan_id . '-' . $zero . $last_number;
            }
            // check jika sudah ada update
            $produk_ada = PesananData::where('pesanan_id', $tersedia->pesanan_id)
                ->where('produk_id', $detail->id)
                ->first();
            if (empty($produk_ada)) {
                // insert pesanan data
                $saved = PesananData::create([
                    'data_id' => $last_id,
                    'pesanan_id' => $tersedia->pesanan_id,
                    'produk_id' => $detail->id,
                    'data_jlh' => $request->quantity,
                ]);
                if ($saved) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item berhasil ditambah kekeranjang',
                        'login' => true,
                        'keranjang' => true,
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item gagal ditambah kekeranjang',
                        'login' => true,
                        'keranjang' => false,
                    ]);
                }
            } else {
                // update
                $produk_ada->data_jlh = $request->quantity;
                //
                if ($produk_ada->save()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item berhasil diupdate ke keranjang',
                        'login' => true,
                        'keranjang' => true,
                    ]);
                } else {
                    return response()->json([
                        'success' => true,
                        'message' => 'Item gagal diupdate ke keranjang',
                        'login' => true,
                        'keranjang' => false,
                    ]);
                }
            }

        } else {
            // insert data baru
            Pesanan::create([
                'user_id' => Auth::user()->user_id,
                'pesanan_tgl' => date('Y-m-d H:i:s'),
                'pesanan_st' => 'waiting'
            ]);
            //
            $pesanan = Pesanan::where('user_id', Auth::user()->user_id)->where('pesanan_st', 'waiting')->first();
            $last_id = $pesanan->pesanan_id . '-0001';
            $saved = PesananData::create([
                'data_id' => $last_id,
                'pesanan_id' => $pesanan->pesanan_id,
                'produk_id' => $detail->id,
                'data_jlh' => $request->quantity,
            ]);
            if ($saved) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item berhasil ditambah kekeranjang',
                    'login' => true,
                    'keranjang' => true,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Item gagal ditambah kekeranjang',
                    'login' => true,
                    'keranjang' => false,
                ]);
            }
        }
        // dd($tersedia);
    }

    public function login_proses_pelanggan(Request $request)
    {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required|min:6',
        ]);
        // dd($request->all());
        if (Auth::attempt($credentials)) {
            // dd(Auth::user()->role_id);
            $request->session()->regenerate();
            if (Auth::user()->role_id == 'R0005') {
                return back()->with('success', 'Berhasil login');
            } else {
                return redirect('dashboard');
            }
        } else {
            return back()->with('error', 'Username atau password salah..');
        }

    }

    public function keranjang()
    {
        if (Auth::check()) {
            $user = User::with('users_data')->where('user_id', Auth::user()->user_id)->first();
            $data['user'] = $user;
            //
            $data['title'] = 'Keranjang';
            $rs_cart = PesananData::with(['pesanan', 'produk'])
                ->whereRelation('pesanan', 'user_id', Auth::user()->user_id)
                ->whereRelation('pesanan', 'pesanan_st', 'waiting')
                ->get();
            $data['rs_cart'] = $rs_cart;
            // dd($rs_cart);
            return view('beranda.keranjang', $data);
        } else {
            return back()->with('error', 'Anda belum login, silahkan untuk login terlebih dahulu');
        }
    }

    public function destroy(Request $request)
    {
        // print_r($request->all());
        $detail = PesananData::where('data_id', $request->data_id)->first();
        // dd($detail);
        if (empty($detail)) {
            // abort(404);
            return response()->json([
                'success' => false,
                'message' => 'Data tidak tersedia!',
            ]);
        }
        if (!Auth::check()) {
            // login dulu
            return response()->json([
                'success' => true,
                'message' => 'Anda harus login terlebih dahulu',
                'login' => false
            ]);
        }
        if ($detail->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Item gagal dihapus',
            ]);
        }
    }

    public function update_keranjang(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'jumlah' => 'required',
            'data_id' => 'required',
        ]);
        $data_id = $request->data_id;
        $jumlah = $request->jumlah;
        foreach ($data_id as $key => $value) {
            // update
            $detail = PesananData::where('data_id', $value)->first();
            $detail->data_jlh = $jumlah[$key];
            $detail->save();
        }
        // redirect
        return redirect()->route('checkout')->with('success', 'Data berhasil disimpan');
    }

    public function checkout()
    {
        if (Auth::check()) {
            $user = User::with('users_data')->where('user_id', Auth::user()->user_id)->first();
            $data['user'] = $user;
            //
            $data['title'] = 'Checkout Pesanan';
            $rs_cart = PesananData::with(['pesanan', 'produk'])
                ->whereRelation('pesanan', 'user_id', Auth::user()->user_id)
                ->whereRelation('pesanan', 'pesanan_st', 'waiting')
                ->get();
            if (empty($rs_cart)) {
                return redirect()->route('beranda');
            }
            $data['rs_cart'] = $rs_cart;
            $data['detail'] = Pesanan::
                where('user_id', Auth::user()->user_id)
                ->where('pesanan_st', 'waiting')
                ->first();
            if (empty($data['detail'])) {
                return redirect()->route('beranda');
            }
            $data['user'] = User::where('user_id', Auth::user()->user_id)->first();
            // dd($rs_cart);
            return view('beranda.checkout', $data);
        } else {
            return back()->with('error', 'Anda belum login, silahkan untuk login terlebih dahulu');
        }
    }

    public function whatsapp(string $pesanan_id)
    {
        $detail = Pesanan::where('pesanan_id', $pesanan_id)->where('pesanan_st', 'waiting')->first();
        if (empty($detail)) {
            return redirect()->route('checkout');
        }
        // data pesanan
        $rs_cart = PesananData::with(['pesanan', 'produk'])
            ->where('pesanan_id', $pesanan_id)
            ->whereRelation('pesanan', 'pesanan_st', 'waiting')
            ->get();
        $text = 'Nomor Pesanan : ' . $detail->pesanan_id . "\n";
        $text .= 'Nama : *' . $detail->user->users_data->user_nama_lengkap . '*' . "\n";
        $text .= 'Alamat : *' . $detail->user->users_data->user_alamat . '*' . "\n";
        $text .= 'Telp/Wa : *' . $detail->user->users_data->user_telp . '*' . "\n";
        // rincian pemesanan
        $text .= '*-------------------------*' . "\n";
        $text .= '*Rincian Pemesanan*' . "\n";
        $grand_total = 0;
        foreach ($rs_cart as $key => $value) {
            $total = $value->produk->produk_harga * $value->data_jlh;
            $grand_total += $total;
            $text .= 'Nama Item : ' . $value->produk->produk_nama . "\n";
            $text .= 'Harga Per/item : *Rp. ' . number_format($value->produk->produk_harga, 0, ',', '.') . '*' . "\n";
            $text .= 'Jumlah Item : *' . $value->data_jlh . '*' . "\n";
            $text .= 'Jumlah Harga : *Rp. ' . number_format($total, 0, ',', '.') . '*' . "\n";
            $text .= '*-------------------------*' . "\n";
        }
        // Grand Total
        $text .= '*Grand Total Pemesanan*' . "\n";
        $text .= '*Rp. ' . number_format($grand_total, 0, ',', '.') . '*' . "\n";

        // echo urlencode($text);
        // dd($rs_cart);
        $url_pesan = urlencode($text);

        // Nomor tujuan WhatsApp (gunakan kode negara tanpa tanda +)
        $pref = Pref::find(1);
        $nomor_whatsapp = $pref->pref_value;

        // URL WhatsApp
        $whatsapp_url = "https://wa.me/$nomor_whatsapp?text=$url_pesan";

        // Redirect ke URL WhatsApp
        return redirect()->away($whatsapp_url);
    }

    public function search_proses(Request $request)
    {
        // dd($request->all());
        session([
            'keyword' => $request->keyword
        ]);
        return redirect()->route('beranda');
    }

    public function registrasi()
    {
        if (Auth::check()) {
            return redirect()->route('beranda')->with('success', 'Berhasil Login');
        }
        $data['title'] = 'Registrasi';
        if (Auth::check()) {
            $user = User::with('users_data')->where('user_id', Auth::user()->user_id)->first();
        } else {
            $user = array();
        }
        $data['user'] = $user;
        // dd($rs_cart);
        return view('beranda.registrasi', $data);
    }

    public function proses_registrasi(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:users,nik|digits:16',
            'password' => 'required|min:6',
            'user_nama_lengkap' => 'required',
            'user_alamat' => 'required',
            'user_telp' => 'required',
            'user_tgl_lahir' => 'required',
            'user_jk' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        //
        $image = '';
        if ($request->hasFile('image')) {
            $tujuan_upload = 'image/profil';
            $file = $request->file('image');
            //
            if (!$file->move($tujuan_upload, $file->getClientOriginalName())) {
                return redirect()->route('registrasi')->with('error', 'Gagal simpan foto');
            }
            // name
            $image = $file->getClientOriginalName();
        }
        $user_id = $this->last_user_id();
        if ($user_id) {
            User::create([
                'user_id' => $user_id,
                'name' => $request->user_nama_lengkap,
                'role_id' => 'R0005',
                'nik' => $request->nik,
                'username' => '-',
                'password' => bcrypt($request->password),
            ]);
            // insert user data
            UserData::create([
                'user_id' => $user_id,
                'user_alamat' => $request->user_alamat,
                'user_nama_lengkap' => $request->user_nama_lengkap,
                'user_telp' => $request->user_telp,
                'user_tgl_lahir' => $request->user_tgl_lahir,
                'user_jk' => $request->user_jk,
                'image' => $image
            ]);
        }
        //redirect
        return redirect()->route('registrasi')->with('success', 'Data berhasil disimpan');
    }

    function last_user_id()
    {
        // get last user id
        $last_user = User::select('user_id')->orderBy('user_id', 'DESC')->first();
        $last_number = substr($last_user->user_id, 1, 6) + 1;
        $zero = '';
        for ($i = strlen($last_number); $i <= 3; $i++) {
            $zero .= '0';
        }
        $new_id = 'U' . $zero . $last_number;
        //
        return $new_id;
    }

}
