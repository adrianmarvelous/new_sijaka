@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                Pilih Paket Pekerjaan Id Sub
            </h1>
            <form action="{{ route('npp_npd.store') }}" method="post">
                @csrf
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table-primary">
                                <th>No</th>
                                <th>Rekening</th>
                                <th>Paket Pekerjaan</th>
                                <th>Komponen</th>
                                <th>Anggaran</th>
                                <th>Pencairan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                                // dd($ws);
                            @endphp
                            @foreach ($ws as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['rekening_kode'] }}</td>
                                    <td>{{ $item['nama_pekerjaan'] }}</td>
                                    <td>{{ $item['nama_komponen'] }}</td>

                                    <input type="hidden" name="data[{{ $item['komponen_id'] }}][komponen_id]" value="{{ $item['komponen_id'] }}">
                                    <input type="hidden" name="data[{{ $item['komponen_id'] }}][pekerjaan_id]" value="{{ $item['pekerjaan_id'] }}">
                                    <input type="hidden" name="data[{{ $item['komponen_id'] }}][nama_komponen]" value="{{ $item['nama_komponen'] }}">
                                    <input type="hidden" name="data[{{ $item['komponen_id'] }}][rekening_kode]" value="{{ $item['rekening_kode'] }}">
                                    <input type="hidden" name="data[{{ $item['komponen_id'] }}][nominal]" value="{{ $item['nominal'] }}">

                                    <td class="text-end">
                                        {{ number_format($item['nominal'], 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <input class="form-control" type="text" name="data[{{ $item['komponen_id'] }}][pencairan]" value="">
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <input type="hidden" name="id_sub" value="{{$id_sub}}">
                    <input type="hidden" name="npp_npd_kkpd" value="{{$npp_npd_kkpd}}">
                    <button type="submit" class="btn btn-primary" type="submit">Lanjut</button>
                </div>
            </form>
        </div>
    </div>
@endsection
