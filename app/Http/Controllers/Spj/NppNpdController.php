<?php

namespace App\Http\Controllers\Spj;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Master\API;
use App\Rules\SafeInput;
use Illuminate\Support\Facades\DB;
use App\Models\Spj\NppNpdTemp;
use App\Models\Spj\NppNpd;
use App\Models\Spj\NppNpdDetail;
use App\Models\Opd\Id_sub;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

// use function Pest\Laravel\session;

class NppNpdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd(session()->all());

        // Get the month from query parameter, default to current month if not provided
        $bulan = $request->query('bulan', date('n'));
        $tahun = $request->query('tahun', date('Y'));
        $bidang = session('bidang');
        $opd = session('opd');

        $data = NppNpd::with('id_sub','npp_npd_details')
            ->whereHas('id_sub', function ($q) use ($bidang) {
                $q->where('bidang', $bidang);
            })
            ->withSum('npp_npd_details as total_pencairan', 'pencairan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        return view('spj.npp_npd.index',compact('data'));
    }
    public function buat_nppnpd()
    {
        $opd = session('opd');
        $bidang = session('bidang');

        $id_sub = Id_sub::where('opd', $opd)
            ->where('bidang', $bidang)
            ->get();

        return view('spj.npp_npd.pilih_id_sub', compact('id_sub'));
    }
    public function npp_npd_temp(Request $request)
    {
        $opd = session('opd');
        $bidang = session('bidang');
        $tahun = session('tahun');
        $bulan = date('m');

        $validated = $request->validate([
            'npp_npd_kkpd'   => ['required', 'string', 'max:255', new SafeInput],
            'id_sub'     => ['required', 'string', 'max:255', new SafeInput],
        ]);
        $id_sub = $validated['id_sub'];
        $npp_npd_kkpd = $validated['npp_npd_kkpd'];

        $reset = NppNpdTemp::where('opd', $opd)
            ->where('bidang', $bidang)
            ->delete();

        $api = API::where('opd_name', $opd)
            ->where('api_name', 'f1')
            ->first();
        $url = $api->api_url;

        $url = $url . $tahun;

        $response = Http::get($url);

        $response = $response->json();

        foreach ($response as $item) {
            if ($item['sub_id'] == $id_sub && $item['bulan'] == $bulan && $item['nominal'] != 0) {
                $pekerjaan_id = $item['pekerjaan_id'];
                if (!isset($grouped_data[$pekerjaan_id])) {

                    $grouped_data[$pekerjaan_id] = [
                        'sub_id' => $item['sub_id'],
                        'pekerjaan_id' => $item['pekerjaan_id'],
                        'nama_pekerjaan' => $item['nama_pekerjaan'],
                        'total_alokasi' => 0,
                        'total_nominal' => 0,
                    ];
                }

                $grouped_data[$pekerjaan_id]['total_alokasi'] += $item['alokasi'];
                $grouped_data[$pekerjaan_id]['total_nominal'] += $item['nominal'];
            } elseif ($item['sub_id'] == $id_sub) {
                $pekerjaan_id1 = $item['pekerjaan_id'];
                if (!isset($grouped_data1[$pekerjaan_id1])) {

                    $grouped_data1[$pekerjaan_id1] = [
                        'sub_id' => $item['sub_id'],
                        'pekerjaan_id' => $item['pekerjaan_id'],
                        'nama_pekerjaan' => $item['nama_pekerjaan'],
                        'total_alokasi' => 0,
                        'total_nominal' => 0,
                    ];
                }

                $grouped_data1[$pekerjaan_id1]['total_alokasi'] += $item['alokasi'];
                $grouped_data1[$pekerjaan_id1]['total_nominal'] += $item['nominal'];
            }
        }
        DB::beginTransaction();

        try {

            foreach ($grouped_data1 as $pekerjaan_id => $item) {

                NppNpdTemp::create([
                    'opd'          => $opd,
                    'bidang'          => $bidang,
                    'id_sub'          => $item['sub_id'],
                    'paket_pekerjaan' => $item['pekerjaan_id'], // atau $pekerjaan_id
                    'uraian'         => $item['nama_pekerjaan'],
                    'alokasi'        => $item['total_alokasi'],
                    'rencana'        => $item['total_nominal'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('npp_npd.pilih_paket', [
                    'id_sub' => $id_sub,
                    'npp_npd_kkpd' => $npp_npd_kkpd
                ])
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'Paket Pekerjaan berhasil dipilih'
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
    public function pilih_paket($id_sub, $npp_npd_kkpd)
    {
        $opd = session('opd');
        $bidang = session('bidang');
        $tahun = session('tahun');
        $bulan = date('m');

        $paket_pekerjaan = NppNpdTemp::where('opd', $opd)
            ->where('bidang', $bidang)
            ->get();

        $api = API::where('opd_name', $opd)
            ->where('api_name', 'f1')
            ->first();
        $url = $api->api_url;

        $url = $url . $tahun;

        $response = Http::get($url);

        $response = $response->json();

        foreach ($response as $item) {
            if ($item['sub_id'] == $id_sub && $item['bulan'] == $bulan && $item['nominal'] != 0) {
                $pekerjaan_id = $item['pekerjaan_id'];
                if (!isset($grouped_data[$pekerjaan_id])) {

                    $grouped_data[$pekerjaan_id] = [
                        'sub_id' => $item['sub_id'],
                        'pekerjaan_id' => $item['pekerjaan_id'],
                        'nama_pekerjaan' => $item['nama_pekerjaan'],
                        'total_alokasi' => 0,
                        'total_nominal' => 0,
                    ];
                }

                $grouped_data[$pekerjaan_id]['total_alokasi'] += $item['alokasi'];
                $grouped_data[$pekerjaan_id]['total_nominal'] += $item['nominal'];
            } elseif ($item['sub_id'] == $id_sub) {
                $pekerjaan_id1 = $item['pekerjaan_id'];
                if (!isset($grouped_data1[$pekerjaan_id1])) {

                    $grouped_data1[$pekerjaan_id1] = [
                        'sub_id' => $item['sub_id'],
                        'pekerjaan_id' => $item['pekerjaan_id'],
                        'nama_pekerjaan' => $item['nama_pekerjaan'],
                        'total_alokasi' => 0,
                        'total_nominal' => 0,
                    ];
                }

                $grouped_data1[$pekerjaan_id1]['total_alokasi'] += $item['alokasi'];
                $grouped_data1[$pekerjaan_id1]['total_nominal'] += $item['nominal'];
            }
        }

        return view('spj.npp_npd.pilih_paket', compact('paket_pekerjaan', 'id_sub', 'grouped_data1', 'npp_npd_kkpd'));
    }
    public function pilih_rekening(Request $request)
    {
        $validated = $request->validate([
            'npp_npd_kkpd'   => ['required', 'string', 'max:255', new SafeInput],
            'id_sub'   => ['required', 'string', 'max:255', new SafeInput],
            'paket_pekerjaan'  => ['required', 'array', 'min:1'],
            'paket_pekerjaan.*' => ['required', 'integer']
        ]);
        $paket = $validated['paket_pekerjaan'];
        $opd = session('opd');
        $tahun = session('tahun');
        $bulan = date('m');
        $npp_npd_kkpd = $validated['npp_npd_kkpd'];
        $id_sub = $validated['id_sub'];

        $api = API::where('opd_name', $opd)
            ->where('api_name', 'f1')
            ->first();
        $url = $api->api_url;

        $url = $url . $tahun;

        $response = Http::get($url);

        $array = $response->json();


        for ($i = 0; $i < count($paket); $i++) {
            foreach ($array as $item) {
                if ($item['pekerjaan_id'] == $paket[$i]  && $item['bulan'] == $bulan) {
                    $item['rekening_kode'] . ' - ' . $item['pekerjaan_id'] . ' - ' . $item['nama_pekerjaan'] . ' - ' . $item['nominal'] . ' - ' . $item['nama_komponen'];
                    if (!isset($ws[$item['komponen_id']])) {
                        $ws[$item['komponen_id']] = array(
                            'komponen_id' => $item['komponen_id'],
                            'rekening_kode' => $item['rekening_kode'],
                            'pekerjaan_id' => $item['pekerjaan_id'],
                            'nama_pekerjaan' => $item['nama_pekerjaan'],
                            'nominal' => $item['nominal'],
                            'nama_komponen' => $item['nama_komponen'],
                            'nominal' => $item['nominal']
                        );
                    }
                } elseif ($item['pekerjaan_id'] == $paket[$i]  && $item['nominal'] == 0  && $item['bulan'] != $bulan && !isset($ws[$item['komponen_id']])) {
                    if (!isset($ws[$item['komponen_id']])) {
                        $ws[$item['komponen_id']] = array(
                            'komponen_id' => $item['komponen_id'],
                            'rekening_kode' => $item['rekening_kode'],
                            'pekerjaan_id' => $item['pekerjaan_id'],
                            'nama_pekerjaan' => $item['nama_pekerjaan'],
                            'nominal' => $item['nominal'],
                            'nama_komponen' => $item['nama_komponen'],
                            'nominal' => $item['nominal']
                        );
                    }
                }
            }
        }


        return view('spj.npp_npd.pilih_rekening', compact('ws', 'npp_npd_kkpd', 'id_sub'));
    }

    public function tambah_paket(Request $request)
    {
        $opd = session('opd');
        $bidang = session('bidang');
        $tahun = session('tahun');
        $bulan = date('m');

        $validated = $request->validate([
            'paket'   => ['required', 'string', 'max:255', new SafeInput],
            'id_sub'     => ['required', 'string', 'max:255', new SafeInput],
            'npp_npd_kkpd'     => ['required', 'string', 'max:255', new SafeInput],
        ]);
        $id_sub = $validated['id_sub'];
        $npp_npd_kkpd = $validated['npp_npd_kkpd'];

        $api = API::where('opd_name', $opd)
            ->where('api_name', 'f1')
            ->first();

        $url = $api->api_url;
        $url = $url . $tahun;
        $response = Http::get($url);
        $response = $response->json();

        foreach ($response as $item) {
            if ($item['sub_id'] == $id_sub && $item['pekerjaan_id'] == $validated['paket']) {
                $pekerjaan_id = $item['pekerjaan_id'];
                if (!isset($grouped_data[$pekerjaan_id])) {
                    $grouped_data[$pekerjaan_id] = [
                        'sub_id' => $item['sub_id'],
                        'pekerjaan_id' => $item['pekerjaan_id'],
                        'nama_pekerjaan' => $item['nama_pekerjaan'],
                        'total_alokasi' => 0,
                        'total_nominal' => 0,
                    ];
                }
                $grouped_data[$pekerjaan_id]['total_alokasi'] += $item['alokasi'];
                $grouped_data[$pekerjaan_id]['total_nominal'] += $item['nominal'];
            }
        }
        $id = $pekerjaan_id;
        $nama = $grouped_data[$pekerjaan_id]['nama_pekerjaan'];
        $alokasi = $grouped_data[$pekerjaan_id]['total_alokasi'];
        $persentase = $grouped_data[$pekerjaan_id]['total_nominal'] / $grouped_data[$pekerjaan_id]['total_alokasi'] * 100;
        $penyerapan = $grouped_data[$pekerjaan_id]['total_nominal'];

        DB::beginTransaction();

        try {

            // foreach ($grouped_data1 as $pekerjaan_id => $item) {

            NppNpdTemp::create([
                'opd'            => $opd,
                'bidang'          => $bidang,
                'id_sub'          => $id_sub,
                'paket_pekerjaan' => $pekerjaan_id, // atau $pekerjaan_id
                'uraian'         => $nama,
                'alokasi'        => $alokasi,
                'rencana'        => $penyerapan,
            ]);
            // }

            DB::commit();

            return redirect()
                ->route('npp_npd.pilih_paket', [
                    'id_sub' => $id_sub,
                    'npp_npd_kkpd' => $npp_npd_kkpd
                ])
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'Paket Pekerjaan berhasil ditambah'
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
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'npp_npd_kkpd'   => ['required', 'string', 'max:255', new SafeInput],
            'id_sub'     => ['required', 'string', 'max:255', new SafeInput],
            'data' => ['required', 'array'],
            'data.*.komponen_id'   => ['required', 'integer'],
            'data.*.pekerjaan_id'  => ['required', 'integer'],
            'data.*.nama_komponen' => ['required', 'string', 'max:255', new SafeInput],
            'data.*.rekening_kode' => ['required', 'string', 'max:50', new SafeInput],
            'data.*.nominal'      => ['required', 'numeric', 'min:0'],
            'data.*.pencairan'    => ['nullable', 'numeric', 'min:0'],
        ]);
        switch ($validated['npp_npd_kkpd']) {
            case 'npp':
                $jenis = 'panjar';
                break;
            case 'npd':
                $jenis = 'ls';
                break;
            case 'kkpd':
                $jenis = 'kkpd';
                break;
        }
        $data = $validated['data'];


        $id_sub = Id_sub::where('opd', session('opd'))
            ->where('id_sub', $validated['id_sub'])
            ->first();


        DB::beginTransaction();

        try {

            $npp_npd = NppNpd::create([
                'id_id_sub'       => $id_sub->id,
                'panjar_ls_kkpd'  => $jenis,
                'tanggal'         => date('Y-m-d'),
            ]);

            foreach ($data as $key => $value) {
                if ($value['pencairan']) {
                    NppNpdDetail::create([
                        'npp_npd'               => $npp_npd->id,
                        'rekening'              => $value['rekening_kode'],
                        'paket_pekerjaan'       => $value['pekerjaan_id'],
                        'uraian'                => $value['nama_komponen'],
                        'anggaran'              => $value['nominal'],
                        'pencairan'             => $value['pencairan'],
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('npp_npd.index')
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'NPP / NPD berhasil dibuat'
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
    public function show(string $id)
    {
        $data = NppNpd::with('id_sub','npp_npd_details')
            ->withSum('npp_npd_details as total_pencairan', 'pencairan')
            ->where('id', $id)
            ->first();

        return view('spj.npp_npd.detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
