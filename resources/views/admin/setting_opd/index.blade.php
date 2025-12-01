@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Master OPD</h1>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="basic-datatables">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama OPD</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->opd }}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary" href="{{ route('master_opd.bidang',['opd' => $item->opd]) }}">Bidang</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
