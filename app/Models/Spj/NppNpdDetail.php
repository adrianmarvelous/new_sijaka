<?php

namespace App\Models\Spj;

use Illuminate\Database\Eloquent\Model;

class NppNpdDetail extends Model
{
    protected $table = 'npp_npd_detail';
    protected $fillable = [
        'id',
        'npp_npd',
        'rekening',
        'paket_pekerjaan',
        'uraian',
        'anggaran',
        'pencairan',
    ];

    public function npp_npd()
    {
        return $this->belongsTo(
            NppNpd::class,
            'npp_npd', // foreign key di tabel detail
            'id'         // primary key di tabel header
        );
    }
}
