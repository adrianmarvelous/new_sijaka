@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Master API</h1>
            <div class="d-flex justify-content-end p-3">
                <a class="btn btn-primary" href="{{ route('list_api.create') }}">Tambah API Baru</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama OPD</th>
                            <th>Nama API</th>
                            <th>URL</th>
                            <th>Username</th>
                            <th>Secret Key</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apis as $api)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $api->opd_name }}</td>
                                <td>{{ $api->api_name }}</td>
                                <td>{{ $api->api_url }}</td>
                                <td>{{ $api->username }}</td>
                                <td>{{ $api->secret }}</td>
                                <td>
                                    <a class="btn btn-primary mb-3"
                                        href="{{ route('list_api.edit', ['list_api' => $api->id]) }}"><i
                                            class="fa fa-pen"></i></a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $api->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal{{ $api->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title fw-bold" id="exampleModalLabel">Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah anda yakin ingin mengapus API <span class="fw-bold">{{ $api->opd_name.' - '.$api->api_name }}</span></p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                    <form action="{{ route('list_api.destroy', $api->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
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
