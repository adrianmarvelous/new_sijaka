<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Master_pegawai extends Model
{
    protected $table = 'master_pegawai';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'opd','kategori','nama','nik','nip','unit_kerja','jabatan',
        'jenis_kelamin','tgl_lahir','tk_pendidikan','golongan',
        'eselon','jenisjabatan'
    ];
}
