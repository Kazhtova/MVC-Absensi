<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Fungsi untuk Rute Statis
    public function index()
    {
    return 'Selamat Datang Siswa Kelas XII';
    }
    // Fungsi untuk Rute Dinamis
    public function detail(int $id)
    {
        $dataSiswa = [
            'id' => $id,
            'nama' => 'Ahmad Rizky',
            'kelas' => 'XII RPL 1',
            'status' => 'Aktif'
        ];
        return response()->json($dataSiswa);
    }

}