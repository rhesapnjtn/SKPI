<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailOrganisasiMahasiswa;
use App\Models\User;
use App\Models\Kegiatan;

class Organisasi extends Model
{
    use HasFactory;

    // nama tabel di database
    protected $table = 'organisasis';

    // kolom yang boleh diisi
    protected $fillable = [
        'nama_organisasi',
        'fakultas'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // relasi ke anggota organisasi
    public function anggota()
    {
        return $this->hasMany(
            DetailOrganisasiMahasiswa::class,
            'id_organisasi',
            'id'
        );
    }

    // relasi ke user login organisasi
    public function user()
    {
        return $this->hasOne(
            User::class,
            'organisasi_id',
            'id'
        );
    }

    // relasi ke kegiatan organisasi
    public function kegiatans()
    {
        return $this->hasMany(
            Kegiatan::class,
            'id_organisasi',
            'id'
        );
    }
}