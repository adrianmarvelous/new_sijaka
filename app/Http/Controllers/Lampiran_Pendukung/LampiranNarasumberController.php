<?php

namespace App\Http\Controllers\Lampiran_Pendukung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lampiran_Pendukung\Narasumber\narsum_daftar_hadir_header;
use PhpParser\Node\Stmt\Foreach_;

class LampiranNarasumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the month from query parameter, default to current month if not provided
        $bulan = $request->query('bulan', date('n'));
        // $narsum_daftar_hadir_header = narsum_daftar_hadir_header::where('pptk','198103142009021002')->get();
        // dd($narsum_daftar_hadir_header);
        narsum_daftar_hadir_header::where('pptk', '196703191992021001')
                                    ->update(['bidang' => 'Bidang Pengelolaan Administrasi dan Informasi Kepegawaian']);

        // dd(session()->all());

        return view('lampiran_pendukung.narasumber.index', compact('bulan'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
