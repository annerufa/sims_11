<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instansi;

class InstansiController extends Controller
{
    public function index()
    {
        $instansi = Instansi::latest()->paginate(10);
        return view('instansi.index', compact('instansi'));
    }

    public function create()
    {
        return view('instansi.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nama_instansi' => 'required',
            'nama_pengirim' => 'required',
            'jabatan_pengirim' => 'required',
            'periode_pengirim' => 'required',
        ]);

        Instansi::create($validated);

        return redirect()->route('instansi.index')
            ->with('success', 'instansi berhasil ditambahkan');
    }

    public function show(Instansi $instansi)
    {

        return view('instansi.show', compact('instansi'));
    }

    public function edit(Request $request, $id)
    {
        $instansi = Instansi::where('id_instansi', $id)->first();
        return response()->json($instansi);
    }

    public function update(Request $request, $id)
    {

        $instansi = Instansi::find($id)->update([
            'nama_instansi' => $request->nama_instansi,
            'nama_pengirim' => $request->nama_pengirim,
            'jabatan_pengirim' => $request->jabatan_pengirim,
            'periode_pengirim' => $request->periode_pengirim,
        ]);
        $instansis = Instansi::all();
        $response["message"] = "Data instansi Berhasil Di Update !";
        $response["data"] = compact('instansis');
        return response()->json($response, 200);
    }


    public function destroy(Instansi $instansi)
    {
        $instansi->delete();

        return redirect()->route('instansi.index')
            ->with('success', 'instansi berhasil dihapus');
    }


    public function getInstansi(Request $request)
    {
        if ($request->has('id_instansi')) {
            $instansi = Instansi::find($request->id_instansi);
        } else if ($request->has('nama_instansi')) {
            $instansi = Instansi::where('nama_instansi', $request->nama_instansi)->first();
        } else {
            return response()->json(null);
        }

        return response()->json($instansi);
        // $instansi = Instansi::where('nama_instansi', $request->nama_instansi)->first();

        // return response()->json($instansi);
    }
    public function testujuan()
    {
        $listInstansi = Instansi::latest()->paginate(10);
        return view('surat-keluar.tes', compact('listInstansi'));
    }
}
