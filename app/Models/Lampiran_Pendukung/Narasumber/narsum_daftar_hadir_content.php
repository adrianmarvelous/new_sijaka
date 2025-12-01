<?php

namespace App\Models\Lampiran_Pendukung\Narasumber;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_header;
use App\Models\Master\Narasumber;

class narsum_daftar_hadir_content extends Model
{
    protected $table = 'narsum_daftar_hadir_content';
    protected $fillable = [
        'id',
        'id_header',
        'id_narsum',
        'masukan',
        'no_surat',
        'id_transaksi',
        'ttd_narsum',
        'bendahara',
        'pptk',
    ];
    public function header()
    {
        return $this->belongsTo(
            narsum_daftar_hadir_header::class,
            'id_header', // foreign key di tabel content
            'id'         // primary key di tabel header
        );
    }
    public function master_narasumber()
    {
        return $this->hasOne(
            Narasumber::class,
            'id', // foreign key di tabel content
            'id_narsum'         // primary key di tabel header
        );
    }

}
