<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pinjam Langsung - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-slate-950">

    <div class="flex">
        @include('components.sidebar_admin')

        <main class="ml-64 flex-1 p-8">
            <div class="max-w-4xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Peminjaman Buku Instan</h1>
                    <p class="text-gray-500 dark:text-slate-400 mt-1">Formulir untuk petugas mencatat peminjaman siswa di tempat.</p>
                </div>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center text-green-700">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 shadow-sm rounded-3xl overflow-hidden">
                    <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="p-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Siswa (Peminjam)</label>
                                    <select name="user_id" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:bg-slate-800 dark:border-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500" required>
                                        <option value="">-- Pilih Siswa --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->nisn }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Buku / Alat</label>
                                    <select name="barang_id" id="barang_id" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:bg-slate-800 dark:border-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500" required onchange="updateDetailBuku()">
                                        <option value="" data-stok="0" data-foto="">-- Pilih Buku --</option>
                                        
                                        @foreach($barangs as $barang)
                                            <option value="{{ $barang->id }}" 
                                                    data-stok="{{ $barang->jumlah }}" 
                                                    data-foto="{{ asset('storage/barang/' . $barang->gambar) }}">
                                                {{ $barang->nama_barang }} (Tersedia: {{ $barang->jumlah }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mt-6">
    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Alasan Peminjaman</label>
    <textarea 
        name="alasan" 
        rows="3" 
        class="w-full px-4 py-3 rounded-xl border-gray-200 dark:bg-slate-800 dark:border-slate-700 dark:text-white focus:ring-2 focus:ring-blue-500 @error('alasan') border-red-500 @enderror" 
        placeholder="Contoh: Untuk tugas kelompok mata pelajaran Sejarah"
        required>{{ old('alasan') }}</textarea>
    @error('alasan')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Jumlah</label>
                                    <input type="number" name="jumlah" value="1" min="1" class="w-full px-4 py-3 rounded-xl border-gray-200 dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-slate-800/50 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-3">Tipe Durasi</label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <button type="button" onclick="setTipe('hari')" id="btnHari" class="py-2 rounded-lg border-2 border-blue-500 bg-blue-50 text-blue-600 font-bold">Harian</button>
                                        <button type="button" onclick="setTipe('jam')" id="btnJam" class="py-2 rounded-lg border-2 border-transparent bg-white dark:bg-slate-800 text-gray-500 font-bold">Per Jam</button>
                                    </div>
                                    <input type="hidden" name="tipe_pinjam" id="tipe_pinjam" value="hari">
                                </div>

                                <div id="div_hari" class="space-y-4">
                                    <div class="grid grid-cols-1 gap-4">
                                        <div>
                                            <label class="text-xs font-bold text-gray-400 uppercase">Tgl Kembali</label>
                                            <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full mt-1 bg-transparent border-b-2 border-gray-200 dark:border-slate-700 dark:text-white focus:border-blue-500 transition-colors">
                                        </div>
                                    </div>
                                    <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                </div>

                                <div id="div_jam" class="hidden space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="text-xs font-bold text-gray-400 uppercase">Jam Mulai</label>
                                            <input type="time" name="jam_pinjam" value="{{ date('H:i') }}" class="w-full mt-1 bg-transparent border-b-2 border-gray-200 dark:text-white">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-400 uppercase">Jam Selesai</label>
                                            <input type="time" name="jam_kembali" value="{{ date('H:i', strtotime('+2 hours')) }}" class="w-full mt-1 bg-transparent border-b-2 border-gray-200 dark:text-white">
                                        </div>
                                    </div>
                                    <input type="hidden" name="tanggal_pinjam_jam" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-blue-200 dark:shadow-none transition-all transform hover:-translate-y-1">
                                KONFIRMASI PINJAMAN SEKARANG
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function setTipe(tipe) {
            const btnHari = document.getElementById('btnHari');
            const btnJam = document.getElementById('btnJam');
            const divHari = document.getElementById('div_hari');
            const divJam = document.getElementById('div_jam');
            const inputTipe = document.getElementById('tipe_pinjam');

            inputTipe.value = tipe;

            if(tipe === 'hari') {
                btnHari.className = "py-2 rounded-lg border-2 border-blue-500 bg-blue-50 text-blue-600 font-bold";
                btnJam.className = "py-2 rounded-lg border-2 border-transparent bg-white dark:bg-slate-800 text-gray-500 font-bold";
                divHari.classList.remove('hidden');
                divJam.classList.add('hidden');
            } else {
                btnJam.className = "py-2 rounded-lg border-2 border-blue-500 bg-blue-50 text-blue-600 font-bold";
                btnHari.className = "py-2 rounded-lg border-2 border-transparent bg-white dark:bg-slate-800 text-gray-500 font-bold";
                divJam.classList.remove('hidden');
                divHari.classList.add('hidden');
            }
        }
    </script>
</body>
</html>