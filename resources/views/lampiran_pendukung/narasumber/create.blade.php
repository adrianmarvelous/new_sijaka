@extends('dashboard')

@section('content')
    <div class="row mt-3 p-3">
        <div class="card shadow p-3">
            <div class="p-3">
                <h1 class="text-center">
                    {{ isset($header) ? 'Edit Acara Narasumber' : 'Tambah Acara Narasumber' }}
                </h1>

                <form action="{{ isset($header) ? route('lampiran_narasumber.update', $header->id) : route('lampiran_narasumber.store') }}" method="POST">
                    @csrf
                    @if(isset($header))
                        @method('PUT')
                    @endif

                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Tanggal Acara</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <input type="date" name="tanggal" class="form-control" 
                                   value="{{ isset($header) ? date('Y-m-d', strtotime($header->tanggal)) : old('tanggal') }}">
                        </div>
                    </div>
                    {{-- <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Tanggal Surat Kesediaan</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <select name="tanggal_surat_kesediaan" class="form-select" id="">
                                <option value="-1">H - 1</option>
                                <option value="0">Hari H</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Acara</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <input type="text" name="acara" class="form-control" 
                                   value="{{ isset($header) ? $header->acara : old('acara') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Tempat</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <input type="text" name="tempat" class="form-control" 
                                   value="{{ isset($header) ? $header->tempat : old('tempat') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Pukul Mulai</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <input type="time" name="pukul_mulai" class="form-control" 
                                   value="{{ isset($header) ? $header->pukul_mulai : old('pukul_mulai') }}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Pukul Selesai</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <input type="time" name="pukul_selesai" class="form-control" 
                                   value="{{ isset($header) ? $header->pukul_selesai : old('pukul_selesai') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Tanggal Undangan</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <input type="date" name="tgl_undangan" class="form-control" 
                                   value="{{ isset($header) ? date('Y-m-d', strtotime($header->tgl_undangan)) : old('tgl_undangan') }}">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-4">
                            <p class="fw-bold">Komponen Narsum yang Dipilih</p>
                        </div>
                        <div class="col-lg-10 col-md-8">
                            <select name="komponen" class="form-select" id="">
                                <option value="Narasumber Setingkat  Staf/Eselon 2/3/4">Narasumber Setingkat  Staf/Eselon 2/3/4</option>
                                <option value="Tenaga Pakar/Praktisi">Tenaga Pakar/Praktisi</option>
                            </select>
                        </div>
                    </div>
                    @for ($i = 1; $i < 5; $i++)
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-4">
                                <p class="fw-bold">Paket Pekerjaan {{$i}}</p>
                            </div>
                            <div class="col-lg-10 col-md-8">
                                <input list="komponen_list{{ $i }}" name="paket_pekerjaan_{{$i}}" value="{{ isset($header) ? $header->{'paket_pekerjaan_'.$i} : old('paket_pekerjaan_'.$i) }}" class="form-control" placeholder="Cari paket pekerjaan..." />

                                <datalist id="komponen_list{{ $i }}">
                                    @foreach ($allPekerjaan as $item)
                                        <option value="{{ $item['pekerjaan_id'] }}">
                                            {{ $item['nama_pekerjaan'] }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </div>

                        </div>
                    @endfor


                    @isset($header)
                        <div class="row mt-3">
                            <p class="fw-bold" style="text-decoration: underline">Resume Rapat</p>
                            <textarea id="summernote" name="masukan">{!! isset($header) ? html_entity_decode($header->masukan) : old('masukan') !!}</textarea>
                        </div>
                    @endisset

                    <button type="submit" class="btn btn-primary mt-3">
                        {{ isset($header) ? 'Update Acara' : 'Simpan Acara' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
