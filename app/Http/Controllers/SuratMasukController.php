<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Instansi;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $suratMasuk = SuratMasuk::latest()->paginate(10);
        $suratMasuk = SuratMasuk::with('instansi')->get();

        return view('surat-masuk.index', compact('suratMasuk'));
    }

    public function create()
    {
        $listInstansi = Instansi::all();
        $agenda = Agenda::all();
        return view('surat-masuk.create', compact('listInstansi', 'agenda'));
    }

    public function store(Request $request)
    {

        try {
            // seluruh isi function

            $validated = $request->validate([
                'jenis_srt' => 'required',
                'sifat_srt' => 'required',
                'nomor_srt' => 'required',
                'tanggal_srt' => 'required|date',
                'tanggal_terima' => 'required|date',
                'agenda' => 'required',
                'perihal' => 'required',
                'lampiran' => 'nullable',
                'keterangan' => 'nullable',
                'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);
            $tanggal_srt = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_srt)->format('Y-m-d');
            $tanggal_terima = \Carbon\Carbon::createFromFormat('d-m-Y', $request->tanggal_terima)->format('Y-m-d');


            // Cari instansi berdasarkan nama
            $instansi = Instansi::where('nama_instansi', $request->nama_instansi)->first();

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
                $validated['file'] = $request->file('file')->storeAs('surat-masuk', $filename);
            }

            // Gunakan id_instansi untuk input ke surat_masuk
            $validated['id_pengirim'] = $instansi->id_instansi;
            $validated['tanggal_terima'] = $tanggal_terima;
            $validated['tanggal_srt'] = $tanggal_srt;

            $validated['user_id'] = Auth::user()->id;

            SuratMasuk::create($validated);

            return redirect()->route('surat-masuk.index')
                ->with('success', 'Surat masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan surat masuk: ' . $e->getMessage());
        }
    }

    public function show(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'nomor_surat' => 'required|unique:surat_masuk,nomor_surat,' . $suratMasuk->id,
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'lampiran' => 'nullable',
            'keterangan' => 'nullable',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($suratMasuk->file) {
                Storage::delete($suratMasuk->file);
            }
            $validated['file'] = $request->file('file')->store('surat-masuk');
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil diperbarui');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->file) {
            Storage::delete($suratMasuk->file);
        }

        $suratMasuk->delete();

        return redirect()->route('surat-masuk.index')
            ->with('success', 'Surat masuk berhasil dihapus');
    }
}
