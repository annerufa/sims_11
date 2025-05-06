<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Instansi;
use App\Models\Agenda;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan =  Auth::user()->jabatan;
        $userId = Auth::user()->id;
        // if ($jabatan !== 'admin' || $jabatan !== 'ks') {
        //     $suratKeluars = SuratKeluar::where('status_validasi', ['final', 'disetujui'])->with('instansi')->latest()->get(); // 'instansi' nanti kita buat relasinya
        // } else {
        $suratKeluars = SuratKeluar::with('instansi')->latest()->get(); // 'instansi' nanti kita buat relasinya

        // }
        return view('surat-keluar.index', compact('suratKeluars'));
    }
    public function validasiShow()
    {
        $suratKeluars = SuratKeluar::where('validator_id', Auth::user()->id)
            ->whereNotIn('status_validasi', ['final', 'disetujui'])
            ->with('instansi')->latest()->paginate(2); // 'instansi' nanti kita buat relasinya
        return view('surat-keluar.indexDraft', compact('suratKeluars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::whereNotIn('jabatan', ['ks', 'admin'])->get();
        $listInstansi = Instansi::all();
        $agenda = Agenda::all();
        $jenisSuratOptions = [
            'Surat Dinas',
            'Undangan',
            'Surat Keputusan',
            'Surat Permohonan',
            'Surat Izin',
            'Surat Pemberitahuan',
            'Surat Lamaran',
        ];
        return view('surat-keluar.create', [
            'data' => null,
            'listInstansi' => $listInstansi,
            'validator' => $users,
            'agenda' => $agenda,
            'jenisSuratOptions' => $jenisSuratOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // seluruh isi function

            $validated = $request->validate([
                'jenis_srt' => 'required',
                'pengaju' => 'required',
                'validator_id' => 'required',
                'agenda_id' => 'required',
                'perihal' => 'required',
                'file_draft' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            // Cari instansi berdasarkan nama
            $instansi = Instansi::where('id_instansi', $request->tujuan)->first();

            // Jika belum ada, buat baru
            if (!$instansi) {

                $instansi = Instansi::create([
                    'nama_instansi' => strtoupper($request->nama_instansi),
                    'nama_pengirim' =>  ucwords(strtolower($request->nama_pengirim)),
                    'jabatan_pengirim' => $request->jabatan_pengirim,
                    // 'jabatan_pengirim' => $a,
                    // 'periode_pengirim' => $b,
                    'alamat_pengirim' => $request->alamat_pengirim,
                ]);
            }


            if ($request->hasFile('file_draft')) {
                $filename = 'surat-' . time() . '.' . $request->file('file_draft')->getClientOriginalExtension();
                // Simpan ke public/surat-masuk
                $request->file('file_draft')->move(public_path('suratKeluar'), $filename);
                // Simpan path relatif ke database 
                $validated['file_draft'] = 'suratKeluar/' . $filename;
            }

            // Gunakan id_instansi untuk input ke surat_masuk
            $validated['tujuan'] = $instansi->id_instansi;
            $validated['status_validasi'] = 'draft';
            // $validated['status_draft'] = false;
            $validated['user_id'] = Auth::user()->id;

            // Cari nomor urut terakhir untuk divisi ini
            $lastNumber = SuratKeluar::where('agenda_id', $request->agenda_id)
                ->max('nomor_urut'); // cari nomor urut terbesar

            $validated['nomor_urut'] = $lastNumber ? $lastNumber + 1 : 1;
            $validated['pengaju'] = $request->pengaju;
            SuratKeluar::create($validated);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // $unreadData = SuratMasuk::where('is_read', false)->count();
        // $users = User::all();
        $dataSurat = SuratKeluar::where('id_sk', $id)->with(['instansi', 'agenda', 'validator'])->first();
        // $disposisi = Disposisi::where('surat_masuk_id', $id)->with(['penerimas.user'])->get();
        // $dataSurat->is_read = true;
        // dd($dataSurat->validator);
        return view('surat-keluar.detail', compact('dataSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function arsipSk(string $id)
    {
        $data = SuratKeluar::where('id_sk', $id)->with(['instansi', 'agenda', 'validator'])->first();
        return view('surat-keluar.arsip', compact('data'));
    }

    public function edit(string $id)
    {
        $users = User::whereNotIn('jabatan', ['ks', 'admin'])->get();
        $listInstansi = Instansi::all();
        $agenda = Agenda::all();
        $jenisSuratOptions = [
            'Surat Dinas',
            'Undangan',
            'Surat Keputusan',
            'Surat Permohonan',
            'Surat Izin',
            'Surat Pemberitahuan',
            'Surat Lamaran',
        ];

        $dataSurat = SuratKeluar::where('id_sk', $id)->with(['instansi', 'agenda', 'validator'])->first();

        if ($dataSurat->status_validasi === 'direvisi') {
            $status_revisi = 1;
            return view('surat-keluar.revisi', [
                'data' => $dataSurat,
                'listInstansi' => $listInstansi,
                'validator' => $users,
                'agenda' => $agenda,
                'jenisSuratOptions' => $jenisSuratOptions,
                'status_revisi' => $status_revisi,
            ]);
        } else {
            return view('surat-keluar.create', [
                'data' => $dataSurat,
                'listInstansi' => $listInstansi,
                'validator' => $users,
                'agenda' => $agenda,
                'jenisSuratOptions' => $jenisSuratOptions,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        try {
            $validated = $request->validate([
                'jenis_srt' => 'required',
                'pengaju' => 'required',
                'validator_id' => 'required',
                'agenda_id' => 'required',
                'perihal' => 'required',
            ]);

            // Cari instansi berdasarkan nama
            $instansi = Instansi::where('id_instansi', $request->tujuan)->first();
            if (!$instansi) {
                $instansi = Instansi::create([
                    'nama_instansi' => strtoupper($request->nama_instansi),
                    'nama_pengirim' =>  ucwords(strtolower($request->nama_pengirim)),
                    'jabatan_pengirim' => $request->jabatan_pengirim,
                    // 'jabatan_pengirim' => $a,
                    // 'periode_pengirim' => $b,
                    'alamat_pengirim' => $request->alamat_pengirim,
                ]);
            }

            // Gunakan id_instansi untuk input ke surat_masuk
            $validated['tujuan'] = $instansi->id_instansi;


            if ($request->hasFile('file_draft')) {
                $filename = 'surat-' . time() . '.' . $request->file('file_draft')->getClientOriginalExtension();
                // Simpan ke public/surat-masuk
                $request->file('file_draft')->move(public_path('suratKeluar'), $filename);
                // Simpan path relatif ke database 
                $validated['file_draft'] = 'suratKeluar/' . $filename;
            }
            $suratKeluar->update($validated);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat keluar berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        }
    }
    public function revisiDone(Request $request, $id)
    {
        dd("Revisi Done for ID: " . $id); // Debug test
        // try {
        //     $validated = $request->validate([
        //         'jenis_srt' => 'required',
        //         'pengaju' => 'required',
        //         'validator_id' => 'required',
        //         'agenda_id' => 'required',
        //         'perihal' => 'required',
        //     ]);

        //     // Cari instansi berdasarkan nama
        //     $instansi = Instansi::where('id_instansi', $request->tujuan)->first();
        //     if (!$instansi) {
        //         $instansi = Instansi::create([
        //             'nama_instansi' => strtoupper($request->nama_instansi),
        //             'nama_pengirim' =>  ucwords(strtolower($request->nama_pengirim)),
        //             'jabatan_pengirim' => $request->jabatan_pengirim,
        //             // 'jabatan_pengirim' => $a,
        //             // 'periode_pengirim' => $b,
        //             'alamat_pengirim' => $request->alamat_pengirim,
        //         ]);
        //     }

        //     // Gunakan id_instansi untuk input ke surat_masuk
        //     $validated['tujuan'] = $instansi->id_instansi;

        //     $validated['status_validasi'] = 'telah direvisi';
        //     // $validated['status_validasi'] = 'telah direvisi';


        //     if ($request->hasFile('file_draft')) {
        //         $filename = 'surat-' . time() . '.' . $request->file('file_draft')->getClientOriginalExtension();
        //         // Simpan ke public/surat-masuk
        //         $request->file('file_draft')->move(public_path('suratKeluar'), $filename);
        //         // Simpan path relatif ke database 
        //         $validated['file_draft'] = 'suratKeluar/' . $filename;
        //     }
        //     $suratKeluar->update($validated);
        //     echo ($suratKeluar);
        //     // return redirect()->route('surat-keluar.index')
        //     //     ->with('success', 'Surat keluar berhasil diperbarui');
        // } catch (\Exception $e) {
        //     return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(suratKeluar $suratKeluar)
    {

        if ($suratKeluar->file_draft && File::exists(public_path($suratKeluar->file_draft))) {
            File::delete(public_path($suratKeluar->file_draft));
        }

        $suratKeluar->delete();

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil dihapus');
    }
    public function uploadArsip(Request $request, $id)
    {
        try {
            $url_file_fiks = '';
            if ($request->hasFile('file_fiks')) {
                $filename = 'surat-' . time() . '.' . $request->file('file_fiks')->getClientOriginalExtension();
                // Simpan ke public/surat-masuk
                $request->file('file_fiks')->move(public_path('suratKeluar'), $filename);
                // Simpan path relatif ke database 
                $url_file_fiks = 'suratKeluar/' . $filename;
            }

            SuratKeluar::where('id_sk', $id)->update([
                'file_fiks' => $url_file_fiks,
                'status_validasi' => 'final'
            ]);

            return redirect()->route('surat-keluar.index')
                ->with('success', 'Surat keluar berhasil diarsipkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengarsipkan surat keluar: ' . $e->getMessage());
        }
    }
    public function setujui($id)
    {
        SuratKeluar::where('id_sk', $id)->update([
            'status_validasi' => 'disetujui',
        ]);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil disetujui');
    }
    public function revisi(Request $request)
    {
        SuratKeluar::where('id_sk', $request->id_sk)->update([
            'catatan_revisi' => $request->catatan_revisi,
            'status_validasi' => 'direvisi',
        ]);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil direvisi');
    }
}
