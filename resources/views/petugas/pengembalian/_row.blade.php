@php
    $inisial = strtoupper(substr($pinjam->user->name, 0, 2));
    $warna = ['from-indigo-500 to-violet-400', 'from-pink-500 to-purple-400', 'from-green-500 to-teal-400', 'from-orange-500 to-amber-400', 'from-blue-500 to-cyan-400'][$loop->index % 5];
    
    $tglKembali = \Carbon\Carbon::parse($pinjam->tanggal_kembali);
    $selisih = $tglKembali->diffInDays(now(), false);
    
    // 🔥 PERBAIKAN: Hapus profile->kelas, ganti dengan role saja
    $roleLabel = $pinjam->user->role == 'siswa' ? 'Siswa' : ($pinjam->user->role == 'guru' ? 'Guru' : 'Staff');
@endphp
<tr class="hover:bg-indigo-50 transition-colors">
    <td class="px-6 py-4">
        <input type="checkbox" class="item-checkbox w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500" value="{{ $pinjam->id }}">
    </td>
    <td class="px-6 py-4">
        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-lg font-mono text-sm">{{ $pinjam->kode_peminjaman ?? '-' }}</span>
    </td>
    <td class="px-6 py-4">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-gradient-to-br {{ $warna }} rounded-full flex items-center justify-center text-white font-semibold mr-3 uppercase">
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
    <td class="px-6 py-4 text-sm text-gray-900">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
    <td class="px-6 py-4 text-sm text-gray-900">{{ $tglKembali->format('d M Y') }}</td>
    <td class="px-6 py-4">
        @if($selisih > 0)
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">{{ $selisih }} hari lagi</span>
        @elseif($selisih == 0)
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">Hari ini</span>
        @else
            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">{{ abs($selisih) }} hari terlambat</span>
        @endif
    </td>
    <td class="px-6 py-4 text-sm text-gray-600">{{ $pinjam->user->no_telp ?? '-' }}</td>
    <td class="px-6 py-4">
        <div class="flex items-center space-x-2">
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