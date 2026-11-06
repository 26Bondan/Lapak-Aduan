<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permohonan Informasi</title>
    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f0ebf8;
        }
    </style>
</head>
<body class="py-8 px-4 flex justify-center">

    <div class="w-full max-w-2xl">
        
        <!-- Pesan Sukses -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Banner / Header Card -->
        <div class="bg-white rounded-lg shadow-md border-t-8 border-purple-700 p-6 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Formulir Permohonan Informasi</h1>
            <p class="text-xs text-gray-500 mb-2">Any files that are uploaded will be shared outside of the organization they belong to.</p>
            <p class="text-xs text-red-600 font-medium">* Indicates required question</p>
        </div>

        <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Card 1: Nama Lengkap -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label for="nama_lengkap" class="block text-sm font-semibold text-gray-800 uppercase tracking-wide mb-4">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                    placeholder="Your answer"
                    class="w-full max-w-md border-b border-gray-300 focus:border-purple-600 outline-none py-1 text-sm transition-colors">
                @error('nama_lengkap')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Card 2: Jenis Pemohon -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label class="block text-sm font-semibold text-gray-800 uppercase tracking-wide mb-4">
                    Jenis Pemohon <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                    @php
                        $opsi = [
                            'PERORANGAN', 
                            'MAHASISWA', 
                            'KELOMPOK MASYARAKAT', 
                            'LSM/ORGANISASI', 
                            'BADAN HUKUM', 
                            'INSTANSI PEMERINTAH', 
                            'MEDIA MASSA'
                        ];
                    @endphp

                    @foreach ($opsi as $item)
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="jenis_pemohon" value="{{ $item }}" 
                                {{ old('jenis_pemohon') == $item ? 'checked' : '' }}
                                class="w-4 h-4 text-purple-600 focus:ring-purple-500 border-gray-300">
                            <span class="text-xs font-medium text-gray-700 tracking-wider">{{ $item }}</span>
                        </label>
                    @endforeach
                </div>
                @error('jenis_pemohon')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Card 3: Nama Instansi/Organisasi -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label for="nama_instansi" class="block text-sm font-medium text-gray-800 mb-4">
                    Nama Instansi/Organisasi <span class="text-gray-500 italic text-xs">(Jika ada)</span>
                </label>
                <input type="text" id="nama_instansi" name="nama_instansi" value="{{ old('nama_instansi') }}" 
                    placeholder="Your answer"
                    class="w-full max-w-md border-b border-gray-300 focus:border-purple-600 outline-none py-1 text-sm transition-colors">
            </div>

            <!-- Card 4: Alamat Lengkap -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label for="alamat_lengkap" class="block text-sm font-semibold text-gray-800 uppercase tracking-wide mb-4">
                    Alamat Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" id="alamat_lengkap" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}" 
                    placeholder="Your answer"
                    class="w-full max-w-md border-b border-gray-300 focus:border-purple-600 outline-none py-1 text-sm transition-colors">
                @error('alamat_lengkap')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Card 5: Nomor HP/WhatsApp -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label for="nomor_hp" class="block text-sm font-semibold text-gray-800 mb-4">
                    Nomor HP/WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp') }}" 
                    placeholder="Your answer"
                    class="w-full max-w-md border-b border-gray-300 focus:border-purple-600 outline-none py-1 text-sm transition-colors">
                @error('nomor_hp')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Card 6: Uraian Informasi -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label for="uraian_informasi" class="block text-sm font-semibold text-gray-800 mb-4">
                    Uraian Informasi yang Dimohon <span class="text-gray-600 text-xs font-normal">(Jelaskan informasi secara rinci dan lengkap)</span> <span class="text-red-500">*</span>
                </label>
                <input type="text" id="uraian_informasi" name="uraian_informasi" value="{{ old('uraian_informasi') }}" 
                    placeholder="Your answer"
                    class="w-full border-b border-gray-300 focus:border-purple-600 outline-none py-1 text-sm transition-colors">
                @error('uraian_informasi')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Card 7: Upload Dokumen -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <label class="block text-sm font-semibold text-gray-800 mb-1">
                    Upload Dokumen <span class="text-gray-600 text-xs font-normal">(jika ada)</span>
                </label>
                <p class="text-xs text-gray-500 mb-4">Upload up to 5 supported files. Max 10 MB per file.</p>
                
                <div class="inline-block">
                    <label for="dokumen" class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-purple-700 bg-white hover:bg-purple-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add file
                    </label>
                    <input type="file" id="dokumen" name="dokumen[]" multiple class="hidden" onchange="showFileNames(this)">
                </div>
                <div id="file-list" class="mt-2 text-xs text-gray-600"></div>
                @error('dokumen.*')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-2">
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-2 rounded shadow-md text-sm transition-colors">
                    Submit
                </button>
                <button type="reset" onclick="document.getElementById('file-list').innerText = ''" class="text-purple-600 hover:text-purple-800 text-xs font-medium">
                    Clear form
                </button>
            </div>

        </form>
    </div>

    <script>
        function showFileNames(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            if (input.files.length > 0) {
                const names = Array.from(input.files).map(f => f.name).join(', ');
                fileList.innerText = 'File terpilih: ' + names;
            }
        }
    </script>
</body>
</html>