<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SuratMasuk;
use App\Models\Instansi;
use App\Models\Agenda;
use App\Models\User;
use App\Models\Disposisi;
use App\Models\DisposisiPenerima;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->jabatan === 'ks') {

            // $disposisi = DisposisiPenerima::where('user_id', Auth::user()->id)
            //     ->with(['User', 'Disposisi'])->latest()->get(); // 'instansi' nanti kita buat relasinya
            $disposisi = DisposisiPenerima::with(['User', 'Disposisi'])->latest()->get(); // 'instansi' nanti kita buat relasinya
            return view('disposisi.index', compact('disposisi'));
        } else {
            // $disposisi = DisposisiPenerima::with(['User', 'penerima', 'Disposisi'])->latest()->get(); // 'instansi' nanti kita buat relasinya
            // Cara query yang lebih clean dengan relasi belongsToMany
            // $disposisi = Disposisi::with(['suratMasuk', 'penerima'])
            //     ->whereHas('penerima', function ($query) {
            //         $query->where('users.id', Auth::id()); // Perhatikan perubahan disini
            //     })
            //     ->latest()->get();
            // Mendapatkan disposisi untuk user yang login
            $userId = Auth::id();
            $disposisi = Disposisi::whereHas('penerimas', fn($q) => $q->where('user_id', $userId))
                ->with(['suratMasuk', 'penerimas' => fn($q) => $q->where('user_id', $userId)])
                ->get()
                ->map(function ($item) {
                    return [
                        'id_disposisi' => $item->id_disposisi,
                        'surat_masuk' => $item->suratMasuk,
                        'catatan' => $item->catatan,
                        'status_tugas' => $item->penerimas->first()->pivot->status_tugas,
                        'catatan_balasan' => $item->penerimas->first()->pivot->catatan_balasan,
                        'tanggal_disposisi' => $item->tanggal_disposisi
                    ];
                });

            // dd($disposisi);
            return view('disposisi.wakaIndex', compact('disposisi'));
        }
    }

    public function wakaIndex() {}

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
        $request->validate([
            'surat_masuk_id' => 'required|integer',
            'catatan' => 'required|string',
            'perintah' => 'required|array',
            'penerima' => 'required|array',
        ]);
        $perintah = implode(', ', $request->perintah);

        // Buat data disposisi
        $disposisi = Disposisi::create([
            'surat_masuk_id' => $request->surat_masuk_id,
            'catatan' => $request->catatan,
            'perintah' => $perintah,
            'tanggal_disposisi' => now(),
            'dari_user_id' => Auth::id(), // Uncomment if you need this
        ]);

        // Attach penerima using many-to-many relationship
        $penerimaData = [];
        foreach ($request->penerima as $penerimaId) {
            $penerimaData[$penerimaId] = [
                'status_tugas' => 0, // Default value
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $disposisi->penerimas()->attach($penerimaData);

        // // Buat data disposisi
        // $disposisi = Disposisi::create([
        //     'surat_masuk_id' => $request->surat_masuk_id,
        //     'catatan' => $request->catatan,
        //     'perintah' => $perintah,
        //     'tanggal_disposisi' => now(),
        //     // 'dari_user_id' =>Auth::user()->id,
        // ]);

        // // Simpan penerima
        // foreach ($request->penerima as $penerimaId) {
        //     DisposisiPenerima::create([
        //         'disposisi_id' => $disposisi->id_disposisi,
        //         'user_id' => $penerimaId,
        //     ]);
        // }

        // Ambil data lengkap dengan relasi
        // $disposisi = Disposisi::with(['penerimas.user'])->get();
        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil ditambahkan');
        // return response()->json([
        //     'message' => 'Disposisi berhasil dikirim.',
        //     'data' => $disposisi,
        // ]);
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
