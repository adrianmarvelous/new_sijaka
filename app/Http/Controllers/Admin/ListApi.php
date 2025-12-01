<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User\Master_pegawai;
use App\Models\Master\API;
use App\Rules\SafeInput;

class ListApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apis = API::all();
        return view('admin.list_api.index', compact('apis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opds = Master_pegawai::select('opd')->distinct()->get();

        return view('admin.list_api.create', compact('opds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ Validation
        $validated = $request->validate([
            'opd_name' => ['required', 'string', 'max:255', new SafeInput],
            'api_name' => ['required', 'string', 'max:255', new SafeInput],
            'api_url' => ['required', 'string', 'max:255', new SafeInput],
            'username' => ['nullable', 'string', 'max:255', new SafeInput],
            'secret' => ['nullable', 'string', 'max:255', new SafeInput],
        ]);

        DB::beginTransaction();

        try {
            $api = new API();
            $api->opd_name = $validated['opd_name'];
            $api->api_name = $validated['api_name'];
            $api->api_url = $validated['api_url'];
            $api->username = $validated['username'];
            $api->secret = $validated['secret'];

            $api->save();
            DB::commit();

            return redirect()->route('list_api.index')
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
        $opds = Master_pegawai::select('opd')->distinct()->get();
        $api = API::where('id', $id)->first();

        return view('admin.list_api.create', compact('opds', 'api'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // ✅ Validation
        $validated = $request->validate([
            'opd_name' => ['required', 'string', 'max:255', new SafeInput],
            'api_name' => ['required', 'string', 'max:255', new SafeInput],
            'api_url'  => ['required', 'string', 'max:255', new SafeInput],
            'username' => ['nullable', 'string', 'max:255', new SafeInput],
            'secret'   => ['nullable', 'string', 'max:255', new SafeInput],
        ]);

        DB::beginTransaction();

        try {
            // 🔍 Find the existing API record
            $api = API::findOrFail($id);

            // 🔄 Update fields
            $api->opd_name = $validated['opd_name'];
            $api->api_name = $validated['api_name'];
            $api->api_url  = $validated['api_url'];
            $api->username = $validated['username'] ?? null;
            $api->secret   = $validated['secret'] ?? null;

            $api->save();

            DB::commit();

            return redirect()->route('list_api.index')
                ->with('alert', [
                    'type' => 'success',
                    'message' => 'API berhasil diperbarui.'
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $api = API::findOrFail($id); // will throw 404 if not found
        $api->delete();

        return redirect()->route('list_api.index')
            ->with('success', 'API berhasil dihapus.');
    }
}
