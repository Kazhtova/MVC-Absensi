@extends('layouts.main')  
@section('title', 'Dashboard Data Siswa')  
@section('content') 
    <div class="card"> 
        <div class="card-header bg-secondary text-white"> 
            <h4>Daftar Siswa Kelas XII</h4> 
        </div> 
        <div class="card-body"> 
            @if(count($siswa) > 0) 
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Lengkap</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Nilai</th>
                            <th>Keterangan Kelulusan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $index => $data)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $data['nisn'] }}</td>
                            <td>{{ $data['nama'] }}</td>
                            <td>{{ $data['kelas'] }}</td>
                            <td>
                                @if($data['status'] == 'Aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Alumni</span>
                                @endif
                            </td>
                            <td>{{ $data['nilai_akhir'] }}</td>
                            <td>
                                @if($data['nilai_akhir'] >= 75)
                                    <span class="badge bg-success">Lulus</span>
                                @else
                                    <span class="badge bg-danger">Remedial</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> 
            @else 
                <div class="alert alert-warning">                     
                    Data siswa belum tersedia. 
                </div> 
            @endif 
        </div> 
    </div> 
@endsection 
