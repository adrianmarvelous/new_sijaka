@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center fw-bold">
                @switch($data->panjar_ls_kkpd)
                    @case('PANJAR')
                        NOTA PENGAJUAN PANJAR (NPP)
                        @break
                    @case('LS')
                        NOTA PENCAIRAN DANA (NPD)
                        @break
                    @case('KKPD')
                        KKPD
                        @break
                    @default
                        
                @endswitch
                <br>
                Bulan {{ bulanIndo($data->tanggal ? date('m', strtotime($data->tanggal)) : date('m')) }}
                {{ $data->tanggal ? date('Y', strtotime($data->tanggal)) : date('Y') }}
                <br>
                Nomor : {{ $data->nomor }}/{{ $data->panjar_ls_kkpd == 'PANJAR' ? 'NPP' : ($data->panjar_ls_kkpd == 'LS' ? 'NPD' : ($data->panjar_ls_kkpd == 'KKPD' ? 'KKPD' : '')) }}/BKPSDM/{{date('Y',strtotime($data->tanggal))}}

            </h1>
            <table>
                <tr>
                    <td style="width: 200px">Kode Kegiatan</td>
                    <td>:</td>
                    <td>{{ $data->id_sub->kode_kegiatan }}</td>
                </tr>
                <tr>
                    <td>Nama Kegiatan</td>
                    <td>:</td>
                    <td>{{ $data->id_sub->uraian_kegiatan }}</td>
                </tr>
                <tr>
                    <td>Pagu Anggaran</td>
                    <td>:</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Jumlah Panjar yang diminta	</td>
                    <td>:</td>
                    <td>{{ number_format($data->total_pencairan, 0, ',', '.') }}</td>
                </tr>
            </table>
            
        </div>
    </div>
@endsection
