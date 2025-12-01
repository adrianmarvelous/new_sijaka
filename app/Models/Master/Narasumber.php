<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_content;

class Narasumber extends Model
{
    protected $table = 'master_narasumber';

    public function master_narasumber()
    {
        return $this->belongsTo(
            narsum_daftar_hadir_content::class,
            'id', // foreign key di tabel content
            'id_narsum'         // primary key di tabel header
        );
    }
}
