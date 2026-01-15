@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                NPP - NPD {{ bulanIndo($bulan ?? date('m')) }}
            </h1>
            <div class="d-flex justify-content-between">
                <a class="btn btn-primary" href="{{ route('npp_npd.buat_nppnpd') }}">Buat NPP NPD</a>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Id Sub</th>
                            <th>Nomor</th>
                            <th>Sumber Dana</th>
                            <th>Sub Kegiatan</th>
                            <th>Pencairan</th>
                            <th>Posisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->id_sub->id_sub }}</td>
                                <td>{{ $item->nomor }}</td>
                                <td>{{ $item->sumber_dana }}</td>
                                <td>{{ $item->id_sub->uraian_sub }}</td>
                                <td class="text-end">{{ number_format($item->total_pencairan, 0, ',', '.') }}</td>
                                <td>
                                    @switch($item->status)
                                        @case(0)
                                            Pembuat Spj
                                        @break

                                        @case(1)
                                            PPTK
                                        @break

                                        @case(3)
                                            Bendahara
                                        @case(4)
                                            Final
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td>
                                    <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        Pilih
                                    </button>
                                    <a href="{{ route('npp_npd.show', $item->id) }}" class="btn btn-info">Detail</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    
                                <div class="collapse" id="collapseExample">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="table-secondary text-center">
                                                    <th>No</th>
                                                    <th>Rekening</th>
                                                    <th>Paket Pekerjaan</th>
                                                    <th>Uraian</th>
                                                    <th>Nominal</th>
                                                    <th>Pencairan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item->npp_npd_details as $detailIndex => $detail)
                                                    <tr>
                                                        <td>{{ $detailIndex + 1 }}</td>
                                                        <td>{{ $detail->rekening }}</td>
                                                        <td>{{ $detail->paket_pekerjaan }}</td>
                                                        <td>{{ $detail->uraian }}</td>
                                                        <td class="text-end">{{ number_format($detail->anggaran, 0, ',', '.') }}</td>
                                                        <td class="text-end">{{ number_format($detail->pencairan, 0, ',', '.') }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
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
