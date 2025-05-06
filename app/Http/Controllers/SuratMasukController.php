<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Instansi;
use App\Models\Agenda;
use App\Models\Disposisi;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan =  Auth::user()->jabatan;
        $userId = Auth::user()->id;
        if ($jabatan === 'admin' || $jabatan === 'ks') {
            $suratMasuk = SuratMasuk::with('instansi')->latest()->get();
        } else {
            $suratMasuk = SuratMasuk::with('disposisi.penerimas')
                ->whereHas('disposisi.penerimas', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                })->get();
        }

        return view('surat-masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
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
        return view('surat-masuk.create', [
            'data' => null,
            'listInstansi' => $listInstansi,
            'agenda' => $agenda,
            'jenisSuratOptions' => $jenisSuratOptions,
        ]);
        // return view('surat-masuk.create', compact('listInstansi', 'agenda'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'jenis_srt' => 'required',
                'sifat_srt' => 'required',
                'nomor_srt' => 'required',
                'tanggal_srt' => 'required|date',
                'tanggal_terima' => 'required|date',
                'agenda_id' => 'required',
                'perihal' => 'required',
                'lampiran' => 'nullable',
                'keterangan' => 'nullable',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);
            $tanggal_srt = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_srt)->format('Y-m-d');
            $tanggal_terima = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_terima)->format('Y-m-d');

            // Cari instansi berdasarkan nama
            $instansi = Instansi::where('id_instansi', $request->pengirim)->first();

            // Jika belum ada, buat baru
            if (!$instansi) {
                $input = $request->jabatan_pengirim;

                preg_match('/^(.*?)\s*\((.*?)\)$/', $input, $matches);

                $a = $matches[1] ?? $input; // "Kepala Sekolah"
                $b = $matches[2] ?? null; // "2024-2029"

                $instansi = Instansi::create([
                    'nama_instansi' => $request->nama_instansi,
                    'nama_pengirim' => $request->nama_pengirim,
                    'jabatan_pengirim' => $a,
                    'periode_pengirim' => $b,
                    'alamat_pengirim' => $request->alamat_pengirim,
                ]);
            }

            if ($request->hasFile('file')) {
                $filename = 'surat-' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                // Simpan ke public/surat-masuk
                $request->file('file')->move(public_path('suratMasuk'), $filename);
                // Simpan path relatif ke database 
                $validated['file'] = 'suratMasuk/' . $filename;
            }

            $validated['id_pengirim'] = $instansi->id_instansi;
            $validated['tanggal_terima'] = $tanggal_terima;
            $validated['tanggal_srt'] = $tanggal_srt;
            $validated['is_read'] = false;
            $validated['user_id'] = Auth::user()->id;

            // Cari nomor urut terakhir untuk divisi ini
            $lastNumber = SuratMasuk::where('agenda_id', $request->agenda_id)
                ->max('nomor_urut');
            $validated['nomor_urut'] = $lastNumber ? $lastNumber + 1 : 1;

            SuratMasuk::create($validated);

            return redirect()->route('surat-masuk.index')
                ->with('success', 'Surat masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        }
    }

    public function show($id)
    {

        // $unreadData = SuratMasuk::where('is_read', false)->count();
        $users = User::all();
        $dataSurat = SuratMasuk::where('id_sm', $id)->with(['instansi', 'agenda'])->first();
        // $disposisi = Disposisi::where('surat_masuk_id', $id)->with(['penerimas.user'])->get();
        $disposisi = Disposisi::where('surat_masuk_id', $id)->with(['penerimas'])->get();
        if (Auth::user()->jabatan === 'ks') {
            $dataSurat->is_read = 1;
            $dataSurat->save();
        }
        // dd($dataSurat);
        // dd($disposisi);
        return view('surat-masuk.detail', compact('dataSurat', 'users', 'disposisi'));
    }

    public function edit($id)
    {
        $data = SuratMasuk::where('id_sm', $id)->with('instansi')->first();
        // $data = SuratMasuk::where('id_sm', $id)->first();
        // $data = $id->load('instansi');
        // $data = $id;


        $jenisSuratOptions = [
            'Surat Dinas',
            'Undangan',
            'Surat Keputusan',
            'Surat Permohonan',
            'Surat Izin',
            'Surat Pemberitahuan',
            'Surat Lamaran',
        ];
        // $data = SuratMasuk::findOrFail($id);
        $listInstansi = Instansi::all();
        $agenda = Agenda::all();

        return view('surat-masuk.create', [
            'data' => $data,
            'listInstansi' => $listInstansi,
            'agenda' => $agenda,
            'jenisSuratOptions' => $jenisSuratOptions,
        ]);

        //return view('surat-masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        try {
            $validated = $request->validate([
                'jenis_srt' => 'required',
                'sifat_srt' => 'required',
                'nomor_srt' => 'required',
                'tanggal_srt' => 'required|date',
                'tanggal_terima' => 'required|date',
                'pengirim' => 'required',
                'perihal' => 'required',
                'lampiran' => 'nullable',
                'keterangan' => 'nullable',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);
            // Cari instansi berdasarkan nama
            $instansi = Instansi::where('id_instansi', $request->pengirim)->first();

            // Jika belum ada, buat baru
            if (!$instansi) {
                $input = $request->jabatan_pengirim;

                preg_match('/^(.*?)\s*\((.*?)\)$/', $input, $matches);

                $a = $matches[1] ?? $input; // "Kepala Sekolah"
                $b = $matches[2] ?? null; // "2024-2029"

                $instansi = Instansi::create([
                    'nama_instansi' => $request->nama_instansi,
                    'nama_pengirim' => $request->nama_pengirim,
                    'jabatan_pengirim' => $a,
                    'periode_pengirim' => $b,
                    'alamat_pengirim' => $request->alamat_pengirim,
                ]);
            }

            if ($request->hasFile('file')) {
                $filename = 'surat-' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                // Simpan ke public/surat-masuk
                $request->file('file')->move(public_path('suratMasuk'), $filename);
                // Simpan path relatif ke database 
                $validated['file'] = 'suratMasuk/' . $filename;
            }

            // Gunakan id_instansi untuk input ke surat_masuk

            $tanggal_srt = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_srt)->format('Y-m-d');
            $tanggal_terima = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_terima)->format('Y-m-d');

            $validated['id_pengirim'] = $instansi->id_instansi;
            $validated['tanggal_terima'] = $tanggal_terima;
            $validated['tanggal_srt'] = $tanggal_srt;


            $suratMasuk->update($validated);

            return redirect()->route('surat-masuk.index')
                ->with('success', 'Surat masuk berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        }
    }

    public function destroy(SuratMasuk $suratMasuk)
    {

        if ($suratMasuk->file_draft && File::exists(public_path($suratMasuk->file_draft))) {
            File::delete(public_path($suratMasuk->file_draft));
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus');
    }
}
