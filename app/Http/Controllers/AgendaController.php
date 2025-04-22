<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Agenda;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agenda = Agenda::latest()->paginate(10);
        return view('agenda.index', compact('agenda'));
    }

    public function create()
    {
        return view('agenda.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_bagian' => 'required|unique:agenda',
            'nama_bagian' => 'required',
        ]);

        Agenda::create($validated);

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan');
    }

    public function show(Agenda $agenda)
    {

        return view('agenda.show', compact('agenda'));
    }

    public function edit(Request $request, $id)
    {
        $agenda = Agenda::where('id_agenda', $id)->first();
        return response()->json($agenda);
    }

    public function update(Request $request, $id)
    {

        $agenda = Agenda::find($id)->update([
            'kode_bagian' => $request->kode_bagian,
            'nama_bagian' => $request->nama_bagian,
        ]);
        $agendas = Agenda::all();
        $response["message"] = "Data Agenda Berhasil Di Update !";
        $response["data"] = compact('agendas');
        return response()->json($response, 200);
    }


    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil dihapus');
    }
}
