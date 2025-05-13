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
                        'surat_masuk_id' => $item->surat_masuk_id,
                        'surat_masuk' => $item->suratMasuk,
                        'perintah' => $item->perintah,
                        'catatan' => $item->catatan,
                        'penerimas' => $item->penerimas->map(function ($penerima) {
                            return [
                                'nama' => $penerima->nama,
                                'status_tugas' => $penerima->pivot->status_tugas ?? null,
                                'catatan_balasan' => $penerima->pivot->catatan_balasan ?? null,
                                'is_read' => $penerima->pivot->is_read ?? null
                            ];
                        }),
                        'tanggal_disposisi' => $item->tanggal_disposisi
                    ];
                });
            $users = User::all();
            return view('disposisi.index', compact('disposisi', 'users'));
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
                        'status_tugas' => $item->penerimas->first()->pivot->status_tugas,
                        'catatan_balasan' => $item->penerimas->first()->pivot->catatan_balasan,
                        'tanggal_disposisi' => $item->tanggal_disposisi
                    ];
                });
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
        DisposisiPenerima::where('disposisi_id', $id_dis)->where('user_id', $userId)->update([
            'is_read' => 1,
        ]);
        $disposisi = Disposisi::where('id_disposisi', $id_dis)
            ->with([
                'penerimas' => function ($query) {
                    $query->select('users.id', 'users.nama') // Sesuaikan kolom user yang dibutuhkan
                        ->withPivot('status_tugas', 'catatan_balasan');
                },
                'suratMasuk.instansi',
                'suratMasuk.agenda'
            ])->first();
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
            return redirect()->route('disposisi.index')
                ->with('success', 'Disposisi telah ditindak lanjuti');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal melakukan tindak lanjut ' . $e->getMessage());
        }
    }

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


        // foreach ($request->penerima as $penerimaId) {
        //     DisposisiPenerima::create([
        //         'disposisi_id' => $disposisi->id_disposisi,
        //         'user_id' => $penerimaId,
        //         'status_tugas' => 0,
        //     ]);
        // }

        return redirect()->route('disposisi.index')
            ->with('success', 'Disposisi berhasil ditambahkan');
        // return response()->json([
        //     'message' => 'Disposisi berhasil dikirim.',
        //     'data' => $disposisi,
        // ]);
    }

    // public function show(string $id)
    // {
    //     //
    // }
    public function edit($id_dis)
    {
        $disposisi = Disposisi::with([
            'penerimas:id,nama,jabatan',
            'suratMasuk.instansi',
            'suratMasuk.agenda'
        ])->findOrFail($id_dis);
        $users = User::all();
        // Pastikan perintah selalu array
        $perintah = json_decode($disposisi->perintah, true) ?? [];
        $perintah = is_array($perintah) ? $perintah : [$perintah];

        return response()->json([
            'disposisi' => $disposisi,
            'penerima' => $disposisi->penerimas->pluck('id')->toArray(),
            'perintah' => array_filter($perintah), // Hapus nilai kosong
            'users' => $users
        ]);

        // $disposisi = Disposisi::where('id_disposisi', $id_dis)
        //     ->with([
        //         'penerimas' => function ($query) {
        //             $query->select('users.id', 'users.nama') // Sesuaikan kolom user yang dibutuhkan
        //                 ->withPivot('status_tugas', 'catatan_balasan');
        //         },
        //         'suratMasuk.instansi',
        //         'suratMasuk.agenda'
        //     ])->first();
        // // echo ($disposisi->suratMasuk);
        // return view('disposisi.detailWk', compact('disposisi'));;
    }
    // public function edit(string $id)
    // {
    //     //
    // }

    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'surat_masuk_id' => 'required|integer|exists:surat_masuk,id_sm',
                'catatan' => 'required|string',
                'perintah' => 'required|array',
                'perintah.*' => 'string',
                'penerima' => 'required|array',
                'penerima.*' => 'integer|exists:users,id'
            ]);

            // Cari disposisi berdasarkan ID
            $disposisi = Disposisi::findOrFail($id);
            // Update data disposisi
            $disposisi->update([
                'surat_masuk_id' => $request->surat_masuk_id,
                'catatan' => $request->catatan,
                'perintah' => implode(', ', $request->perintah),
                'tanggal_disposisi' => now() // Jika ingin memperbarui tanggal, jika tidak bisa dihapus
            ]);

            // Siapkan data pivot
            $pivotData = array_fill_keys($request->penerima, [
                'status_tugas' => 0, // Default status
                'created_at' => now(),
                'updated_at' => now()
            ]);
            // Sync penerimas dengan data pivot
            $disposisi->penerimas()->sync($pivotData);

            return redirect()->route('disposisi.index')
                ->with('success', 'Disposisis berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        }
    }

    public function getData()
    {
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
        $users = User::all();
    }
    public function destroy(string $id)
    {
        try {
            // Cari disposisi berdasarkan ID
            $disposisi = Disposisi::findOrFail($id);

            // Hapus relasi pivot terlebih dahulu
            $disposisi->penerimas()->detach();

            // Hapus disposisi
            $disposisi->delete();

            return redirect()->route('disposisi.index')
                ->with('success', 'Disposisi berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus disposisi: ' . $e->getMessage());
        }
    }
}
