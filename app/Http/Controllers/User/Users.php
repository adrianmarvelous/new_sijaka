<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User\Master_pegawai;
use App\Models\User;
use App\Models\Roles;

class Users extends Controller
{
    public function index(Request $request)
    {
        $opd = Master_pegawai::select('opd')->distinct()->get();
        $roles = Roles::all();

        $opd_filter = $request->input('opd_filter');

        if ($opd_filter && $opd_filter !== 'semua') {
            $users = User::whereHas('master_pegawai', function ($query) use ($opd_filter) {
                $query->where('opd', $opd_filter);
            })->get();
        } else {
            $users = User::with('master_pegawai')->get();
        }

        return view('user.users.index', compact('opd','users','opd_filter','roles'));
    }

    public function updateorcreate($opd)
    {
        if($opd != 'semua'){
            $pegawai = Master_pegawai::get();

            foreach ($pegawai as $p) {
                if ($p->opd == $opd) {
                    
                    // pick nip if exists, otherwise nik
                    $username = $p->nip ?: $p->nik;

                    $user = \App\Models\User::updateOrCreate(
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
                    if($p->kategori == "PNS"){
                        $user->syncRoles(['pns']);
                    }elseif($p->kategori == "CPNS"){
                        $user->syncRoles(['cpns']);
                    }elseif($p->kategori == "PPPK"){
                        $user->syncRoles(['pppk']);
                    }elseif($p->kategori == 'Non ASN'){
                        $user->syncRoles(['non asn']);
                    }
                }
            }
        }
        
        return redirect()->route('users.index')
                            ->with('success', "Table users on {$opd} update successfully.");
    }
    public function destroy($opd)
    {
        // Ambil semua pegawai berdasarkan OPD
        $master_pegawai = Master_pegawai::where('opd', $opd)->get();

        // Kumpulkan semua username (nip atau nik)
        $usernames = [];
        foreach ($master_pegawai as $pegawai) {
            $usernames[] = !empty($pegawai->nip) ? $pegawai->nip : $pegawai->nik;
        }

        if (empty($usernames)) {
            return redirect()->route('users.index')
                ->with('error', "Tidak ada user account untuk {$opd}.");
        }

        DB::beginTransaction();
        try {
            // Ambil semua user sesuai username
            $users = User::whereIn('username', $usernames)->get();

            if ($users->isEmpty()) {
                DB::rollBack();
                return redirect()->route('users.index')
                    ->with('error', "User account untuk {$opd} tidak ditemukan.");
            }

            // Hapus relasi roles dari pivot `model_has_roles`
            DB::table('model_has_roles')
                ->whereIn('model_id', $users->pluck('id'))
                ->where('model_type', User::class)
                ->delete();

            // Hapus user
            User::whereIn('id', $users->pluck('id'))->delete();

            DB::commit();
            return redirect()->route('users.index')
                ->with('success', "User account untuk {$opd} berhasil dihapus.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')
                ->with('error', "Terjadi kesalahan: " . $e->getMessage());
        }
    }


    
    public function assign($id_user,$role)
    {
        $user = User::findOrFail($id_user);
        $role = Roles::where('name', $role)->firstOrFail();

        if ($user->hasRole($role->name)) {
            // Jika user sudah punya role → hapus
            $user->removeRole($role->name);
            $message = "Role {$role->name} berhasil ditambahkan {$role->name} ke user {$user->name}.";
        } else {
            // Jika user belum punya role → tambahkan
            $user->assignRole($role->name);
            $message = "Role {$role->name} berhasil ditambahkan {$role->name} ke user {$user->name}.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function login_user_index($jenis)
    {
        if ($jenis === 'asn') {
            $categories = ['PNS', 'CPNS', 'PPPK'];
            $opd = session('opd');

            $users = User::whereHas('master_pegawai', function($q) use ($categories, $opd) {
                $q->whereIn('kategori', $categories)
                ->where('opd', $opd);
            })->with('master_pegawai')->get();
        }elseif($jenis === 'non asn')
        {
            $categories = ['non asn'];
            $opd = session('opd');

            $users = User::whereHas('master_pegawai', function($q) use ($categories, $opd) {
                $q->whereIn('kategori', $categories)
                ->where('opd', $opd);
            })->with('master_pegawai')->get();
        }   

        return view('user.login_user.index', compact('users'));
    }

    public function impersonate($id = null)
    {
        // Jika sedang impersonasi -> kembali ke admin
        if (session('is_impersonating')) {
            $adminId = session('impersonate_admin_id');
            $admin = User::findOrFail($adminId);

            Auth::login($admin);

            // Restore admin session info
            session([
                'user_id' => $admin->id,
                'name'    => $admin->name,
                'email'   => $admin->email,
                'roles'   => session('impersonate_admin_roles'),
                'opd'     => optional($admin->master_pegawai)->opd,
            ]);

            // Hapus info impersonasi
            session()->forget(['is_impersonating', 'impersonate_admin_id', 'impersonate_admin_roles']);

            return redirect()->route('dashboard')
                ->with('success', 'Kembali ke akun admin.');
        }

        // Kalau belum impersonate → impersonate user target
        $userToLogin = User::findOrFail($id);

        // Simpan session admin
        session([
            'impersonate_admin_id'    => auth()->id(),
            'impersonate_admin_roles' => auth()->user()->getRoleNames(),
            'is_impersonating'        => true,
        ]);

        // Login ke akun user target
        Auth::login($userToLogin);

        session([
            'user_id' => $userToLogin->id,
            'name'    => $userToLogin->name,
            'email'   => $userToLogin->email,
            'roles'   => $userToLogin->getRoleNames(),
            'opd'     => optional($userToLogin->master_pegawai)->opd,
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Sekarang impersonating sebagai {$userToLogin->name}.");
    }


}
