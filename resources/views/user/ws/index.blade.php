@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">User Web Service</h1>
            <div class="d-flex justify-content-end">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Update WS
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="exampleModalLabel">Update WS</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label>Pilih OPD</label>
                                <select class="form-select" name="opd" id="">
                                    
                                    @foreach ($opd as $value)
                                        <option value="{{ $value['opd'] }}">{{ $value['opd'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="modal-footer">
                                <form action="{{ route('user_ws.update_ws') }}" method="post">
                                    @csrf
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Tidak
                                    </button>
                                    <button type="submit" class="btn btn-primary">Yakin</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped" id="basic-datatables">
                    <thead>
                        <tr class="table-primary">
                            <td>No</td>
                            <td>OPD</td>
                            <td>Kategori</td>
                            <td>NIK</td>
                            <td>NIP</td>
                            <td>Nama</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $no=> $item)
                            <tr>
                                <td>{{ $no + 1 }}</td>
                                <td>{{ $item->opd }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                            </tr>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
