<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data Siswa - SIMAS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        .drop-zone {
            border: 2px dashed #cbd5e1;
            transition: all 0.3s ease;
        }
        .drop-zone.drag-over {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen">
        @include('components.sidebar_admin')

        <div class="flex-1 lg:ml-64">
            <nav class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <button id="mobile-menu-button" class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900">Import Data Siswa</h1>
                            <p class="text-sm text-gray-500 mt-0.5">Import data siswa dari file Excel</p>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-4 sm:p-6 lg:px-8">
                <div class="max-w-3xl mx-auto">
                    <!-- Steps -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-cyan-50 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Panduan Import Data</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold flex-shrink-0">1</div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Download Template Excel</p>
                                        <p class="text-sm text-gray-600">Download template yang sudah disediakan untuk memudahkan pengisian data.</p>
                                        <a href="{{ route('admin.pengguna.template.download') }}" 
                                           class="inline-flex items-center mt-2 text-blue-600 hover:text-blue-700 font-medium text-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Download Template (template_import_siswa.xlsx)
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold flex-shrink-0">2</div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Isi Data di Excel</p>
                                        <p class="text-sm text-gray-600">Isi data siswa sesuai format template. Kolom bertanda (*) wajib diisi.</p>
                                        <div class="mt-2 bg-gray-50 rounded-lg p-3 text-xs">
                                            <table class="min-w-full">
                                                <thead>
                                                    <tr class="border-b border-gray-200">
                                                        <th class="text-left py-1 px-2 font-semibold">Kolom</th>
                                                        <th class="text-left py-1 px-2 font-semibold">Keterangan</th>
                                                        <th class="text-left py-1 px-2 font-semibold">Contoh</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr><td class="py-1 px-2">NISN (*)</td><td class="py-1 px-2">Nomor Induk Siswa Nasional</td><td class="py-1 px-2">12345678</td></tr>
                                                    <tr><td class="py-1 px-2">Nama Lengkap (*)</td><td class="py-1 px-2">Nama lengkap siswa</td><td class="py-1 px-2">Ahmad Fauzi</td></tr>
                                                    <tr><td class="py-1 px-2">Kelas (*)</td><td class="py-1 px-2">Kelas siswa</td><td class="py-1 px-2">XII RPL 1</td></tr>
                                                    <tr><td class="py-1 px-2">Email (Opsional)</td><td class="py-1 px-2">Email siswa</td><td class="py-1 px-2">ahmad@sch.id</td></tr>
                                                    <tr><td class="py-1 px-2">Password (Opsional)</td><td class="py-1 px-2">Default: siswa123</td><td class="py-1 px-2">siswa123</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold flex-shrink-0">3</div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Upload File Excel</p>
                                        <p class="text-sm text-gray-600">Upload file yang sudah diisi ke sistem.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Import Form -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Upload File Excel</h2>
                        </div>
                        
                        <form action="{{ route('admin.pengguna.import') }}" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf
                            
                            @if(session('error'))
                                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                                    {{ session('error') }}
                                </div>
                            @endif
                            
                            <div class="mb-6">
                                <div id="dropZone" class="drop-zone rounded-lg p-8 text-center cursor-pointer">
                                    <input type="file" name="file" id="fileInput" accept=".xlsx,.xls,.csv" class="hidden" required>
                                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-gray-600 mb-2">Drag & drop file Excel disini atau klik untuk memilih</p>
                                    <p class="text-sm text-gray-500">Support: .xlsx, .xls, .csv (Max 5MB)</p>
                                    <p id="fileName" class="mt-2 text-sm text-blue-600 hidden"></p>
                                </div>
                                @error('file')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.pengguna.index') }}" 
                                   class="px-5 py-2.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-all">
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl font-semibold hover:shadow-lg hover:shadow-blue-300 transition-all">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Import Data
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Show Import Failures if any -->
                    @if(session('import_failures'))
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-xl overflow-hidden">
                            <div class="px-6 py-4 bg-red-100 border-b border-red-200">
                                <h3 class="font-bold text-red-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Data Gagal Diimport ({{ count(session('import_failures')) }})
                                </h3>
                            </div>
                            <div class="p-4 overflow-x-auto">
                                <table class="min-w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-red-200">
                                            <th class="text-left py-2 px-3">Baris</th>
                                            <th class="text-left py-2 px-3">Error</th>
                                            <th class="text-left py-2 px-3">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(session('import_failures') as $failure)
                                            <tr class="border-b border-red-100">
                                                <td class="py-2 px-3 font-mono">{{ $failure['row'] ?? '-' }}</td>
                                                <td class="py-2 px-3 text-red-600">
                                                    @if(is_array($failure['errors']))
                                                        {{ implode(', ', $failure['errors']) }}
                                                    @else
                                                        {{ $failure['errors'] }}
                                                    @endif
                                                </td>
                                                <td class="py-2 px-3">
                                                    @if(isset($failure['values']))
                                                        <pre class="text-xs">{{ json_encode($failure['values'], JSON_PRETTY_PRINT) }}</pre>
                                                    @elseif(isset($failure['row']))
                                                        <pre class="text-xs">{{ json_encode($failure['row'], JSON_PRETTY_PRINT) }}</pre>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', () => {
            document.querySelector('aside')?.classList.toggle('-translate-x-full');
        });

        // Drag & drop functionality
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');

        dropZone.addEventListener('click', () => fileInput.click());
        
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });
        
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drag-over');
        });
        
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                updateFileName(files[0].name);
            }
        });
        
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                updateFileName(fileInput.files[0].name);
            }
        });
        
        function updateFileName(name) {
            fileName.textContent = `📄 ${name}`;
            fileName.classList.remove('hidden');
        }
    </script>
</body>
</html>