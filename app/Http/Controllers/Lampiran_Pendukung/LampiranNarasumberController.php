<?php

namespace App\Http\Controllers\Lampiran_Pendukung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_header;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_content;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_umum;
use App\Models\User\Master_pegawai;
use App\Models\Master\Narasumber;
use App\Models\Master\API;
use App\Models\Opd\Id_sub;
use PhpParser\Node\Stmt\Foreach_;
use App\Rules\SafeInput;


class LampiranNarasumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the month from query parameter, default to current month if not provided
        $bulan = $request->query('bulan', date('n'));
        $tahun = $request->query('tahun', date('Y'));
        $bidang = session('bidang');
        $narsum_daftar_hadir_header = narsum_daftar_hadir_header::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('bidang', $bidang)
            ->get();
        // dd($narsum_daftar_hadir_header);

        return view('lampiran_pendukung.narasumber.index', compact('bulan', 'narsum_daftar_hadir_header'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opd = session('opd');
        $bidang = session('bidang');
        $tahun = session('tahun', date('Y'));

        $id_subs = Id_sub::select('id_sub')
            ->where('opd', $opd)
            ->where('bidang', $bidang)
            ->get();


        $url = API::where('opd_name', $opd)
            ->where('api_name', 'f1')
            ->value('api_url');
        $url = $url . $tahun;

        // 2. Panggil API tanpa auth
        $response = Http::get($url);
        // dd($response->json());


        $allPekerjaan = collect(); // tampung semua

        foreach ($id_subs as $id_sub) {

            $filteredData = collect($response->json())
                ->where('sub_id', $id_sub->id_sub)
                ->filter(function ($item) {
                    return str_contains($item['nama_pekerjaan'], 'Honorarium');
                })
                ->unique('pekerjaan_id')
                ->values();

            // simpan ke global
            $allPekerjaan = $allPekerjaan->merge($filteredData);
        }

        // remove duplicate setelah digabung
        $allPekerjaan = $allPekerjaan->unique('pekerjaan_id')->values();

        // dd($allPekerjaan);
        return view('lampiran_pendukung.narasumber.create', compact('allPekerjaan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'tanggal'               => ['required', 'date', new SafeInput],
            'acara'                 => ['required', 'string', 'max:255', new SafeInput],
            'tempat'                => ['required', 'string', 'max:255', new SafeInput],
            'pukul_mulai'           => ['required', 'string', 'max:10', new SafeInput],
            'pukul_selesai'         => ['required', 'string', 'max:10', new SafeInput],
            'tgl_undangan'          => ['required', 'date', new SafeInput],
            'komponen'              => ['required', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_1'      => ['nullable', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_2'      => ['nullable', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_3'      => ['nullable', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_4'      => ['nullable', 'string', 'max:255', new SafeInput],
        ]);

        DB::beginTransaction();

        try {

            $data = new narsum_daftar_hadir_header(); // ganti dengan model milikmu

            $data->tanggal              = $validated['tanggal'];
            $data->acara                = $validated['acara'];
            $data->tempat               = $validated['tempat'];
            $data->pukul_mulai          = $validated['pukul_mulai'];
            $data->pukul_selesai        = $validated['pukul_selesai'];
            $data->tgl_undangan        = $validated['tgl_undangan'];
            $data->komponen             = $validated['komponen'];
            $data->paket_pekerjaan_1     = $validated['paket_pekerjaan_1'] ?? null;
            $data->paket_pekerjaan_2     = $validated['paket_pekerjaan_2'] ?? null;
            $data->paket_pekerjaan_3     = $validated['paket_pekerjaan_3'] ?? null;
            $data->paket_pekerjaan_4     = $validated['paket_pekerjaan_4'] ?? null;
            $data->bidang               = session('bidang');
            $data->opd                  = session('opd');

            $data->save();

            DB::commit();

            return redirect()
                ->route('lampiran_narasumber.show', $data->id)
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'Data berhasil disimpan.'
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


    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $tahun = session('tahun', date('Y'));
        $bulan = date('m');
        $opd = session('opd');

        $header = narsum_daftar_hadir_header::with([
            'contents.master_narasumber',
            'umum.master_pegawai'
        ])->find($id);
        $paket = [
            "paket_pekerjaan_1" => $header->paket_pekerjaan_1,
            "paket_pekerjaan_2" => $header->paket_pekerjaan_2,
            "paket_pekerjaan_3" => $header->paket_pekerjaan_3,
            "paket_pekerjaan_4" => $header->paket_pekerjaan_4,
        ];

        $master_narsum = Narasumber::get();
        $api_db = API::where('opd_name', session('opd'))
            ->where('api_name', 'id_transaksi')
            ->first();

        $url_base = str_replace('{tahun}', $tahun, $api_db->api_url);

        $response = [];

        $master_pegawai = Master_pegawai::where('opd', $opd)->get();
        foreach ($paket as $value) {

            if (!$value) continue;

            $url = $url_base . $value;

            $api = Http::withBasicAuth($api_db->username, $api_db->secret)
                ->get($url)
                ->json();

            // Filter immediately
            $filtered = collect($api['data'] ?? [])
                ->filter(function ($item) use ($tahun, $bulan) {
                    $date = strtotime($item['tanggal_transaksi']['date']);
                    return date('Y', $date) == $tahun &&
                        date('m', $date) == $bulan;
                })
                ->values()
                ->toArray();

            $id_transaksi[] = $filtered;
        }
        // dd($id_transaksi);

        return view('lampiran_pendukung.narasumber.detail_acara', compact('header', 'master_narsum', 'id_transaksi', 'id','master_pegawai'));
    }
    public function tambah_narasumber(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'narasumber'        => ['required', 'numeric', new SafeInput],
            'no_surat'          => ['nullable', 'string', 'max:1000000', new SafeInput],
            'id_transaksi'      => ['nullable', 'string', 'max:1000000', new SafeInput],
            'id'                => ['required', 'numeric', 'max:1000000', new SafeInput],
        ]);
        DB::beginTransaction();

        try {

            $data = new narsum_daftar_hadir_content(); // ganti dengan model milikmu

            $data->id_narsum        = $validated['narasumber'];
            $data->no_surat         = $validated['no_surat'];
            $data->id_transaksi     = $validated['id_transaksi'];
            $data->id_header        = $validated['id'];

            $data->save();

            DB::commit();

            return redirect()
                ->route('lampiran_narasumber.show', $validated['id'])
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'Narasumber berhasil ditambahkan.'
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
    public function update_narasumber(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'narasumber'        => ['required', 'numeric', new SafeInput],
            'no_surat'          => ['nullable', 'string', 'max:1000000', new SafeInput],
            'id_transaksi'      => ['nullable', 'string', 'max:1000000', new SafeInput],
            'detail_id'         => ['required', 'numeric', new SafeInput], // id header tetap ikut
            'id'                => ['required', 'numeric', new SafeInput], // id header tetap ikut
        ]);
        $id = $validated['detail_id'];
        DB::beginTransaction();

        try {

            // Cari record lama
            $data = narsum_daftar_hadir_content::findOrFail($id);

            // Update datanya
            $data->id_narsum        = $validated['narasumber'];
            $data->no_surat         = $validated['no_surat'];
            $data->id_transaksi     = $validated['id_transaksi'];

            $data->save();

            DB::commit();

            return redirect()
                ->route('lampiran_narasumber.show', $validated['id'])
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'Data narasumber berhasil diperbarui.'
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
    public function hapus_narasumber(Request $request)
    {
        $validated = $request->validate([
            'id_narsum_content' => ['required', 'numeric', new SafeInput],
            'id'                => ['required', 'numeric', new SafeInput], // id header tetap ikut
        ]);

        DB::beginTransaction();
        try {
            // Cari record yang akan dihapus
            $data = narsum_daftar_hadir_content::findOrFail($validated['id_narsum_content']);

            // Hapus record tersebut
            $data->delete();

            DB::commit();

            return redirect()
                ->route('lampiran_narasumber.show', $validated['id'])
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'Narasumber berhasil dihapus dari daftar hadir.'
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
    public function hapus_peserta(Request $request)
    {
        
        $validated = $request->validate([
            'id_peserta'    => ['required', 'numeric', new SafeInput],
            'id_header'     => ['required', 'numeric', new SafeInput],
        ]);
        try {
            $data = narsum_daftar_hadir_umum::findOrFail($validated['id_peserta']);
            $data->delete();

            return redirect()
                ->route('lampiran_narasumber.show', $validated['id_header'])
                ->with('alert', [
                    'type'    => 'success',
                    'message' => 'Peserta berhasil dihapus.'
                ]);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('alert', [
                    'type' => 'danger',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }
    public function tambah_peserta(Request $request)
    {
        dd($request->all());
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $opd = session('opd');
        $bidang = session('bidang');
        $tahun = session('tahun', date('Y'));

        $id_subs = Id_sub::select('id_sub')
            ->where('opd', $opd)
            ->where('bidang', $bidang)
            ->get();


        $url = API::where('opd_name', $opd)
            ->where('api_name', 'f1')
            ->value('api_url');
        $url = $url . $tahun;

        // 2. Panggil API tanpa auth
        $response = Http::get($url);
        // dd($response->json());


        $allPekerjaan = collect(); // tampung semua

        foreach ($id_subs as $id_sub) {

            $filteredData = collect($response->json())
                ->where('sub_id', $id_sub->id_sub)
                ->filter(function ($item) {
                    return str_contains($item['nama_pekerjaan'], 'Honorarium');
                })
                ->unique('pekerjaan_id')
                ->values();

            // simpan ke global
            $allPekerjaan = $allPekerjaan->merge($filteredData);
        }

        // remove duplicate setelah digabung
        $allPekerjaan = $allPekerjaan->unique('pekerjaan_id')->values();
        $header = narsum_daftar_hadir_header::find($id);
        return view('lampiran_pendukung.narasumber.create', compact('header', 'allPekerjaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // Validasi input (sama seperti store)
        $validated = $request->validate([
            'tanggal'               => ['required', 'date', new SafeInput],
            'acara'                 => ['required', 'string', 'max:255', new SafeInput],
            'tempat'                => ['required', 'string', 'max:255', new SafeInput],
            'pukul_mulai'           => ['required', 'string', 'max:10', new SafeInput],
            'pukul_selesai'         => ['required', 'string', 'max:10', new SafeInput],
            'tgl_undangan'          => ['required', 'date', new SafeInput],
            'komponen'              => ['required', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_1'     => ['nullable', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_2'     => ['nullable', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_3'     => ['nullable', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan_4'     => ['nullable', 'string', 'max:255', new SafeInput],
            'masukan'               => ['nullable', 'string', new SafeInput],
        ]);

        DB::beginTransaction();

        try {

            // Ambil data berdasarkan ID
            $data = narsum_daftar_hadir_header::findOrFail($id);

            // Update field
            $data->tanggal              = $validated['tanggal'];
            $data->acara                = $validated['acara'];
            $data->tempat               = $validated['tempat'];
            $data->pukul_mulai          = $validated['pukul_mulai'];
            $data->pukul_selesai        = $validated['pukul_selesai'];
            $data->tgl_undangan        = $validated['tgl_undangan'];
            $data->komponen             = $validated['komponen'];
            $data->paket_pekerjaan_1    = $validated['paket_pekerjaan_1'] ?? null;
            $data->paket_pekerjaan_2    = $validated['paket_pekerjaan_2'] ?? null;
            $data->paket_pekerjaan_3    = $validated['paket_pekerjaan_3'] ?? null;
            $data->paket_pekerjaan_4    = $validated['paket_pekerjaan_4'] ?? null;
            $data->masukan              = $validated['masukan'];

            // Jika bidang dan opd tidak berubah, jangan update
            // Kalau mau update -> uncomment:
            // $data->bidang = session('bidang');
            // $data->opd = session('opd');

            $data->save();

            DB::commit();

            return redirect()
                ->route('lampiran_narasumber.show', $data->id)
                ->with('alert', [
                    'type'    => 'success',
                    'message' => 'Data berhasil diperbarui.'
                ]);
        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('alert', [
                    'type'    => 'danger',
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage()
                ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
