<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_umum;

class Master_pegawai extends Model
{
    protected $table = 'master_pegawai';
    protected $primaryKey = 'id';
    // public $timestamps = false;

    protected $fillable = [
        'opd','kategori','nama','nik','nip','unit_kerja','jabatan',
        'jenis_kelamin','tgl_lahir','tk_pendidikan','golongan',
        'eselon','jenisjabatan'
    ];
    public function master_pegawai()
    {
        return $this->belongsTo(
            narsum_daftar_hadir_umum::class,
            'nik', // foreign key di tabel content
            'nik'         // primary key di tabel header
        );
    }
}
