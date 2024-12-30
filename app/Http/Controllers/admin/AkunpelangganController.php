<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\UserData;
use App\Models\User;
use Illuminate\Http\Request;

class AkunpelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Akun Pelanggan';
        $data['rs_pelanggan'] = User::with('users_data')->where('role_id', 'R0005')->paginate('10');
        // dd($data);
        return view('admin.akun_pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Tambah Akun Pelanggan';
        return view('admin.akun_pelanggan.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'nik' => 'required',
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
                return redirect()->route('addAkunAdmin')->with('error', 'Gagal simpan foto');
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
                'username' => $request->username,
                'nik' => $request->nik,
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
        return redirect()->route('addAkunPelanggan')->with('success', 'Data berhasil disimpan');
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
        $data['title'] = 'Ubah Akun Pelanggan';
        $detail = User::with('users_data')->where('user_id', $id)->first();
        $data['detail'] = $detail;
        // dd($detail);
        return view('admin.akun_pelanggan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id)
    {
        $detail = User::where('user_id', $user_id)->first();
        if (empty($detail)) {
            return redirect()->route('akunPelanggan')->with('error', 'Data tidak ditemukan');
        }
        $request->validate([
            'username' => 'required|unique:users,username,' . $user_id . ',user_id',
            'password' => 'nullable|min:6',
            'nik' => 'required',
            'user_nama_lengkap' => 'required',
            'user_alamat' => 'required',
            'user_telp' => 'required',
            'user_tgl_lahir' => 'required',
            'user_jk' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        }
        $detail->name = $request->user_nama_lengkap;
        $detail->username = $request->username;
        $detail->nik = $request->nik;
        if (!empty($request->password)) {
            $detail->password = bcrypt($request->password);
        }
        if ($detail->save()) {
            $detailUser = UserData::where('user_id', $user_id)->first();
            //
            $image = $detailUser->image;
            if ($request->hasFile('image')) {
                $tujuan_upload = 'image/profil';
                $file = $request->file('image');
                //
                if (!$file->move($tujuan_upload, $file->getClientOriginalName())) {
                    return redirect()->route('addAkunAdmin')->with('error', 'Gagal simpan foto');
                }
                // name
                $image = $file->getClientOriginalName();
            }
            //
            if (!empty($detailUser)) {
                $detailUser->user_alamat = $request->user_alamat;
                $detailUser->user_nama_lengkap = $request->user_nama_lengkap;
                $detailUser->user_telp = $request->user_telp;
                $detailUser->user_tgl_lahir = $request->user_tgl_lahir;
                $detailUser->user_jk = $request->user_jk;
                $detailUser->image = $image;
                //
                if ($detailUser->save()) {
                    return redirect()->route('editAkunPelanggan', [$user_id])->with('success', 'Data berhasil diupdate');
                }
            }
        } else {
            return redirect()->route('akunPelanggan')->with('error', 'Gagal update date');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id)
    {
        $detail = User::where('user_id', $user_id)->first();
        // dd($detail);
        if (empty($detail)) {
            return redirect()->route('akunPelanggan')->with('error', 'Data tidak ditemukan');
        }
        if ($detail->delete()) {
            return redirect()->route('akunPelanggan')->with('success', 'Data berhasil dihapus');
        } else {
            return redirect()->route('akunPelanggan')->with('error', 'Data gagal dihapus');
        }
    }
}
