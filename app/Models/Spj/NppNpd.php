<?php

namespace App\Models\Spj;

use Illuminate\Database\Eloquent\Model;
use App\Models\Opd\Id_sub;

class NppNpd extends Model
{
    protected $table = 'npp_npd';
    protected $fillable = [
        'id',
        'id_id_sub',
        'nomer',
        'panjar_ls_kkpd',
        'sumber_dana',
        'nama_pptk',
        'nip_pptk',
        'pangkat_pptk',
        'nama_bendahara',
        'nip_bendahara',
        'pangkat_bendahara',
        'status',
        'tanggal',
    ];

    public function id_sub()
    {
        return $this->belongsTo(
            Id_sub::class,
            'id_id_sub', // foreign key di tabel npp_npd
            'id'         // primary key di tabel id_sub
        );
    }
    public function npp_npd_details()
    {
        return $this->hasMany(
            NppNpdDetail::class,
            'npp_npd', // foreign key di tabel detail
            'id'         // primary key di tabel header
        );
    }
}
