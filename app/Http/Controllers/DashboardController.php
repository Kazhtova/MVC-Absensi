<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
    $siswa = [
        ['nisn' => '00123', 'nama' => 'Budi Santoso', 'kelas' => 'XII RPL 1', 'status' => 'Aktif', 'nilai_akhir' => 85],
        ['nisn' => '00124', 'nama' => 'Siti Aminah', 'kelas' => 'XII RPL 1', 'status' => 'Aktif', 'nilai_akhir' => 70],
        ['nisn' => '00125', 'nama' => 'Rudi Hermawan', 'kelas' => 'XII RPL 2', 'status' => 'Alumni', 'nilai_akhir' => 60],
        ['nisn' => '00126', 'nama' => 'Dewi Lestari', 'kelas' => 'XII RPL 2', 'status' => 'Aktif', 'nilai_akhir' => 90],
    ];

    return view('dashboard', compact('siswa'));
    }
}