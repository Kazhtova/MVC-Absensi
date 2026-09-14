<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Absensi;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Master (5 Siswa, 1 Guru, 1 Mapel)
        Siswa::factory(5)->create();
        Guru::factory(1)->create();
        Mapel::factory(1)->create();

        // 2. Ambil data master yang baru saja di-generate
        $siswas = Siswa::all();
        $guru = Guru::first();
        $mapel = Mapel::first();

        // 3. Tentukan waktu bulan ini
        $tahun = Carbon::now()->year;
        $bulan = Carbon::now()->month;
        $jumlahHari = Carbon::now()->daysInMonth;

        // 4. Looping Absensi Sebulan Penuh
        foreach ($siswas as $siswa) {
            for ($hari = 1; $hari <= $jumlahHari; $hari++) {
                
                $tanggal = Carbon::create($tahun, $bulan, $hari);
                
                // BEST PRACTICE: Lewati hari Sabtu & Minggu (Sekolah Libur)
                if ($tanggal->isWeekend()) {
                    continue; 
                }

                // Masukkan ke database
                Absensi::create([
                    'siswa_id'   => $siswa->id,
                    'guru_id'    => $guru->id,
                    'mapel_id'   => $mapel->id,
                    // Kita perbanyak probabilitas "Hadir" agar lebih realistis
                    'keterangan' => fake()->randomElement(['Hadir', 'Hadir', 'Hadir', 'Hadir', 'Hadir', 'Izin', 'Sakit', 'Alfa']),
                    'waktu'      => $tanggal->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}