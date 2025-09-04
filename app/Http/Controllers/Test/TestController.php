<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\Master_pegawai;

class TestController extends Controller
{
    public function index()
    {
        return view('test.index');
    }
    public function make_users()
    {
        $pegawai = Master_pegawai::get();

        foreach ($pegawai as $p) {
            if ($p->opd == 'Badan Kepegawaian dan Pengembangan Sumber Daya Manusia') {
                
                // pick nip if exists, otherwise nik
                $username = $p->nip ?: $p->nik;

                \App\Models\User::updateOrCreate(
                    // Condition to find the user
                    ['username' => $username],
                    // Data to update or create
                    [
                        'username'   => $username,
                        'name'       => $p->nama,
                        'user_type'  => 'pegawai',
                        'id_pegawai' => $p->id,
                        'password'   => bcrypt($username), // default password
                    ]
                );
            }
        }

        return redirect()->route('test.index')->with('success', 'Users created/updated successfully.');
    }


}
