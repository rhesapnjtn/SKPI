<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrganisasiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'detail_organisasi_mahasiswa';

    protected $fillable = [
        'nim',
        'id_organisasi',
         'nama_organisasi',  
        'nama', 
        'jabatan',
        'periode',
        'tanggal_bergabung',
        'status_keanggotaan',
        'tanggal_berakhir',
    ];

    protected $casts = [
        'tanggal_bergabung' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    /**
     * Relasi ke model Organisasi
     */
    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi', 'id_organisasi');
    }

    /**
     * Relasi ke model Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
