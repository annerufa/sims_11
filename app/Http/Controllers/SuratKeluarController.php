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

use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suratKeluars = SuratKeluar::with('instansi')->latest()->get(); // 'instansi' nanti kita buat relasinya
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
                // $input = $request->jabatan_pengirim;

                // preg_match('/^(.*?)\s*\((.*?)\)$/', $input, $matches);

                // $a = $matches[1] ?? $input; // "Kepala Sekolah"
                // $b = $matches[2] ?? null; // "2024-2029"

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
                $validated['file_draft'] = $request->file('file_draft')->storeAs('surat-keluar', $filename, 'public');
            }

            // Gunakan id_instansi untuk input ke surat_masuk
            $validated['tujuan'] = $instansi->id_instansi;
            $validated['status_validasi'] = 'belum';
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
        // $unreadData = SuratKeluar::where('is_read', false)->count();
        // $users = User::all();
        $dataSurat = SuratKeluar::where('id_sk', $id)->with(['instansi', 'agenda', 'validator'])->first();
        // $disposisi = Disposisi::where('surat_masuk_id', $id)->with(['penerimas.user'])->get();
        // $dataSurat->is_read = true;
        // return view('surat-masuk.detail', compact('dataSurat', 'users', 'unreadData', 'disposisi'));
        return view('surat-keluar.create', [
            'data' => $dataSurat,
            'listInstansi' => $listInstansi,
            'validator' => $users,
            'agenda' => $agenda,
            'jenisSuratOptions' => $jenisSuratOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
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


        // jika ada file diupload lagi
        if ($request->hasFile('file_draft')) {
            // Hapus file lama jika ada
            if ($suratKeluar->file_draft) {
                Storage::delete($suratKeluar->file_draft);
            }
            $validated['file_draft'] = $request->file('file_draft')->store('surat-keluar');
        }


        if ($request->hasFile('file_draft')) {
            $filename = 'surat-' . time() . '.' . $request->file('file_draft')->getClientOriginalExtension();
            $validated['file_draft'] = $request->file('file_draft')->storeAs('surat-keluar', $filename, 'public');
        }

        $suratKeluar->update($validated);

        return redirect()->route('surat-keluar.index')
            ->with('success', 'Surat keluar berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
