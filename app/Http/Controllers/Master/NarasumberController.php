<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Master\Narasumber;
use App\Rules\SafeInput;

class NarasumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $narasumber = Narasumber::all();
        return view('master.narasumber.index',compact('narasumber'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.narasumber.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        // ✅ Validasi input
        $request->validate([
            'username' => ['required', 'string', 'max:255', new SafeInput],
            'password' => ['required', 'string', 'max:255', new SafeInput],
            'nama'     => ['required', 'string', 'max:255', new SafeInput],
            'nip'      => ['nullable', 'string', 'max:50', new SafeInput],
            'nik'      => ['nullable', 'string', 'max:50', new SafeInput],
            'instansi' => ['nullable', 'string', 'max:255', new SafeInput],
            'npwp'     => ['nullable', 'string', 'max:50', new SafeInput],
            'nama_bank'=> ['nullable', 'string', 'max:100', new SafeInput],
            'rekening' => ['nullable', 'string', 'max:100', new SafeInput],
        ]);

        // ✅ Cek username unik
        $check = Narasumber::where('username', $request->username)->first();
        if ($check) {
            return redirect()->back()->with('error', 'Username sudah dipakai, gunakan yang lain!');
        }

        DB::beginTransaction();

        try {
            $narasumber = new Narasumber();
            $narasumber->username  = $request->username;
            $narasumber->password  = Hash::make($request->password);
            $narasumber->nama      = $request->nama;
            $narasumber->nip       = $request->nip;
            $narasumber->nik       = $request->nik;
            $narasumber->instansi  = $request->instansi;
            $narasumber->npwp      = $request->npwp;
            $narasumber->nama_bank = $request->nama_bank;
            $narasumber->rekening  = $request->rekening;

            // ✅ Upload PDF
            $pdfFiles = ['npwp_upload','ktp_upload','cv_upload','kak_upload'];
            foreach ($pdfFiles as $file) {
                if ($request->hasFile($file)) {
                    $mime = $request->file($file)->getMimeType();
                    if ($mime !== 'application/pdf') {
                        throw new \Exception("File $file harus berupa PDF.");
                    }

                    $filename = uniqid().'.pdf';
                    $path = $request->file($file)->storeAs("upload/master/narasumber/$file", $filename, 'public');
                    $narasumber->$file = $path;
                }
            }

            // ✅ Upload Spesimen (PNG)
            if ($request->hasFile('spesimen')) {
                $mime = $request->file('spesimen')->getMimeType();
                if ($mime !== 'image/png') {
                    throw new \Exception("File spesimen harus berupa PNG.");
                }

                $filename = uniqid().'.png';
                $path = $request->file('spesimen')->storeAs("upload/master/narasumber/spesimen", $filename, 'public');
                $narasumber->spesimen = $path;
            }

            $narasumber->save();
            DB::commit();

            return redirect()->route('narasumber.index')->with('success', 'Narasumber berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menambahkan narasumber: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    
    public function show(string $id)
    {
        $narasumber = Narasumber::findOrFail($id); // akan 404 kalau tidak ada
        return view('master.narasumber.show',compact('narasumber'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $narasumber = Narasumber::where('id', $id)->first();
        return view('master.narasumber.create',compact('narasumber'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ✅ Validation
        $request->validate([
            'username' => ['required', 'string', 'max:255', new SafeInput],
            'password' => ['nullable', 'string', 'max:255', new SafeInput], // optional
            'nama' => ['required', 'string', 'max:255', new SafeInput],
            'nip' => ['nullable', 'string', 'max:255', new SafeInput],
            'nik' => ['nullable', 'string', 'max:255', new SafeInput],
            'instansi' => ['nullable', 'string', 'max:255', new SafeInput],
            'npwp' => ['nullable', 'string', 'max:255', new SafeInput],
            'nama_bank' => ['nullable', 'string', 'max:255', new SafeInput],
            'rekening' => ['nullable', 'string', 'max:255', new SafeInput],
        ]);

        DB::beginTransaction();

        try {
            $narasumber = Narasumber::findOrFail($id);

            // ✅ Check if username is used by another user
            $check_narasumber = Narasumber::where('username', $request->username)
                ->where('id', '!=', $id)
                ->first();

            if ($check_narasumber) {
                return redirect()->back()->with('error', 'Gunakan username lain, username sudah terpakai!');
            }

            // ✅ Update basic fields
            $narasumber->username = $request->username;
            if ($request->filled('password')) {
                $narasumber->password = Hash::make($request->password);
            }
            $narasumber->nama = $request->nama;
            $narasumber->nip = $request->nip;
            $narasumber->nik = $request->nik;
            $narasumber->instansi = $request->instansi;
            $narasumber->npwp = $request->npwp;
            $narasumber->nama_bank = $request->nama_bank;
            $narasumber->rekening = $request->rekening;

            // ✅ Handle file uploads
            $pdfFiles = ['npwp_upload', 'ktp_upload', 'cv_upload', 'kak_upload'];
            foreach ($pdfFiles as $file) {
                if ($request->hasFile($file)) {
                    $mime = $request->file($file)->getMimeType();
                    if ($mime !== 'application/pdf') {
                        throw new \Exception("File $file harus berupa PDF.");
                    }

                    $filename = uniqid() . '.pdf';
                    $path = $request->file($file)->storeAs(
                        "upload/master/narasumber/" . str_replace('_upload','',$file),
                        $filename,
                        'public'
                    );

                    // Optional: delete old file if exists
                    if ($narasumber->$file && Storage::disk('public')->exists($narasumber->$file)) {
                        Storage::disk('public')->delete($narasumber->$file);
                    }

                    $narasumber->$file = $path;
                }
            }

            // Spesimen image
            if ($request->hasFile('spesimen')) {
                $mime = $request->file('spesimen')->getMimeType();
                if (!str_contains($mime, 'image')) {
                    throw new \Exception("File Spesimen harus berupa gambar.");
                }

                $filename = uniqid() . '.' . $request->file('spesimen')->extension();
                $path = $request->file('spesimen')->storeAs(
                    "upload/master/narasumber/spesimen",
                    $filename,
                    'public'
                );

                if ($narasumber->spesimen && Storage::disk('public')->exists($narasumber->spesimen)) {
                    Storage::disk('public')->delete($narasumber->spesimen);
                }

                $narasumber->spesimen = $path;
            }

            $narasumber->save();
            DB::commit();

            return redirect()->route('narasumber.index')->with('success', 'Narasumber berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui narasumber: ' . $e->getMessage());
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
