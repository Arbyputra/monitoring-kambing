<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_kambing;

class Data_kambingController extends Controller
{
    public function index()
    {
        $kambings = data_kambing::all();
        return view('data_kambing.index', compact('kambings'));
    }

    public function show($id)
    {
        $kambing = data_kambing::findOrFail($id);
        return view('data_kambing.show', compact('kambing'));
    }

    public function create()
    {
        return view('data_kambing.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|unique:' . (new \App\Models\data_kambing)->getTable() . ',kode',
            'jenis_kelamin' => 'required|in:jantan,betina',
            'perkiraan_umur' => 'required|numeric',
            'warna_bulu' => 'required|string',
            'berat_terakhir' => 'required|numeric',
            'riwayat_berat' => 'nullable|string',
            'average_gain' => 'nullable|numeric',
            'riwayat_kepemilikan' => 'nullable|string',
            'status_vaksinasi' => 'required|in:sudah,belum',
            'riwayat_vaksinasi' => 'nullable|required_if:status_vaksinasi,sudah|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $riwayat = $request->input('riwayat_berat');
        $data['riwayat_berat'] = $riwayat
            ? json_encode(array_map('trim', explode(',', $riwayat)))
            : json_encode([]);

        if ($request->status_vaksinasi === 'belum') {
            $data['riwayat_vaksinasi'] = null;
        }

        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/kambing'), $filename);
            $data['gambar'] = 'kambing/' . $filename;
        } else {
            $data['gambar'] = 'kambing/noimage.jpg';
        }

        data_kambing::create($data);
        return redirect()->route('data_kambing.index')->with('success', 'Kambing berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kambing = data_kambing::findOrFail($id);
        return view('data_kambing.edit', compact('kambing'));
    }

    public function update(Request $request, $id)
    {
        $kambing = data_kambing::findOrFail($id);

        $data = $request->validate([
            'kode' => 'required|unique:data_kambing,kode,' . $id,
            'jenis_kelamin' => 'required|in:jantan,betina',
            'perkiraan_umur' => 'required|numeric',
            'warna_bulu' => 'required|string',
            'berat_terakhir' => 'required|numeric',
            'riwayat_berat' => 'nullable|string',
            'average_gain' => 'nullable|numeric',
            'riwayat_kepemilikan' => 'nullable|string',
            'status_vaksinasi' => 'required|in:sudah,belum',
            'riwayat_vaksinasi' => 'nullable|required_if:status_vaksinasi,sudah|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $riwayat = $request->input('riwayat_berat');
        $data['riwayat_berat'] = $riwayat
            ? json_encode(array_map('trim', explode(',', $riwayat)))
            : json_encode([]);

        if ($request->status_vaksinasi === 'belum') {
            $data['riwayat_vaksinasi'] = null;
        }

        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/kambing'), $filename);
            $data['gambar'] = 'kambing/' . $filename;
        }

        $kambing->update($data);
        return redirect()->route('data_kambing.index')->with('success', 'Kambing berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kambing = data_kambing::findOrFail($id);

        if ($kambing->gambar && $kambing->gambar !== 'kambing/noimage.jpg') {
            $gambarPath = public_path('images/' . $kambing->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
        }

        $kambing->delete();
        return redirect()->route('data_kambing.index')->with('success', 'Data kambing berhasil dihapus.');
    }
}
