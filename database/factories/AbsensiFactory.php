<?php

namespace Database\Factories;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbsensiFactory extends Factory
{
    protected $model = Absensi::class;

    public function definition(): array
    {
        return [
            // Mengambil ID secara acak dari data yang sudah di-seed
            'siswa_id'   => Siswa::inRandomOrder()->first()?->id ?? Siswa::factory(),
            'guru_id'    => Guru::inRandomOrder()->first()?->id ?? Guru::factory(),
            'mapel_id'   => Mapel::inRandomOrder()->first()?->id ?? Mapel::factory(),
            'keterangan' => $this->faker->randomElement(['Hadir', 'Izin', 'Sakit', 'Alfa']),
            'waktu'      => $this->faker->dateTimeThisMonth(),
        ];
    }
}