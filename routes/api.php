<?php

use Illuminate\Support\Facades\Route;
use App\Models\Mahasiswa;

Route::get('/mahasiswa/{nim}', function ($nim) {
    return Mahasiswa::where('nim', $nim)
        ->select('nim','nama')
        ->firstOrFail();
});
