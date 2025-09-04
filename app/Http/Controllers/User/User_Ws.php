<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User\Master_pegawai;

class User_Ws extends Controller
{
    public function index()
    {
        $user = Master_pegawai::select('opd','kategori','nik','nip','nama')->get();
        $opd = Master_pegawai::select('opd')->distinct()->get();

        return view('user.ws.index',compact('user','opd'));
    }
    public function update_ws(Request $request)
    {
        $response = Http::withBasicAuth(
            config('webservice.username_kepegawaian'),
            config('webservice.password_kepegawaian')
        )->get(config('webservice.url_kepegawaian') . '/endpoint');

        if ($response->successful()) {
            $data = $response->json();
            
            foreach ($data as $key => $value) {
                $user = Master_pegawai::where('nik', $value['nik'])->first();
                Master_pegawai::updateOrCreate(
                    ['nik' => $value['nik']], // condition to check
                    [
                        'opd' => $value['opd'],
                        'kategori' => $value['kategori'],
                        'nama' => $value['nama'],
                        'nip' => $value['nip'],
                        'unit_kerja' => $value['unit_kerja'],
                        'jabatan' => $value['jabatan'],
                        'jenis_kelamin' => $value['jenis_kelamin'],
                        'tgl_lahir' => $value['tgl_lahir'],
                        'tk_pendidikan' => $value['tk_pendidikan'],
                        'golongan' => $value['golongan'],
                        'eselon' => $value['eselon'],
                        'jenisjabatan' => $value['jenisjabatan'],
                    ]
                );

                
            }
        }
        // Logic to update the web service
        // For example, you might want to call an external API or update some settings in your database

        // After updating, redirect back to the index page with a success message
        return redirect()->route('user_ws.index')->with('success', 'Web Service updated successfully.');
    }
}
