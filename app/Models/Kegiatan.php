<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailKegiatanMahasiswa;
use App\Models\Mahasiswa;
use App\Models\Organisasi;

class Kegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'tanggal_kegiatan',
        'jenis_kegiatan',
        'deskripsi',
        'id_organisasi',
    ];

    // relasi ke detail kegiatan mahasiswa
    public function detailMahasiswa()
    {
        return $this->hasMany(
            DetailKegiatanMahasiswa::class,
            'kegiatan_id_ref',
            'id'
        );
    }

    // relasi mahasiswa langsung via pivot
    public function mahasiswa()
    {
        return $this->belongsToMany(
            Mahasiswa::class,
            'detail_kegiatan_mahasiswa',
            'kegiatan_id_ref',
            'mahasiswa_nim',
            'id',
            'nim'
        );
    }

    // RELASI KE ORGANISASI (PASTIKAN PRIMARY KEY = 'id')
    public function organisasi()
    {
        return $this->belongsTo(
            Organisasi::class,
            'id_organisasi', // foreign key di tabel kegiatans
            'id'             // primary key tabel organisasis
        );
    }
}