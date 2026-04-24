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
        
        /* Styling untuk searchable dropdown */
        .dropdown-container {
            position: relative;
        }
        
        .dropdown-search {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 14px;
            outline: none;
            transition: all 0.2s;
        }
        
        .dropdown-search:focus {
            border-color: #3b82f6;
            ring: 2px solid rgba(59,130,246,0.2);
        }
        
        .dropdown-options {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            max-height: 280px;
            overflow-y: auto;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            margin-top: 4px;
            z-index: 50;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            display: none;
        }
        
        .dropdown-options.show {
            display: block;
        }
        
        .dropdown-option {
            padding: 12px 16px;
            cursor: pointer;
            transition: background 0.2s;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .dropdown-option:hover {
            background-color: #f1f5f9;
        }
        
        .dropdown-option.selected {
            background-color: #eff6ff;
            color: #2563eb;
        }
        
        .dropdown-option .option-name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
        }
        
        .dropdown-option .option-detail {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }
        
        .selected-display {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            background: white;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
        }
        
        .selected-display:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }
        
        .selected-display .selected-info {
            flex: 1;
        }
        
        .selected-display .selected-name {
            font-weight: 600;
            font-size: 14px;
            color: #1e293b;
        }
        
        .selected-display .selected-detail {
            font-size: 12px;
            color: #64748b;
        }
        
        .dark .selected-display {
            background: #1e293b;
            border-color: #334155;
            color: white;
        }
        
        .dark .dropdown-options {
            background: #1e293b;
            border-color: #334155;
        }
        
        .dark .dropdown-option {
            border-bottom-color: #334155;
        }
        
        .dark .dropdown-option:hover {
            background-color: #334155;
        }
        
        .dark .dropdown-option .option-name {
            color: #f1f5f9;
        }
        
        .dark .dropdown-option .option-detail {
            color: #94a3b8;
        }
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
                                <!-- SEARCHABLE DROPDOWN SISWA -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 dark:text-slate-300 mb-2">Siswa (Peminjam)</label>
                                    <div class="dropdown-container">
                                        <div class="selected-display" id="selectedDisplay">
                                            <div class="selected-info">
                                                <div class="selected-name" id="selectedName">-- Pilih Siswa --</div>
                                                <div class="selected-detail" id="selectedDetail">Pilih siswa dari daftar</div>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                        
                                        <div class="dropdown-options" id="dropdownOptions">
                                            <input type="text" 
                                                   id="searchSiswa" 
                                                   class="dropdown-search" 
                                                   placeholder="🔍 Cari nama atau NISN..."
                                                   autocomplete="off">
                                            <div id="siswaList" class="max-h-64 overflow-y-auto">
                                                @foreach($users as $user)
                                                    @php
                                                        $kelasDisplay = $user->kelas ?? '-';
                                                        if($user->role == 'siswa' && isset($user->kelas)) {
                                                            $kelasDisplay = $user->kelas;
                                                        }
                                                    @endphp
                                                    <div class="dropdown-option" 
                                                         data-id="{{ $user->id }}"
                                                         data-name="{{ $user->name }}"
                                                         data-nisn="{{ $user->nisn ?? '-' }}"
                                                         data-kelas="{{ $kelasDisplay }}">
                                                        <div class="option-name">{{ $user->name }}</div>
                                                        <div class="option-detail">
                                                            NISN: {{ $user->nisn ?? '-' }} | Kelas: {{ $kelasDisplay }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="user_id" id="selectedUserId" required>
                                    @error('user_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
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

                                <div>
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
                                            <label class="text-xs font-bold text-gray-400 uppercase">Tanggal Ambil</label>
                                            <input type="text" name="tanggal_pinjam_display" value="{{ date('d/m/Y') }}" class="w-full mt-1 bg-transparent border-b-2 border-gray-200 dark:border-slate-700 dark:text-white" readonly>
                                            <input type="hidden" name="tanggal_pinjam" value="{{ date('Y-m-d') }}">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-gray-400 uppercase">Tanggal Kembali</label>
                                            <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full mt-1 bg-transparent border-b-2 border-gray-200 dark:border-slate-700 dark:text-white focus:border-blue-500 transition-colors">
                                        </div>
                                    </div>
                                </div>

                                <div id="div_jam" class="hidden space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase">Tanggal</label>
                                        <input type="text" name="tanggal_pinjam_jam_display" value="{{ date('d/m/Y') }}" class="w-full mt-1 bg-transparent border-b-2 border-gray-200 dark:border-slate-700 dark:text-white" readonly>
                                        <input type="hidden" name="tanggal_pinjam_jam" value="{{ date('Y-m-d') }}">
                                    </div>
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
        let selectedValue = null;
        
        // Fungsi untuk toggle dropdown
        function toggleDropdown() {
            const options = document.getElementById('dropdownOptions');
            options.classList.toggle('show');
        }
        
        // Fungsi untuk memilih siswa
        function selectSiswa(element) {
            const id = element.getAttribute('data-id');
            const name = element.getAttribute('data-name');
            const nisn = element.getAttribute('data-nisn');
            const kelas = element.getAttribute('data-kelas');
            
            selectedValue = id;
            document.getElementById('selectedUserId').value = id;
            document.getElementById('selectedName').innerHTML = name;
            document.getElementById('selectedDetail').innerHTML = `NISN: ${nisn} | Kelas: ${kelas}`;
            
            // Update active class
            document.querySelectorAll('.dropdown-option').forEach(opt => {
                opt.classList.remove('selected');
            });
            element.classList.add('selected');
            
            // Tutup dropdown
            document.getElementById('dropdownOptions').classList.remove('show');
        }
        
        // Fungsi untuk filter pencarian
        function filterSiswa() {
            const searchTerm = document.getElementById('searchSiswa').value.toLowerCase();
            const options = document.querySelectorAll('.dropdown-option');
            
            options.forEach(option => {
                const name = option.getAttribute('data-name').toLowerCase();
                const nisn = option.getAttribute('data-nisn').toLowerCase();
                const kelas = option.getAttribute('data-kelas').toLowerCase();
                
                if (name.includes(searchTerm) || nisn.includes(searchTerm) || kelas.includes(searchTerm)) {
                    option.style.display = '';
                } else {
                    option.style.display = 'none';
                }
            });
        }
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const container = document.querySelector('.dropdown-container');
            if (container && !container.contains(event.target)) {
                document.getElementById('dropdownOptions').classList.remove('show');
            }
        });
        
        // Event listeners
        document.getElementById('selectedDisplay').addEventListener('click', toggleDropdown);
        document.getElementById('searchSiswa').addEventListener('keyup', filterSiswa);
        
        // Register click handlers for all options
        document.querySelectorAll('.dropdown-option').forEach(option => {
            option.addEventListener('click', function() {
                selectSiswa(this);
            });
        });
        
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
        
        function updateDetailBuku() {
            const select = document.getElementById('barang_id');
            const selectedOption = select.options[select.selectedIndex];
            const stok = selectedOption.getAttribute('data-stok');
            const jumlahInput = document.querySelector('input[name="jumlah"]');
            
            if (jumlahInput && stok) {
                jumlahInput.max = stok;
                if (parseInt(jumlahInput.value) > parseInt(stok)) {
                    jumlahInput.value = stok;
                }
            }
        }
    </script>
</body>
</html>