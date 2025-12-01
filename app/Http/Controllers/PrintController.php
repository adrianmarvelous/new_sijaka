<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_header;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_content;

use PDF;

class PrintController extends Controller
{
    public function saran_masukan($id)
    {
        $data = narsum_daftar_hadir_content::with('header','master_narasumber')
                    ->where('id',base64_decode($id))
                    ->first();
                    // dd($data);

        $pdf = PDF::loadView('print.narasumber.example', [
            'data' => $data
        ]);


        return $pdf->stream('document.pdf');
    }
}
