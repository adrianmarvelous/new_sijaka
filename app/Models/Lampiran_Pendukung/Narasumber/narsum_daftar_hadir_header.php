<?php

namespace App\Models\Lampiran_Pendukung\Narasumber;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_content;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_umum;

class narsum_daftar_hadir_header extends Model
{
    protected $table = 'narsum_daftar_hadir_header';
    protected $fillable = [
        'id',
        'tanggal',
        'tanggal_surat_kesediaan',
        'pukul_mulai',
        'pukul_selesai',
        'acara',
        'tempat',
        'masukan',
        'status',
        'tgl_undangan',
        'komponen',
        'paket_pekerjaan_1',
        'paket_pekerjaan_2',
        'paket_pekerjaan_3',
        'paket_pekerjaan_4',
        'pptk',
        'bidang',
        'opd',
    ];

    public function contents()
    {
        return $this->hasMany(
            narsum_daftar_hadir_content::class,
            'id_header', // foreign key di tabel content
            'id'         // primary key di tabel header
        );
    }
    public function umum()
    {
        return $this->hasMany(
            narsum_daftar_hadir_umum::class,
            'id_header', // foreign key di tabel content
            'id'         // primary key di tabel header
        );
    }

}
