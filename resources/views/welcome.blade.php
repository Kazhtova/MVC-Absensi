<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Daftar Hadir Murid (MVC)</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .select-absen {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans p-6 lg:p-10 min-h-screen">

    <div class="max-w-7xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-lg border border-gray-200">
        <div class="mb-6 border-b border-gray-300 pb-4 flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-4 uppercase tracking-wide">Daftar Hadir Murid</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex"><span class="w-32 font-semibold">Mata Pelajaran</span><span>: {{ $mapel ? $mapel->nama_mapel : '-' }}</span></div>
                    <div class="flex"><span class="w-32 font-semibold">Bulan</span><span>: {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}</span></div>
                    <div class="flex"><span class="w-32 font-semibold">Nama Guru</span><span>: {{ $guru ? $guru->nama_guru : '-' }}</span></div>
                    <div class="flex"><span class="w-32 font-semibold">Kelas</span><span>: XI RPL (Statis)</span></div>
                </div>
            </div>
            <div id="loading-indicator" class="hidden text-sm bg-green-100 text-green-700 px-3 py-1 rounded shadow">
                Menyimpan...
            </div>
        </div>

        <!-- Tabel Kalender Absensi -->
        <div class="overflow-x-auto rounded-lg border border-gray-300 relative">
            <table class="min-w-max w-full border-collapse bg-white text-sm">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-300">
                        <th rowspan="2" class="border-r border-gray-300 px-4 py-3 text-center w-12 font-semibold">No</th>
                        <th rowspan="2" class="border-r border-gray-300 px-4 py-3 text-left w-64 font-semibold sticky left-0 bg-gray-100 z-10 shadow-[1px_0_0_0_#d1d5db]">Nama Murid</th>
                        <th colspan="{{ $jumlahHari }}" class="px-2 py-2 text-center font-semibold border-b border-gray-300">Tanggal</th>
                    </tr>
                    <tr class="bg-gray-50 border-b border-gray-300">
                        @for($i = 1; $i <= $jumlahHari; $i++)
                            <th class="border-r border-gray-300 px-2 py-2 min-w-[35px] text-center text-xs font-semibold text-gray-600">{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                        <tr class="border-b border-gray-200 hover:bg-yellow-50 transition-colors">
                            <td class="border-r border-gray-200 px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="border-r border-gray-200 px-4 py-2 font-medium text-gray-800 sticky left-0 bg-white hover:bg-yellow-50 z-10 shadow-[1px_0_0_0_#e5e7eb]">
                                {{ $siswa->nama_siswa }}
                            </td>

                            <!-- Looping Data Kehadiran Harian -->
                            @for($i = 1; $i <= $jumlahHari; $i++)
                                @php
                                    $absenHariIni = $siswa->absensi->first(function($absen) use ($i) {
                                        return \Carbon\Carbon::parse($absen->waktu)->day == $i;
                                    });

                                    $keteranganDb = $absenHariIni ? $absenHariIni->keterangan : '-';
                                    
                                    // Tentukan warna font awal
                                    $warna = 'text-gray-300';
                                    if ($keteranganDb === 'Hadir') $warna = 'text-green-600';
                                    elseif ($keteranganDb === 'Izin') $warna = 'text-blue-600';
                                    elseif ($keteranganDb === 'Sakit') $warna = 'text-yellow-600';
                                    elseif ($keteranganDb === 'Alfa') $warna = 'text-red-600';
                                @endphp
                                
                                <td class="border-r border-gray-200 px-0 py-0 text-center relative hover:bg-gray-100">
                                    <!-- Elemen Select Dropdown -->
                                    <select onchange="simpanAbsen(this)" 
                                        data-siswa="{{ $siswa->id }}" 
                                        data-tanggal="{{ $i }}" 
                                        data-bulan="{{ $bulan }}" 
                                        data-tahun="{{ $tahun }}"
                                        class="select-absen w-full h-full py-2 px-1 text-center font-bold bg-transparent cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-400 {{ $warna }}">
                                        
                                        <option value="-" class="text-gray-400" {{ $keteranganDb === '-' ? 'selected' : '' }}>-</option>
                                        <option value="Hadir" class="text-green-600" {{ $keteranganDb === 'Hadir' ? 'selected' : '' }}>H</option>
                                        <option value="Izin" class="text-blue-600" {{ $keteranganDb === 'Izin' ? 'selected' : '' }}>I</option>
                                        <option value="Sakit" class="text-yellow-600" {{ $keteranganDb === 'Sakit' ? 'selected' : '' }}>S</option>
                                        <option value="Alfa" class="text-red-600" {{ $keteranganDb === 'Alfa' ? 'selected' : '' }}>A</option>
                                    </select>
                                </td>
                            @endfor
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $jumlahHari + 2 }}" class="px-4 py-8 text-center text-gray-500 italic">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 flex gap-4 text-xs text-gray-600">
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-green-500 rounded-sm"></span> Hadir (H)</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-blue-500 rounded-sm"></span> Izin (I)</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-yellow-500 rounded-sm"></span> Sakit (S)</span>
            <span class="flex items-center gap-1"><span class="w-3 h-3 bg-red-500 rounded-sm"></span> Alfa (A)</span>
        </div>
    </div>

    <!-- SCRIPT AJAX BROWSER NATIVE (Vanilla Javascript) -->
    <script>
        function simpanAbsen(element) {
            // 1. Ambil data dari atribut HTML
            const siswa_id = element.getAttribute('data-siswa');
            const tanggal = element.getAttribute('data-tanggal');
            const bulan = element.getAttribute('data-bulan');
            const tahun = element.getAttribute('data-tahun');
            const keterangan = element.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            element.classList.remove('text-green-600', 'text-blue-600', 'text-yellow-600', 'text-red-600', 'text-gray-300');
            if(keterangan === 'Hadir') element.classList.add('text-green-600');
            else if(keterangan === 'Izin') element.classList.add('text-blue-600');
            else if(keterangan === 'Sakit') element.classList.add('text-yellow-600');
            else if(keterangan === 'Alfa') element.classList.add('text-red-600');
            else element.classList.add('text-gray-300');

            const loading = document.getElementById('loading-indicator');
            loading.classList.remove('hidden');

            // 3. Kirim data ke backend Laravel tanpa refresh
            fetch("{{ route('update.kehadiran') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify({
                    siswa_id: siswa_id,
                    tanggal: tanggal,
                    bulan: bulan,
                    tahun: tahun,
                    keterangan: keterangan
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    setTimeout(() => { loading.classList.add('hidden'); }, 500);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Terjadi kesalahan jaringan, gagal menyimpan data.");
                loading.classList.add('hidden');
            });
        }
    </script>
</body>
</html>