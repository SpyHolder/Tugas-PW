<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return view('welcome');
});

 
Route::get('/latihan-php', function () { 
    $nama = 'Mohd Ikhsan Sadillah'; 
    $nilai = [70, 75, 60, 50]; 
 
    $hitungRataRata = function (array $data): float { 
        $total = 0; 
        foreach ($data as $angka) { 
            $total += $angka; 
        } 
        return $total / count($data); 
    }; 
 
    $rataRata = $hitungRataRata($nilai); 
    if ($rataRata >= 75) { 
        $status = 'Lulus'; 
    } else { 
        $status = 'Perlu Perbaikan'; 
    } 
 
    return view('latihan-php', compact( 
        'nama', 'nilai', 'rataRata', 'status' 
    )); 
}); 

Route::get('/form-mahasiswa', function () {
    return view('form-mahasiswa');
});

Route::post('/form-mahasiswa', function (Request $req) {
    $dataBersih = [
        'nim' => strip_tags(trim((int) $req->input('nim'))),
        'nama' => strip_tags(trim((string) $req->input('nama'))),
        'email' => filter_var((string) $req->input('email'),FILTER_SANITIZE_EMAIL),
        'usia' => trim((string) $req->input('usia'))
    ];
    
    $validator = Validator::make($dataBersih,[
        'nim' =>['required','min:8','max:12'],
        'nama' =>['required','min:3','max:50'],
        'email' =>['required','email'],
        'usia' =>['required','integer','min:17','max:60'],
    ],[
        'nim.min' => 'NIM minimal 8 karakter.',
        'nim.max' => 'NIM maksimal 12 karakter.',
        'nim.require' => 'NIM wajib diisi.',
        'nim.integer' => 'NIM harus berupa angka.',
        'nama.required' => 'Nama wajib diisi.',
        'nama.min' => 'Nama minimal 3 karakter.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'usia.required' => 'Usia wajib diisi.',
        'usia.integer' => 'Usia harus berupa angka.',
        'usia.min' => 'Usia minimal 17 tahun.',
        'usia.max' => 'Usia maksimal 60 tahun.',
    ]);
    if ($validator->fails()) {
        return redirect('/form-mahasiswa')
            ->withErrors($validator)
            ->withInput();
    }

    $data = $validator->validated();
    $data['usia'] = (int) $data['usia'];

    return view('hasil-form', ['data' => $data]);

});

Route::get('/mahasiswa/{nim?}', function (?string $nim = null) {
    try {
        $pdo = DB::connection()->getPdo();

        $sql = 'select m.nim,m.nama,m.email,m.usia,p.nama_prodi from mahasiswa as m join program_studi as p on p.id = m.program_studi_id';

        if ($nim !== null) {
            $sql .= ' where m.nim = :nim';
        }

        $sql .= ' Order by m.nim';

        $statement = $pdo->prepare($sql);
        $statement->execute($nim !== null ? ['nim' => $nim] : []);

        $daftarMhs = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return view('mahasiswa',compact('daftarMhs','nim'));

    } catch (\Throwable $th) {
        report($th);

        return response('Koneksi Gagal',500);
    }
});