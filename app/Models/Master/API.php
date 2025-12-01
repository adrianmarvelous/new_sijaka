<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class API extends Model
{
    protected $table = 'opd_credential_api';
    protected $fillable = ['id', 'opd_name', 'api_name','api_url','username','secret'];
}
