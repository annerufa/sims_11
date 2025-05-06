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
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class DisposisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->jabatan === 'ks') {
            $disposisi = Disposisi::with(['suratMasuk', 'penerimas'])
                ->get()
                ->map(function ($item) {
                    return [
                        'id_disposisi' => $item->id_disposisi,
                        'surat_masuk' => $item->suratMasuk,
                        'perintah' => $item->perintah,
                        'catatan' => $item->catatan,
                        'penerimas' => $item->penerimas->map(function ($penerima) {
                            return [
                                'nama' => $penerima->nama,
                                'status_tugas' => $penerima->pivot->status_tugas ?? null,
                                'catatan_balasan' => $penerima->pivot->catatan_balasan ?? null
                            ];
                        }),
                        'tanggal_disposisi' => $item->tanggal_disposisi
                    ];
                });
            // echo ($disposisi);
            return view('disposisi.index', compact('disposisi'));
        } else {
            $userId = Auth::id();
            $disposisi = Disposisi::whereHas('penerimas', fn($q) => $q->where('user_id', $userId))
                ->with(['suratMasuk', 'penerimas' => fn($q) => $q->where('user_id', $userId)])
                ->get()
                ->map(function ($item) {
                    return [
                        'id_disposisi' => $item->id_disposisi,
                        'surat_masuk' => $item->suratMasuk,
                        'perintah' => $item->perintah,
                        'catatan' => $item->catatan,
                        // 'perihal' => $item->catatan,
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
    public function detailWaka($id_dis)
    {
        $userId = Auth::id();
        // Cari disposisi dengan eager loading penerimas
        // Ambil data disposisi dengan semua relasi
        $disposisi = Disposisi::with([
            'penerimas' => function ($query) {
                $query->select('users.id', 'users.nama') // Sesuaikan kolom user yang dibutuhkan
                    ->withPivot('status_tugas', 'catatan_balasan');
            },
            'suratMasuk.instansi',
            'suratMasuk.agenda'
        ])
            ->where('id_disposisi', $id_dis)
            ->firstOrFail();
        // echo ($disposisi->suratMasuk);
        return view('disposisi.detailWk', compact('disposisi'));;
    }
    public function disDone($id)
    {
        try {
            $penerimaId = Auth::id();
            DisposisiPenerima::where('disposisi_id', $id)->where('user_id', $penerimaId)->update([
                'status_tugas' => 1,
            ]);
            $d = DisposisiPenerima::where('disposisi_id', $id)->where('user_id', $penerimaId)->first();
            echo ($d);
            // return redirect()->route('disposisi.index')
            //     ->with('success', 'Disposisi telah ditindak lanjuti');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal melakukan tindak lanjut ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'surat_masuk_id' => 'required|integer|exists:surat_masuk,id_sm',
            'catatan' => 'required|string',
            'perintah' => 'required|array',
            'perintah.*' => 'string',
            'penerima' => 'required|array',
            'penerima.*' => 'integer|exists:users,id'
        ]);

        // Create disposisi
        $disposisi = Disposisi::create([
            'surat_masuk_id' => $request->surat_masuk_id,
            'catatan' => $request->catatan,
            'perintah' => implode(', ', $request->perintah),
            'tanggal_disposisi' => now()
        ]);

        // Prepare pivot data
        $pivotData = array_fill_keys($request->penerima, [
            'status_tugas' => 0, // Default status
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Attach penerimas with pivot data
        $disposisi->penerimas()->attach($pivotData);

        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil ditambahkan');\
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
