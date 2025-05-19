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
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan =  Auth::user()->jabatan;
        $userId = Auth::user()->id;
        $agenda = Agenda::all();
        if ($jabatan === 'admin' || $jabatan === 'ks') {
            $suratMasuk = SuratMasuk::with('instansi')->latest()->get();
            return view('surat-masuk.index', compact('suratMasuk', 'agenda'));
        } else {
            $suratMasuk = SuratMasuk::with('disposisi.penerimas')
                ->whereHas('disposisi.penerimas', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                })->get();
            return view('surat-masuk.index', compact('suratMasuk'));
        }
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
            'Lainnya',
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

                $instansi = Instansi::create([
                    'nama_instansi' => strtoupper($request->nama_instansi),
                    // 'nama_pengirim' =>  ucwords(strtolower($request->nama_pengirim)),
                    'jabatan_pengirim' => $request->jabatan_pengirim,
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
                $instansi = Instansi::create([
                    'nama_instansi' => $request->nama_instansi,
                    'nama_pengirim' => $request->nama_pengirim,
                    'jabatan_pengirim' => $request->jabatan_pengirim,
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


    public function print(Request $request)
    {
        // Validate date inputs
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        // Initialize the base query with date filter
        $baseQuery = SuratMasuk::whereBetween('tanggal_srt', [$startDate, $endDate]);

        // Add agenda filter if provided
        if ($request->has('id_agenda') && $request->input('id_agenda') !== null) {
            $idAgenda = $request->input('id_agenda');
            $baseQuery->where('agenda_id', $idAgenda);
        }

        // Create subquery to get the first record per agenda_id
        $subquery = clone $baseQuery;
        $subquery = $subquery->select('agenda_id', SuratMasuk::raw('MIN(tanggal_srt) as min_tanggal'))
            ->groupBy('agenda_id');

        // Main query to get full records
        $query = SuratMasuk::joinSub($subquery, 'grouped', function ($join) {
            $join->on('surat_masuk.agenda_id', '=', 'grouped.agenda_id')
                ->on('surat_masuk.tanggal_srt', '=', 'grouped.min_tanggal');
        })
            ->with(['agenda', 'instansi'])
            ->orderBy('surat_masuk.tanggal_srt', 'asc');

        // Execute the query
        $suratMasuk = $query->get();

        // // Initialize the query
        // $query = SuratMasuk::whereBetween('tanggal_srt', [$startDate, $endDate])
        //     ->with(['agenda', 'instansi'])->groupBy('agenda_id');

        // // Check if id_agenda is present in the request
        // if ($request->has('id_agenda') && $request->input('id_agenda') !== null) {
        //     $idAgenda = $request->input('id_agenda');
        //     $query->where('agenda_id', $idAgenda);
        // }
        // // Execute the query
        // $suratMasuk = $query->orderBy('tanggal_srt', 'asc')->get();

        // Generate PDF content using a view or inline HTML
        $html = view('surat-masuk.pdf', ['suratMasuk' => $suratMasuk, 'startDate' => $startDate, 'endDate' => $endDate])->render();

        // Load HTML into Dompdf wrapper with 2 cm margins
        $pdf = PDF::loadHTML($html)
            ->setPaper('a4', 'landscape')
            ->setOptions(['margin-left' => '2cm', 'margin-right' => '2cm', 'margin-top' => '2cm', 'margin-bottom' => '2cm']);

        // Return PDF download
        $fileName = 'surat_masuk_' . $startDate . '_to_' . $endDate . '.pdf';
        return $pdf->download($fileName);
    }
}
