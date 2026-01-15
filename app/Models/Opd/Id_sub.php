<?php

namespace App\Models\Opd;

use Illuminate\Database\Eloquent\Model;
use App\Models\Spj\NppNpd;

class Id_sub extends Model
{
    protected $table = 'id_sub';
    protected $fillable = ['id', 'opd', 'bidang','kode_kegiatan','uraian_kegiatan','id_sub','kode_sub','uraian_sub'];
    
    public function NppNpd()
    {
        return $this->hasOne(
            NppNpd::class,
            'id_id_sub', // foreign key di tabel npp_npd
            'id'         // primary key di tabel id_sub
        );
    }
}
