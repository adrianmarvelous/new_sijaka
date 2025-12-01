<?php

namespace App\Models\Lampiran_Pendukung\Narasumber;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_header;
use App\Models\User\Master_pegawai;

class narsum_daftar_hadir_umum extends Model
{
    protected $table = 'narsum_daftar_hadir_umum';
    protected $fillable = [
        'id',
        'id_header',
        'nik',
        'status',
        'label',
    ];
    public function header()
    {
        return $this->belongsTo(
            narsum_daftar_hadir_header::class,
            'id_header', // foreign key di tabel content
            'id'         // primary key di tabel header
        );
    }
    public function master_pegawai()
    {
        return $this->hasOne(
            Master_pegawai::class,
            'nik', // foreign key di tabel content
            'nik'         // primary key di tabel header
        );
    }
}
