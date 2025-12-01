@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <div class="p-3">
                <h1 class="text-center">Detail Acara Narasumber</h1>

                <div class="row">
                    <div class="col-lg-1 col-md-4">
                        <p class="fw-bold">Tanggal</p>
                    </div>
                    <div class="col-lg-11 col-md-8">
                        <p>{{ date('d-m-Y', strtotime($header->tanggal)) }}</p>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-1 col-md-4">
                        <p class="fw-bold">Pukul</p>
                    </div>
                    <div class="col-lg-11 col-md-8">
                        <p>{{ date('H:i', strtotime($header->pukul_mulai)) }} -
                            {{ date('H:i', strtotime($header->pukul_selesai)) }}</p>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-1 col-md-4">
                        <p class="fw-bold">Acara</p>
                    </div>
                    <div class="col-lg-11 col-md-8">
                        <p>{{ $header->acara }}</p>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-1 col-md-4">
                        <p class="fw-bold">Tempat</p>
                    </div>
                    <div class="col-lg-11 col-md-8">
                        <p>{{ $header->tempat }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-1 col-md-4">
                        <p class="fw-bold">Tanggal Undangan</p>
                    </div>
                    <div class="col-lg-11 col-md-8">
                        <p>{{ date('d-m-Y', strtotime($header->tgl_undangan)) }}</p>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-1 col-md-4">
                        <p class="fw-bold">Paket Pekerjaan</p>
                    </div>
                    <div class="col-lg-11 col-md-8">
                        <p>{{ $header->paket_pekerjaan_1 }}</p>
                        <p>{{ $header->paket_pekerjaan_2 }}</p>
                        <p>{{ $header->paket_pekerjaan_3 }}</p>
                        <p>{{ $header->paket_pekerjaan_4 }}</p>
                    </div>
                </div>

                <div class="row mt-1">
                    <p class="fw-bold" style="text-decoration: underline">Resume Rapat</p>
                    {!! html_entity_decode($header->masukan) !!}
                </div>

                <a class="btn btn-primary"
                    href="{{ route('lampiran_narasumber.edit', ['lampiran_narasumber' => $header->id]) }}">
                    Edit Acara
                </a>
            </div>

            {{-- ======================= --}}
            {{--        NARASUMBER        --}}
            {{-- ======================= --}}

            <div class="card shador p-3 border">
                <div class="d-flex justify-content-end">

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                        data-bs-target="#modalTambah">
                        Tambah Narasumber
                    </button>

                    <!-- Modal Tambah -->
                    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('lampiran_narasumber.tambah_narasumber') }}" method="POST">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Tambah Narasumber</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        {{-- Narsum --}}
                                        <label>Pilih Narasumber</label>
                                        <input list="list_narsum_tambah" id="input_narsum_tambah" class="form-control"
                                            placeholder="Cari narasumber...">
                                        <input type="hidden" name="narasumber" id="id_narsum_tambah">

                                        <datalist id="list_narsum_tambah">
                                            @foreach ($master_narsum as $ns)
                                                <option data-id="{{ $ns['id'] }}" value="{{ $ns['nama'] }}">
                                                </option>
                                            @endforeach
                                        </datalist>

                                        {{-- Surat --}}
                                        <label class="mt-3">Nomor Surat Undangan</label>
                                        <input type="text" name="no_surat" class="form-control">

                                        {{-- Id Transaksi --}}
                                        <label class="mt-3">Id Transaksi</label>
                                        <select name="id_transaksi" class="form-select">
                                            <option value="" disabled selected>Pilih Id Transaksi</option>
                                            @foreach ($id_transaksi[0] as $value)
                                                <option value="{{ $value['transaksi_id'] }}">
                                                    {{ $value['transaksi_id'] }}
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <h2 class="text-center">Daftar Hadir Narasumber</h2>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>No Surat</th>
                            <th>Id Transaksi</th>
                            <th>Saran/Masukan</th>
                            <th>Aksi</th>
                        </thead>

                        <tbody>
                            @foreach ($header->contents as $index => $cn)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cn->master_narasumber->nama }}</td>
                                    <td>{{ $cn->master_narasumber->instansi }}</td>
                                    <td>{{ $cn->no_surat }}</td>
                                    <td>{{ $cn->id_transaksi }}</td>
                                    <td>{!! html_entity_decode($cn->masukan) !!}</td>

                                    <td>
                                        <div class="d-flex flex-column">
                                            {{-- <a class="btn btn-primary m-1" href="">Surat Kesediaan</a> --}}
                                            <a class="btn btn-primary m-1" href="{{ route('print_narasumber.saran_masukan',['id' => base64_encode($cn->id)]) }}" target="_blank">Saran/Masukan</a>
                                            <a class="btn btn-primary m-1" href="">Daftar Hadir Narasumber</a>
                                            <a class="btn btn-primary m-1" href="">Edelivery</a>
                                            <a class="btn btn-success m-1" href="">Login</a>

                                            <button class="btn btn-warning m-1" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $cn->id }}">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalHapus{{ $cn->id }}">
                                                Hapus
                                            </button>

                                        </div>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEdit{{ $cn->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <form action="{{ route('lampiran_narasumber.update_narasumber') }}"
                                                        method="POST">
                                                        @csrf

                                                        <div class="modal-header">
                                                            <h5 class="modal-title fw-bold">Edit Narasumber</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>

                                                        <div class="modal-body">

                                                            {{-- Narsum --}}
                                                            <label>Pilih Narasumber</label>
                                                            <input list="list_narsum_edit{{ $cn->id }}"
                                                                id="input_narsum_edit{{ $cn->id }}"
                                                                class="form-control"
                                                                value="{{ $cn->master_narasumber->nama }}">

                                                            <input type="hidden" name="narasumber"
                                                                id="id_narsum_edit{{ $cn->id }}"
                                                                value="{{ $cn->id_narsum }}">

                                                            <datalist id="list_narsum_edit{{ $cn->id }}">
                                                                @foreach ($master_narsum as $ns)
                                                                    <option data-id="{{ $ns['id'] }}"
                                                                        value="{{ $ns['nama'] }}"></option>
                                                                @endforeach
                                                            </datalist>

                                                            {{-- Surat --}}
                                                            <label class="mt-3">Nomor Surat Undangan</label>
                                                            <input type="text" name="no_surat" class="form-control"
                                                                value="{{ $cn->no_surat }}">

                                                            {{-- Id Transaksi --}}
                                                            <label class="mt-3">Id Transaksi</label>
                                                            <select name="id_transaksi" class="form-select">
                                                                <option value="{{ $cn->id_transaksi }}" selected>
                                                                    {{ $cn->id_transaksi }}
                                                                </option>

                                                                @foreach ($id_transaksi[0] as $value)
                                                                    <option value="{{ $value['transaksi_id'] }}">
                                                                        {{ $value['transaksi_id'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <input type="hidden" name="detail_id"
                                                                value="{{ $cn->id }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $id }}">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Button trigger modal -->

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalHapus{{ $cn->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('lampiran_narasumber.hapus_narasumber') }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Hapus
                                                                Narasumber</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Hapus Narasumber {{ $cn->master_narasumber->nama }} dari daftar
                                                            hadir?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="id_narsum_content"
                                                                value="{{ $cn->id }}">
                                                            <input type="hidden" name="id"
                                                                value="{{ $id }}">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                Tutup
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

            {{-- ======================= --}}
            {{--     DAFTAR HADIR UMUM   --}}
            {{-- ======================= --}}

            <div class="card shador p-3 mt-3 border">
                <h2 class="text-center">Daftar Hadir Rapat</h2>
                <div class="d-flex justify-content-end">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalTambahPeserta">
                        Tambah Peserta
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModalTambahPeserta" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Peserta</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('lampiran_narasumber.tambah_peserta') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <label for="">Pilih Peserta</label>
                                        
                                        <input list="peserta" id="peserta_input" class="form-control" placeholder="Cari narasumber...">

                                        <input type="hidden" name="nik" id="peserta_hidden">

                                        <datalist id="peserta">
                                            @foreach ($master_pegawai as $pegawai)
                                                <option data-id="{{ $pegawai->nik }}" value="{{ $pegawai->nama }}"></option>
                                            @endforeach
                                        </datalist>

                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="id_header" value="{{ $id }}">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Tutup
                                        </button>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Instansi</th>
                            <th>Tanda Tangan</th>
                            <th>Aksi</th>
                        </thead>

                        <tbody>
                            @foreach ($header->umum as $i => $um)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $um->master_pegawai->nama }}</td>
                                    <td>{{ $um->master_pegawai->opd }}</td>
                                    <td></td>
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal"
                                            data-bs-target="#exampleModalPesertaHapus{{ $um->id }}">
                                            Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalPesertaHapus{{ $um->id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('lampiran_narasumber.hapus_peserta') }}"
                                                        method="post">
                                                        @csrf
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Hapus
                                                                Peserta
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Apakah ingin menghapus {{ $um->master_pegawai->nama }} ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                Tutup
                                                            </button>
                                                            <input type="hidden" name="id_peserta"
                                                                value="{{ $um->id }}">
                                                            <input type="hidden" name="id_header"
                                                                value="{{ $id }}">
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <script>
        function bindNarsumListener(inputId, hiddenId, listId) {
            document.getElementById(inputId).addEventListener('change', function() {
                let val = this.value;
                let opts = document.querySelectorAll(`#${listId} option`);

                opts.forEach(op => {
                    if (op.value === val) {
                        document.getElementById(hiddenId).value = op.dataset.id;
                    }
                });
            });
        }

        bindNarsumListener('input_narsum_tambah', 'id_narsum_tambah', 'list_narsum_tambah');

        @foreach ($header->contents as $cn)
            bindNarsumListener(
                'input_narsum_edit{{ $cn->id }}',
                'id_narsum_edit{{ $cn->id }}',
                'list_narsum_edit{{ $cn->id }}'
            );
        @endforeach
    </script>
    <script>
        document.getElementById('peserta_input').addEventListener('input', function () {

            let input = this.value;
            let list = document.getElementById('peserta').options;

            for (let i = 0; i < list.length; i++) {
                if (list[i].value === input) {
                    document.getElementById('peserta_hidden').value = list[i].dataset.id;
                    break;
                }
            }
        });
    </script>

@endsection
