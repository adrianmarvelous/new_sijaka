@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Setting OPD</h1>
            <h1 class="text-center">{{ $opd }}</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="basic-datatables">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama OPD</th>
                            <th>ID SUB</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->unit_kerja }}</td>
                                <td>
                                    <ul>
                                        @foreach ($item->kegiatan as $kegiatan)
                                            <li>
                                                {{ $kegiatan->kode_kegiatan }} - {{ $kegiatan->uraian_kegiatan }} :
                                                {{ $kegiatan->id_sub }} - {{ $kegiatan->kode_sub }} - {{ $kegiatan->uraian_sub }}
                                                <span>
                                                    
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-warning mb-3" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalEdit{{ $kegiatan->id }}">
                                                        Edit ID SUB
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModalEdit{{ $kegiatan->id }}" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Id Sub</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('setting_opd.update_id_sub') }}" method="post">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <label for="">Kode Kegiatan <span style="color: red">Contoh : 5.03.02.2.02 </span></label>
                                                                        <input type="text" name="kode_kegiatan" value="{{ $kegiatan->kode_kegiatan }}" class="form-control">
                                                                        <label class="mt-3" for="">Uraian Kegiatan <span style="color: red">Contoh : Mutasi dan Promosi ASN </span></label>
                                                                        <input type="text" name="uraian_kegiatan" value="{{ $kegiatan->uraian_kegiatan }}" class="form-control">
                                                                        <label class="mt-3" for="">Id Sub <span style="color: red">Contoh : 263 </span></label>
                                                                        <input type="text" name="id_sub" value="{{ $kegiatan->id_sub }}" class="form-control">
                                                                        <label class="mt-3" for="">Kode Sub <span style="color: red">Contoh : 5.03.02.2.02.01 </span></label>
                                                                        <input type="text" name="kode_sub" value="{{ $kegiatan->kode_sub }}" class="form-control">
                                                                        <label class="mt-3" for="">Uraian Sub <span style="color: red">Contoh : Pengelolaan Mutasi ASN </span></label>
                                                                        <input type="text" name="uraian_sub" value="{{ $kegiatan->uraian_sub }}" class="form-control">
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">
                                                                            Tutup
                                                                        </button>
                                                                        <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id }}">
                                                                        <input type="hidden" name="opd" value="{{ $opd }}">
                                                                        <input type="hidden" name="bidang" value="{{ $item->unit_kerja }}">
                                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </span>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModalHapus{{ $kegiatan->id }}">
                                                        Hapus ID SUB
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModalHapus{{ $kegiatan->id }}" tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Hapus Id Sub</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close">
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('setting_opd.hapus_id_sub', $kegiatan->id) }}" method="get">
                                                                    {{-- @csrf --}}
                                                                    <div class="modal-body">
                                                                        Apakah anda yakin ingin menghapus ID SUB {{ $kegiatan->id_sub }} - {{ $kegiatan->kode_sub }} - {{ $kegiatan->uraian_sub }} ?
                                                                    </div>
                                                                    <div class="modal-footer">
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
                                                </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $key }}">
                                        Tambah ID SUB
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Id Sub</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    </button>
                                                </div>
                                                <form action="{{ route('setting_opd.store_id_sub') }}" method="post">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <label for="">Kode Kegiatan <span style="color: red">Contoh : 5.03.02.2.02 </span></label>
                                                        <input type="text" name="kode_kegiatan" class="form-control">
                                                        <label class="mt-3" for="">Uraian Kegiatan <span style="color: red">Contoh : Mutasi dan Promosi ASN </span></label>
                                                        <input type="text" name="uraian_kegiatan" class="form-control">
                                                        <label class="mt-3" for="">Id Sub <span style="color: red">Contoh : 263 </span></label>
                                                        <input type="text" name="id_sub" class="form-control">
                                                        <label class="mt-3" for="">Kode Sub <span style="color: red">Contoh : 5.03.02.2.02.01 </span></label>
                                                        <input type="text" name="kode_sub" class="form-control">
                                                        <label class="mt-3" for="">Uraian Sub <span style="color: red">Contoh : Pengelolaan Mutasi ASN </span></label>
                                                        <input type="text" name="uraian_sub" class="form-control">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                            Tutup
                                                        </button>
                                                        <input type="hidden" name="opd" value="{{ $opd }}">
                                                        <input type="hidden" name="bidang" value="{{ $item->unit_kerja }}">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
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
@endsection
