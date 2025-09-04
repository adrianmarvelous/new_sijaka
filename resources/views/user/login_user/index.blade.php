@extends('dashboard')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Login User</h1>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="basic-datatables">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Bidang</th>
                            <th>Jabatan</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $no => $item)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->master_pegawai->kategori }}</td>
                                <td>{{ $item->master_pegawai->unit_kerja }}</td>
                                <td>{{ $item->master_pegawai->jabatan }}</td>
                                @php
                                    $jabatan = strtolower(optional($item->master_pegawai)->jabatan ?? '');

                                    $map = [
                                        ['keywords' => ['kepala bidang', 'sekretaris'], 'label' => 'Kabid'],
                                        ['keywords' => ['kepala badan'], 'label' => 'Kepala Badan'],
                                        ['keywords' => ['kepala dinas'], 'label' => 'Kepala Dinas'],
                                        // Add more mappings here if needed
                                    ];

                                    $label = '';
                                    foreach ($map as $m) {
                                        if (Str::contains($jabatan, $m['keywords'])) {
                                            $label = $m['label'];
                                            break; // stop at first match
                                        }
                                    }
                                @endphp

                                <td>{{ $label }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('users.login_user',['id' => $item->id]) }}">Login</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
