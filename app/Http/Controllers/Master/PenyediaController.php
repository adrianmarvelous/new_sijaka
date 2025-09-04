<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Master\Penyedia;
use App\Rules\SafeInput;


class PenyediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penyedia = Penyedia::all();
        return view('master.penyedia.index',compact('penyedia'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.penyedia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validation awal
        $request->validate([
            'username' => ['required', 'string', 'max:255', new SafeInput],
            'password' => ['required', 'string', 'max:255', new SafeInput],
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'direktur' => ['nullable', 'string', 'max:255', new SafeInput],
            'alamat' => ['nullable', 'string', 'max:255', new SafeInput],
            'telp' => ['nullable', 'string', 'max:255', new SafeInput],
            'rekening' => ['nullable', 'string', 'max:255', new SafeInput],
            'npwp' => ['nullable', 'string', 'max:255', new SafeInput],
        ]);

        // ✅ Cek apakah username sudah dipakai
        $check_penyedia = Penyedia::where('username', $request->username)->first();

        if ($check_penyedia) {
            return redirect()->back()->with('error', 'Gunakan username lain, username sudah terpakai!');
        }

        DB::beginTransaction();

        try {
            // ✅ Create new penyedia
            $penyedia = new Penyedia();
            $penyedia->username = $request->username;
            $penyedia->password = Hash::make($request->password);
            $penyedia->nama = $request->nama;
            $penyedia->direktur = $request->direktur;
            $penyedia->alamat = $request->alamat;
            $penyedia->telp = $request->telp;
            $penyedia->rekening = $request->rekening;
            $penyedia->npwp = $request->npwp;

            // ✅ Handle file uploads
            $pdfFiles = ['npwp_upload', 'pkp_upload', 'ref_bank_upload', 'siup_upload', 'nib_upload'];
            $Pngfolders = ['npwp','pkp','ref_bank','siup','nib'];
            $pngFiles = ['spesimen', 'stempel'];

            foreach ($pdfFiles as $index => $file) {
                if ($request->hasFile($file)) {
                    $mime = $request->file($file)->getMimeType();
                    if ($mime !== 'application/pdf') {
                        throw new \Exception("File $file harus berupa PDF.");
                    }

                    // 🔹 Random nama file
                    $filename = uniqid() . '.pdf';
                    $path = $request->file($file)->storeAs("upload/master/penyedia",$Pngfolders[$index].'/'. $filename, 'public');

                    // 🔹 Simpan nama file ke kolom
                    $penyedia->$file = $path;
                }
            }

            foreach ($pngFiles as $i => $file) {
                if ($request->hasFile($file)) {
                    $mime = $request->file($file)->getMimeType();
                    if ($mime !== 'image/png') {
                        throw new \Exception("File $file harus berupa PNG.");
                    }

                    // 🔹 Random nama file
                    $filename = uniqid() . '.png';
                    $path = $request->file($file)->storeAs("upload/master/penyedia",$file.'/'. $filename, 'public');

                    // 🔹 Simpan nama file ke kolom
                    $penyedia->$file = $path;
                }
            }

            $penyedia->save();

            DB::commit();

            return redirect()->route('penyedia.index')->with('success', 'Penyedia baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menambahkan penyedia: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penyedia = Penyedia::findOrFail($id); // akan 404 kalau tidak ada
        return view('master.penyedia.show',compact('penyedia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penyedia = Penyedia::where('id', $id)->first();
        return view('master.penyedia.create',compact('penyedia'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ✅ Validation awal
        $request->validate([
            'username' => ['required', 'string', 'max:255', new SafeInput],
            'password' => ['nullable', 'string', 'max:255', new SafeInput], // boleh kosong
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'direktur' => ['nullable', 'string', 'max:255', new SafeInput],
            'alamat' => ['nullable', 'string', 'max:255', new SafeInput],
            'telp' => ['nullable', 'string', 'max:255', new SafeInput],
            'rekening' => ['nullable', 'string', 'max:255', new SafeInput],
            'npwp' => ['nullable', 'string', 'max:255', new SafeInput],
        ]);

        DB::beginTransaction();

        try {
            $penyedia = Penyedia::findOrFail($id);

            // ✅ Cek apakah username sudah dipakai user lain
            $check_penyedia = Penyedia::where('username', $request->username)
                ->where('id', '!=', $id)
                ->first();

            if ($check_penyedia) {
                return redirect()->back()->with('error', 'Gunakan username lain, username sudah terpakai!');
            }

            // ✅ Update field dasar
            $penyedia->username = $request->username;
            if ($request->filled('password')) {
                $penyedia->password = Hash::make($request->password);
            }
            $penyedia->nama = $request->nama;
            $penyedia->direktur = $request->direktur;
            $penyedia->alamat = $request->alamat;
            $penyedia->telp = $request->telp;
            $penyedia->rekening = $request->rekening;
            $penyedia->npwp = $request->npwp;

            // ✅ Handle file uploads
            $pdfFiles = ['npwp_upload', 'pkp_upload', 'ref_bank_upload', 'siup_upload', 'nib_upload'];
            $pdfFolders = ['npwp','pkp','ref_bank','siup','nib'];
            $pngFiles = ['spesimen', 'stempel'];

            foreach ($pdfFiles as $index => $file) {
                if ($request->hasFile($file)) {
                    $mime = $request->file($file)->getMimeType();
                    if ($mime !== 'application/pdf') {
                        throw new \Exception("File $file harus berupa PDF.");
                    }

                    // 🔹 Random nama file
                    $filename = uniqid() . '.pdf';
                    $path = $request->file($file)->storeAs(
                        "upload/master/penyedia", 
                        $pdfFolders[$index] . '/' . $filename, 
                        'public'
                    );

                    $penyedia->$file = $path;
                }
            }

            foreach ($pngFiles as $file) {
                if ($request->hasFile($file)) {
                    $mime = $request->file($file)->getMimeType();
                    if ($mime !== 'image/png') {
                        throw new \Exception("File $file harus berupa PNG.");
                    }

                    // 🔹 Random nama file
                    $filename = uniqid() . '.png';
                    $path = $request->file($file)->storeAs(
                        "upload/master/penyedia", 
                        $file . '/' . $filename, 
                        'public'
                    );

                    $penyedia->$file = $path;
                }
            }

            $penyedia->save();

            DB::commit();

            return redirect()->route('penyedia.index')->with('success', 'Penyedia berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal memperbarui penyedia: ' . $e->getMessage());
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
