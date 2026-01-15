<?php

namespace App\Models\Spj;

use Illuminate\Database\Eloquent\Model;

class NppNpdTemp extends Model
{
    protected $table = 'npp_npd_temp';
    protected $fillable = [
        'id',
        'opd',
        'bidang',
        'id_sub',
        'paket_pekerjaan',
        'uraian',
        'alokasi',
        'rencana',
    ];
}
