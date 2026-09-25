<?php

use Illuminate\Support\Facades\Route;

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