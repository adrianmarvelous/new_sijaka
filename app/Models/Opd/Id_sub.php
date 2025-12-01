<?php

namespace App\Models\Opd;

use Illuminate\Database\Eloquent\Model;

class Id_sub extends Model
{
    protected $table = 'id_sub';
    protected $fillable = ['id', 'opd', 'bidang','kode_kegiatan','uraian_kegiatan','id_sub','kode_sub','uraian_sub'];
}
