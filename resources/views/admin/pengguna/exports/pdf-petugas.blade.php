{{-- resources/views/admin/pengguna/exports/pdf-petugas.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Data Petugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2563eb;
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
        }
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA PETUGAS</h1>
        <p>SISTEM INFORMASI MANAJEMEN ASET SEKOLAH (SIMAS)</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($petugas as $index => $user)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $user->name }}</strong></td>
                <td>{{ $user->nip ?? '-' }}</td>
                <td>{{ $user->jabatan ?? '-' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->status ?? 'aktif') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Petugas: {{ $petugas->count() }} orang | Dicetak dari SIMAS</p>
    </div>
</body>
</html>