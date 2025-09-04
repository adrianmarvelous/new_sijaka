@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Users Accounts {{ $opd_filter }}</h1>
            <div>
                <form action="{{ route('users.index') }}" method="GET" id="filterForm">
                    <select class="form-select" name="opd_filter" id="opdSelect" onchange="document.getElementById('filterForm').submit()">
                        <option value="" selected disabled>Pilih OPD</option>
                        <option value="semua" {{ request('opd_filter') == 'semua' ? 'selected' : '' }}>Semua OPD</option>
                        @foreach ($opd as $value)
                            <option value="{{ $value['opd'] }}" {{ request('opd_filter') == $value['opd'] ? 'selected' : '' }}>
                                {{ $value['opd'] }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary m-2" id="buatUserBtn" data-bs-toggle="modal" data-bs-target="#buatUserModal">
                        Buat User Account
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="buatUserModal" tabindex="-1" aria-labelledby="buatUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="buatUserModalLabel">Buat User Account</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Dynamic Content / Form -->
                                    <form id="buatUserForm" method="POST" action="">
                                        @csrf
                                        <input type="hidden" name="opd" id="modalOpd">

                                        <p id="modalText">Apakah anda yakin ingin menambah user account untuk <strong></strong> ?</p>

                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Delete User Button -->
                    <button class="btn btn-danger m-2" id="hapusUserBtn" data-bs-toggle="modal" data-bs-target="#hapusUserModal">
                        Hapus User Account
                    </button>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="hapusUserModal" tabindex="-1" aria-labelledby="hapusUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="hapusUserModalLabel">Konfirmasi Hapus User</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Dynamic Content -->
                                    <form id="hapusUserForm" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="opd" id="hapusModalOpd">

                                        <p id="hapusModalText">Apakah anda yakin ingin menghapus user account untuk <strong></strong> ?</p>

                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let select = document.getElementById("opdSelect");
                        let form = document.getElementById("buatUserForm");
                        let opdInput = document.getElementById("modalOpd");
                        let modalText = document.getElementById("modalText");

                        document.getElementById("buatUserBtn").addEventListener("click", function () {
                            let selected = select.value || '';

                            if (selected) {
                                // Set form action ke route updateorcreate
                                form.action = "{{ url('dashboard/user/users/updateorcreate') }}/" + encodeURIComponent(selected);

                                // Set hidden input value
                                opdInput.value = selected;

                                // Update teks konfirmasi di modal
                                modalText.innerHTML = `Apakah anda yakin ingin menambah user account untuk <strong>${selected}</strong> ?`;
                            } else {
                                form.action = "#";
                                opdInput.value = "";
                                modalText.innerHTML = "Silakan pilih OPD terlebih dahulu.";
                            }
                        });
                    });
                </script>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let select = document.getElementById("opdSelect");
                        let hapusForm = document.getElementById("hapusUserForm");
                        let hapusOpdInput = document.getElementById("hapusModalOpd");
                        let hapusModalText = document.getElementById("hapusModalText");

                        document.getElementById("hapusUserBtn").addEventListener("click", function () {
                            let selected = select.value || '';

                            if (selected) {
                                // Set form action ke route destroy
                                hapusForm.action = "{{ url('dashboard/user/users/delete') }}/" + encodeURIComponent(selected);
                                

                                // Set hidden input value
                                hapusOpdInput.value = selected;

                                // Update teks konfirmasi
                                hapusModalText.innerHTML = `Apakah anda yakin ingin menghapus user account untuk <strong>${selected}</strong> ?`;
                            } else {
                                hapusForm.action = "#";
                                hapusOpdInput.value = "";
                                hapusModalText.innerHTML = "Silakan pilih OPD terlebih dahulu.";
                            }
                        });
                    });
                </script>




            </div>

            <div class="table-responsive mt-3">
                <table class="table table-striped" id="basic-datatables">
                    <thead>
                        <tr class="table-primary">
                            <td>No</td>
                            <td>Username</td>
                            <td>Nama</td>
                            <td>jabatan</td>
                            <td>Unit Kerja</td>
                            <td>role</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $no => $user)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ optional($user->master_pegawai)->jabatan }}</td>
                                <td>{{ optional($user->master_pegawai)->unit_kerja }}</td>
                                <td>
                                    @foreach($roles as $role)
                                        @if ($role->name != 'super admin')
                                            @php
                                                $hasRole = $user->roles->contains('name', $role->name);
                                            @endphp

                                            <a href="{{ route('users.assign', ['role' => $role->name,'id_user' => $user->id]) }}" 
                                            class="badge rounded-pill {{ $hasRole ? 'bg-info text-dark' : 'bg-danger' }} 
                                                    px-3 py-2 fs-6 text-decoration-none text-white">
                                            {{ $role->name }}
                                            </a>
                                        @endif
                                    @endforeach

                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('users.impersonate',['id' => $user->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Login User"><i class="fa fa-user"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data Kosong</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            
        </div>
    </div>
    
@endsection
