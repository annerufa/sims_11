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
        <h1>Rekap Surat Masuk</h1>
        <div class="date-range">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:10%;">Agenda</th>
                    <th style="width:10%;">Nomor Urut</th>
                    <th style="width:10%;">Nomor Surat</th>
                    <th style="width:15%;">Tanggal Terima</th>
                    {{-- <th style="width:20%;">No Surat</th> --}}
                    <th style="width:25%;">Pengirim</th>
                    <th style="width:25%;">Perihal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suratMasuk as $index => $surat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $surat->agenda->nama_bagian }} </td>
                        <td>{{ $surat->nomor_urut }} </td>
                        <td>{{ $surat->nomor_srt }}</td>
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
            &copy; {{ date('Y') }} - Sistem Surat Masuk
        </div>
    </div>
</body>

</html>
