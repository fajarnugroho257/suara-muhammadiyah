<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Pref;
use Illuminate\Http\Request;

class PrefController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'Data Preference';
        $data['rs_pref'] = Pref::paginate(5);
        return view('admin.pref.index', $data);
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
        //
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
        $data['title'] = 'Data Preference';
        $detail = Pref::find($id);
        if (empty($detail)) {
            return redirect()->route('dataPreference')->with('error', 'Data tidak ditemukan');
        }
        $data['detail'] = $detail;
        return view('admin.pref.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'pref_value' => 'required',
        ]);
        // detail data
        $detail = Pref::find($request->id);
        if (empty($detail)) {
            return redirect()->route('dataPreference')->with('error', 'Data tidak ditemukan');
        }
        // edit
        $detail->pref_value = $request->pref_value;
        if ($detail->update()) {
            return redirect()->route('updateDataPreference', ['id' => $request->id])->with('success', 'Data berhasil diupdate');
        } else {
            return redirect()->route('updateDataPreference', ['id' => $request->id])->with('error', 'Data gagal diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
