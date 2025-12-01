@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                List Acara Narasumber {{ bulanIndo($bulan ?? date('m')) }}
            </h1>

            <div class="d-flex justify-content-between p-3">
                {{-- Form to filter by month --}}
                <form action="{{ route('lampiran_narasumber.index') }}" method="GET">
                    <select class="form-select" name="bulan" onchange="this.form.submit()">
                            <option value="" selected disabled>Pilih Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </form>

                <div>
                    <a class="btn btn-primary" href="{{ route('lampiran_narasumber.create') }}">Tambah Narasumber</a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-responsive table-striped table-bordered table-hover">
                    <thead class="table-primary">
                        <th>No</th>
                        <th style="width: 140px">Tanggal</th>
                        <th>Acara</th>
                        <th>Tempat</th>
                        <th>Pukul Mulai</th>
                        <th>Pukul Selesai</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($narsum_daftar_hadir_header as $index => $item)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ date('d-M-Y',strtotime($item->tanggal))  }}</td>
                                <td>{{ $item->acara }}</td>
                                <td>{{ $item->tempat }}</td>
                                <td class="text-center">{{ date('H:i',strtotime($item->pukul_mulai))  }}</td>
                                <td class="text-center">{{ date('H:i',strtotime($item->pukul_selesai))  }}</td>
                                <td><a class="btn btn-primary" href="{{ route('lampiran_narasumber.show',['lampiran_narasumber' => $item->id]) }}"><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
@endsection
