@php
    $inisial = strtoupper(substr($pinjam->user->name, 0, 2));
    
    if ($pinjam->tipe_pinjam == 'hari') {
        $sekarang = now()->format('Y-m-d');
        $kembali = \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('Y-m-d');
        $hariTerlambat = \Carbon\Carbon::parse($kembali)->diffInDays(\Carbon\Carbon::parse($sekarang));
        $denda = $hariTerlambat * 5000;
        $keterlambatan = $hariTerlambat . ' hari';
    } else {
        $jamKembali = \Carbon\Carbon::parse($pinjam->jam_kembali);
        $jamTerlambat = floor($jamKembali->diffInHours(now()));
        $denda = $jamTerlambat * 2000;
        $keterlambatan = $jamTerlambat . ' jam';
    }
    
    $roleLabel = $pinjam->user->role == 'siswa' ? 'Siswa' : 'Petugas';
@endphp
<tr class="hover:bg-red-50 transition-colors">
    <td class="px-6 py-4">
        <input type="checkbox" class="item-checkbox w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" value="{{ $pinjam->id }}">
    </td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-lg font-mono text-sm">{{ $pinjam->kode_peminjaman ?? '-' }}</span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-700 font-semibold mr-3 uppercase">
                {{ $inisial }}
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-900">{{ $pinjam->user->name }}</p>
                <p class="text-xs text-gray-500">{{ $roleLabel }}</p>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <div>
            <p class="text-sm font-semibold text-gray-900">{{ $pinjam->barang->nama_barang }}</p>
            <p class="text-xs text-gray-500">{{ $pinjam->barang->kategori->nama_kategori ?? 'Lainnya' }}</p>
        </div>
    </td>
    <td class="px-6 py-4 text-sm text-gray-900">
        @if($pinjam->tipe_pinjam == 'hari')
            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
        @else
            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }}
        @endif
    </td>
    <td class="px-6 py-4 text-sm text-gray-900">
        @if($pinjam->tipe_pinjam == 'hari')
            {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
        @else
            {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam_jam)->format('d M Y') }} {{ $pinjam->jam_kembali }}
        @endif
    </td>
    <td class="px-6 py-4">
        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">{{ $keterlambatan }}</span>
    </td>
    <td class="px-6 py-4">
        <span class="text-sm font-bold text-red-600">Rp {{ number_format($denda, 0, ',', '.') }}</span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
            <!-- TOMBOL DETAIL BARU -->
            <button onclick="showDetailPeminjaman({{ $pinjam->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Detail Peminjaman">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </button>
            <button onclick="openReturnModal({{ $pinjam->id }})" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Proses Pengembalian">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>
            <button onclick="sendReminder({{ $pinjam->id }})" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Kirim Pengingat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
            </button>
        </div>
    </td>
</tr>