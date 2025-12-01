<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User\Master_pegawai;
use App\Models\Opd\Id_sub;
use App\Rules\SafeInput;

class SettingOpdController extends Controller
{
    public function index()
    {
        $opd = session('opd');
        $data = Master_pegawai::select('unit_kerja')
                                ->distinct()
                                ->where('opd', $opd)
                                ->where(function($q) {
                                    $q->where('unit_kerja', 'LIKE', '%Bidang%')
                                    ->orWhere('unit_kerja', 'LIKE', '%Sekretariat%');
                                })
                                ->get();

        foreach($data as &$dataa){
            $dataa->kegiatan = Id_sub::where('opd', $opd)
                                        ->where('bidang', $dataa->unit_kerja)
                                        ->get();
        }
        
        return view('admin.setting_opd.bidang',compact('data','opd'));
    }

    public function store_id_sub(Request $request)
    {
        $validated = $request->validate([
            'kode_kegiatan' => ['required', 'string', 'max:255', new SafeInput],
            'uraian_kegiatan' => ['required', 'string', 'max:255', new SafeInput],
            'id_sub'  => ['required', 'string', 'max:255', new SafeInput],
            'kode_sub'  => ['required', 'string', 'max:255', new SafeInput],
            'uraian_sub'  => ['required', 'string', 'max:255', new SafeInput],
            'opd'  => ['required', 'string', 'max:255', new SafeInput],
            'bidang'  => ['required', 'string', 'max:255', new SafeInput],
        ]);
        
        DB::beginTransaction();

        try {
            $id_sub = new Id_sub();
            $id_sub->opd = $validated['opd'];
            $id_sub->bidang = $validated['bidang'];
            $id_sub->kode_kegiatan = $validated['kode_kegiatan'];
            $id_sub->uraian_kegiatan = $validated['uraian_kegiatan'];
            $id_sub->id_sub = $validated['id_sub'];
            $id_sub->kode_sub = $validated['kode_sub'];
            $id_sub->uraian_sub = $validated['uraian_sub'];

            $id_sub->save();
            DB::commit();

            return redirect()->route('setting_opd.index')
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'API berhasil disimpan.'
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }
    public function update_id_sub(Request $request)
    {
        $validated = $request->validate([
            'id_kegiatan' => ['required', 'integer', new SafeInput],
            'kode_kegiatan' => ['required', 'string', 'max:255', new SafeInput],
            'uraian_kegiatan' => ['required', 'string', 'max:255', new SafeInput],
            'id_sub'  => ['required', 'string', 'max:255', new SafeInput],
            'kode_sub'  => ['required', 'string', 'max:255', new SafeInput],
            'uraian_sub'  => ['required', 'string', 'max:255', new SafeInput],
            'opd'  => ['required', 'string', 'max:255', new SafeInput],
            'bidang'  => ['required', 'string', 'max:255', new SafeInput],
        ]);
        
        DB::beginTransaction();

        try {
            $id_sub = Id_sub::find($validated['id_kegiatan']);
            $id_sub->opd = $validated['opd'];
            $id_sub->bidang = $validated['bidang'];
            $id_sub->kode_kegiatan = $validated['kode_kegiatan'];
            $id_sub->uraian_kegiatan = $validated['uraian_kegiatan'];
            $id_sub->id_sub = $validated['id_sub'];
            $id_sub->kode_sub = $validated['kode_sub'];
            $id_sub->uraian_sub = $validated['uraian_sub'];

            $id_sub->save();
            DB::commit();

            return redirect()->route('setting_opd.index')
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'ID SUB berhasil diupdate.'
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }
    public function hapus_id_sub($id_kegiatan)
    {
        DB::beginTransaction();

        try {
            $id_sub = Id_sub::find($id_kegiatan);
            $id_sub->delete();
            DB::commit();

            return redirect()->route('setting_opd.index')
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'ID SUB berhasil dihapus.'
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }
}
