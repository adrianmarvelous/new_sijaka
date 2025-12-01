<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\PreviewImportNarsumHeader;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_header as NarsumDaftarHadirHeader;
use Illuminate\Support\Facades\DB;

class UploadExcel extends Controller
{
    public function index()
    {
        return view('admin.upload_excel.index');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $import = new PreviewImportNarsumHeader;
        Excel::import($import, $request->file('file'));

        // return preview view with rows + hidden json
        return view('admin.upload_excel.preview', [
            'rows' => $import->rows
        ])->render();
    }
    public function store(Request $request)
    {
        $request->validate([
            'rows' => 'required|array'
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->rows as $row) {
                NarsumDaftarHadirHeader::create([
                    // 'id' => $row[0] ?? null,
                    'tanggal' => $this->parseDate($row[1] ?? null),
                    'tanggal_surat_kesediaan' => $this->parseInt($row[2] ?? null),
                    'pukul_mulai' => $this->parseTime($row[3] ?? null),
                    'pukul_selesai' => $this->parseTime($row[4] ?? null),
                    'acara' => $row[5] ?? null,
                    'tempat' => $row[6] ?? null,
                    'masukan' => $row[7] ?? null,
                    'tanggal_surat_kesediaan' => $this->parseInt($row[8] ?? null),
                    'tgl_undangan' => $this->parseDate($row[9] ?? null),
                    'komponen' => $row[10] ?? null,
                    'paket_pekerjaan_1' => $row[11] ?? null,
                    'paket_pekerjaan_2' => $row[12] ?? null,
                    'paket_pekerjaan_3' => $row[13] ?? null,
                    'paket_pekerjaan_4' => $row[14] ?? null,
                    'pptk' => $row[15] ?? null,
                    'bidang' => $row[16] ?? null,
                    'opd' => $row[17] ?? null,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Data successfully saved']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Failed to save data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    private function parseDate($value)
    {
        if (empty($value) || $value === '0') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return date('Y-m-d', strtotime($value));
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function parseTime($value)
    {
        if (empty($value) || $value === '0') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format('H:i:s');
            }
            return date('H:i:s', strtotime($value));
        } catch (\Throwable $e) {
            return null;
        }
    }
    private function parseInt($value)
    {
        if (empty($value) || strtoupper($value) === 'NULL') {
            return null; // simpan NULL di DB
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return null; // kalau bukan angka valid
    }

}
