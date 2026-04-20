<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin-bottom: 5px;
            color: #4f46e5;
        }
        .stats {
            margin-bottom: 30px;
            border-collapse: collapse;
            width: 100%;
        }
        .stats td {
            padding: 8px;
            border: 1px solid #ddd;
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
        }
        .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            color: #666;
        }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4f46e5; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Cetak Laporan
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #6b7280; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Tutup
        </button>
    </div>

    <div class="header">
        <h1>LAPORAN TRANSAKSI PEMINJAMAN</h1>
        <p>Periode: {{ $periode }}</p>
        <p>Dicetak: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table class="stats">
        <tr>
            <td><strong>Total Transaksi:</strong> {{ $statistik['total'] }}</td>
            <td><strong>Total Denda:</strong> Rp {{ number_format($statistik['total_denda'], 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Menunggu:</strong> {{ $statistik['menunggu'] }}</td>
            <td><strong>Disetujui:</strong> {{ $statistik['disetujui'] }}</td>
        </tr>
        <tr>
            <td><strong>Dipinjam:</strong> {{ $statistik['dipinjam'] }}</td>
            <td><strong>Dikembalikan:</strong> {{ $statistik['dikembalikan'] }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
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
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->barang->nama_barang }}</td>
                <td>
                    @if($t->tipe_pinjam == 'hari')
                        {{ Carbon\Carbon::parse($t->tanggal_pinjam)->format('d/m/Y') }}
                    @else
                        {{ Carbon\Carbon::parse($t->tanggal_pinjam_jam)->format('d/m/Y') }} {{ $t->jam_pinjam }}
                    @endif
                </td>
                <td>
                    @if($t->tipe_pinjam == 'hari')
                        {{ Carbon\Carbon::parse($t->tanggal_kembali)->format('d/m/Y') }}
                    @else
                        {{ Carbon\Carbon::parse($t->tanggal_pinjam_jam)->format('d/m/Y') }} {{ $t->jam_kembali }}
                    @endif
                </td>
                <td>{{ ucfirst($t->status) }}</td>
                <td>{{ $t->denda > 0 ? 'Rp ' . number_format($t->denda, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ Auth::user()->name ?? 'Petugas' }}</p>
        <p>{{ now()->format('d F Y H:i:s') }}</p>
    </div>

    <script>
        window.onload = function() {
            // Auto print? Uncomment baris di bawah jika ingin otomatis print
            // window.print();
        }
    </script>
</body>
</html>