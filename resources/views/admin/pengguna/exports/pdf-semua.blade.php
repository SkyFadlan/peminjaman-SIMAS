{{-- resources/views/admin/pengguna/exports/pdf-semua.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Semua Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
            color: white;
            font-weight: bold;
            padding: 12px 8px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-petugas {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-siswa {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-aktif {
            background-color: #dcfce7;
            color: #166534;
        }
        .badge-nonaktif {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .summary {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 12px;
        }
        .summary-item {
            display: inline-block;
            margin-right: 20px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PENGGUNA</h1>
        <p>SISTEM INFORMASI MANAJEMEN ASET SEKOLAH (SIMAS)</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <strong>Total Pengguna:</strong> {{ $semuaPengguna->count() }} orang
        </div>
        <div class="summary-item">
            <strong>Petugas:</strong> {{ $semuaPengguna->where('role', 'petugas')->count() }} orang
        </div>
        <div class="summary-item">
            <strong>Siswa:</strong> {{ $semuaPengguna->where('role', 'siswa')->count() }} orang
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Email/NISN</th>
                <th>Detail</th>
                <th>Status</th>
                <th>Tgl Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semuaPengguna as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $user->name }}</strong>
                </td>
                <td>
                    <span class="badge {{ $user->role == 'petugas' ? 'badge-petugas' : 'badge-siswa' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    @if($user->role == 'petugas')
                        {{ $user->email }}
                    @else
                        NISN: {{ $user->nisn ?? '-' }}
                    @endif
                </td>
                <td>
                    @if($user->role == 'petugas')
                        @if($user->nip) NIP: {{ $user->nip }}<br>@endif
                        @if($user->jabatan) Jabatan: {{ $user->jabatan }}@endif
                    @else
                        @if($user->kelas) Kelas: {{ $user->kelas }}@endif
                    @endif
                </td>
                <td>
                    <span class="badge {{ ($user->status ?? 'aktif') == 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                        {{ ucfirst($user->status ?? 'aktif') }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak dari SIMAS - Sistem Informasi Manajemen Aset Sekolah</p>
        <p>Halaman 1 dari 1</p>
    </div>
</body>
</html>