<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Surat Masuk Report</title>
    <style>
        /* General resets */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 10px 20px;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .date-range {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
            color: #7f8c8d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        thead {
            background-color: #3498db;
            color: white;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #e1f5fe;
        }

        .footer {
            font-size: 10px;
            text-align: center;
            color: #95a5a6;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Rekap Surat Keluar</h1>
        <div class="date-range">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d m Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d m Y') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:8%;">Agenda</th>
                    <th style="width:5%;">Nomor Urut</th>
                    <th style="width:20%;">Nomor Surat</th>
                    <th style="width:10%;">Tanggal Surat</th>
                    {{-- <th style="width:20%;">No Surat</th> --}}
                    <th style="width:25%;">Tujuan</th>
                    <th style="width:25%;">Perihal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratKeluar as $index => $surat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $surat->agenda->nama_bagian }} </td>
                        <td>{{ $surat->nomor_urut }} </td>
                        <td>{{ $surat->agenda->kode_bagian }}/{{ $surat->nomor_urut }}/ 101.6.11.13 /
                            {{ \Carbon\Carbon::parse($surat->tanggal_terima)->format('Y') }}</td>
                        {{-- <td>{{ $surat->nomor_urut//\Carbon\Carbon::parse($surat->tanggal_terima)->format('d-m-Y') }}</td> --}}
                        <td>{{ \Carbon\Carbon::parse($surat->tanggal_terima)->format('d-m-Y') }}</td>
                        <td>{{ $surat->instansi->nama_instansi }}</td>
                        <td>{{ $surat->perihal }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Tidak ada data untuk periode tersebut.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            &copy; {{ date('Y') }} - Sistem Informasi Manajemen Surat
        </div>
    </div>
</body>

</html>
