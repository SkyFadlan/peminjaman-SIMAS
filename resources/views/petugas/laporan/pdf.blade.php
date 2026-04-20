<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin-bottom: 5px;
            color: #4f46e5;
        }
        .header p {
            color: #6b7280;
            margin-top: 0;
        }
        .stats {
            margin-bottom: 30px;
            border-collapse: collapse;
            width: 100%;
        }
        .stats td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            background-color: #4f46e5;
            color: white;
            padding: 10px;
            text-align: left;
            font-size: 11px;
        }
        .table td {
            padding: 8px;
            border: 1px solid #e5e7eb;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            color: #6b7280;
            font-size: 10px;
        }
        .status-menunggu { color: #92400e; }
        .status-disetujui { color: #1e40af; }
        .status-dipinjam { color: #166534; }
        .status-dikembalikan { color: #374151; }
        .status-ditolak { color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN TRANSAKSI PEMINJAMAN</h1>
        <p>Periode: {{ $periode }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <h3>Ringkasan Statistik</h3>
    <table class="stats">
        <tr>
            <td width="50%"><strong>Total Transaksi:</strong> {{ $statistik['total'] }}</td>
            <td width="50%"><strong>Total Denda:</strong> Rp {{ number_format($statistik['total_denda'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Menunggu:</strong> {{ $statistik['menunggu'] }}</td>
            <td><strong>Disetujui:</strong> {{ $statistik['disetujui'] }}</td>
        </tr>
        <tr>
            <td><strong>Dipinjam:</strong> {{ $statistik['dipinjam'] }}</td>
            <td><strong>Dikembalikan:</strong> {{ $statistik['dikembalikan'] }}</td>
        </tr>
        <tr>
            <td><strong>Ditolak:</strong> {{ $statistik['ditolak'] }}</td>
            <td></td>
        </tr>
    </table>

    <h3>Detail Transaksi</h3>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $index => $t)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>REQ-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $t->kode_peminjaman ?? '-' }}</td>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->barang->nama_barang }}</td>
                <td>
                    @if($t->tipe_pinjam == 'hari')
                        {{ Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y') }}
                    @else
                        {{ Carbon\Carbon::parse($t->tanggal_pinjam_jam)->format('d/m/Y') }}<br>{{ $t->jam_pinjam }}
                    @endif
                </td>
                <td>
                    @if($t->tipe_pinjam == 'hari')
                        {{ Carbon\Carbon::parse($t->tanggal_kembali)->format('d/m/Y') }}
                    @else
                        {{ Carbon\Carbon::parse($t->tanggal_pinjam_jam)->format('d/m/Y') }}<br>{{ $t->jam_kembali }}
                    @endif
                </td>
                <td class="status-{{ $t->status }}">{{ ucfirst($t->status) }}</td>
                <td>{{ $t->denda > 0 ? 'Rp ' . number_format($t->denda, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name ?? 'Petugas' }}</p>
        <p>* Dokumen ini digenerate secara otomatis</p>
    </div>
</body>
</html>