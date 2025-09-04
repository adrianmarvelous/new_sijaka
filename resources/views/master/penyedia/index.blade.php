@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Master Penyedia</h1>
            <div class="d-flex justify-content-end p-3">
                <a class="btn btn-primary" href="{{ route('penyedia.create') }}">Tambah Penyedia</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="basic-datatables">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama Penyedia</th>
                            <th>Nama Direktur</th>
                            <th>Alamat Penyedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penyedia as $no => $item)
                            <tr>
                                <td>{{ $no+1 }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->direktur }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('penyedia.show',['penyedium' => $item->id]) }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Detail"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
