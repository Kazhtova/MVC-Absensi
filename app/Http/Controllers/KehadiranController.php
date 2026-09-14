<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    public function index()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;
        $jumlahHari = Carbon::now()->daysInMonth;

        $siswas = Siswa::with(['absensi' => function ($query) use ($bulan, $tahun) {
            $query->whereMonth('waktu', $bulan)
                  ->whereYear('waktu', $tahun);
        }])->get();

        $mapel = Mapel::first();
        $guru = Guru::first();

        return view('welcome', compact('siswas', 'jumlahHari', 'bulan', 'tahun', 'mapel', 'guru'));
    }

    // TAMBAHKAN FUNGSI INI
    public function updateKehadiran(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'siswa_id'   => 'required|integer',
            'tanggal'    => 'required|integer',
            'bulan'      => 'required|integer',
            'tahun'      => 'required|integer',
            'keterangan' => 'required|string',
        ]);

        // 2. Susun format tanggal (Y-m-d)
        $waktu = Carbon::create($request->tahun, $request->bulan, $request->tanggal)->format('Y-m-d');

        // 3. Cari apakah data absen di tanggal tersebut sudah ada?
        $absen = Absensi::where('siswa_id', $request->siswa_id)
                        ->whereDate('waktu', $waktu)
                        ->first();

        if ($absen) {
            // Jika datanya diubah menjadi '-' (kosong), kita hapus saja datanya agar bersih
            if ($request->keterangan === '-') {
                $absen->delete();
            } else {
                // Jika sudah ada, update keterangannya
                $absen->update(['keterangan' => $request->keterangan]);
            }
        } else {
            // Jika belum ada & bukan '-', buat data baru
            if ($request->keterangan !== '-') {
                Absensi::create([
                    'siswa_id'   => $request->siswa_id,
                    'guru_id'    => Guru::first()->id ?? 1,
                    'mapel_id'   => Mapel::first()->id ?? 1,
                    'keterangan' => $request->keterangan,
                    'waktu'      => $waktu . ' 07:00:00', 
                ]);
            }
        }

        // 4. Kembalikan respon sukses ke Javascript
        return response()->json(['success' => true, 'message' => 'Tersimpan!']);
    }
}