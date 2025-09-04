@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                {{ ($penyedia ?? null) ? 'Edit Penyedia' : 'Tambah Penyedia Baru' }}
            </h1>

            <form action="{{ isset($penyedia) ? route('penyedia.update', $penyedia->id) : route('penyedia.store') }}"
                method="post"
                enctype="multipart/form-data">


                @csrf
                @isset($penyedia)
                    @method('PUT')
                @endisset

                {{-- Input Text --}}
                <div class="p-3 card shadow border">
                    @php
                        $labels = ['Username','Password','Nama','Direktur','Alamat','Telepon','Rekening','NPWP'];
                        $kolom = ['username','password','nama','direktur','alamat','telp','rekening','npwp'];
                    @endphp

                    @foreach ($labels as $no => $label)
                    @php
                        $field = $kolom[$no];

                        // Tentukan nilai default
                        if ($label === 'Password') {
                            // Password kosong kalau edit, default "SurabayaHebat" kalau create
                            $value = isset($penyedia) ? '' : 'SurabayaHebat';
                        } else {
                            $value = old($field, isset($penyedia) ? $penyedia->$field : '');
                        }
                    @endphp


                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2">
                                <label class="fw-bold">
                                    {{ $label }}
                                    <span style="color: red">
                                        {{ $label == 'Rekening' ? 'Contoh : Bank Jatim No Rek 230412445' : '' }}
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-10 col-md-10">
                                <input type="text"
                                       name="{{ $field }}"
                                       class="form-control"
                                       {{ $label == 'Nama' ? 'required' : '' }}
                                       value="{{ $value }}"
                                       {{ $label == 'Password' ? 'readonly' : '' }}>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- File Upload --}}
                <div class="p-3 card shadow border">
                    <h3>Dokumen Upload</h3>
                    @php
                        $dokumens = ['npwp_upload','pkp_upload','ref_bank_upload','siup_upload','nib_upload'];
                        $judul = ['NPWP','PKP','Referensi Bank','SIUP','NIB'];
                    @endphp

                    @foreach ($dokumens as $index => $dokumen)
                        <div class="row mt-3">
                            <div class="col-lg-2 col-md-2">
                                <label class="fw-bold">{{ $judul[$index] }}</label>
                            </div>
                            <div class="col-lg-10 col-md-10">
                                <input type="file" name="{{ $dokumen }}" class="form-control" accept="application/pdf">
                                @if(isset($penyedia) && $penyedia->$dokumen)
                                    <small class="text-muted">
                                        File saat ini: 
                                        <a href="{{ asset('storage/'.$penyedia->$dokumen) }}" target="_blank">Lihat</a>
                                    </small>
                                @endif
                            </div>
                        </div>
                    @endforeach


                    {{-- Spesimen --}}
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-2">
                            <label class="fw-bold">Spesimen</label>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <input type="file" name="spesimen" class="form-control" accept="image/*">
                            @if(isset($penyedia) && $penyedia->spesimen)
                                <small class="text-muted">
                                    File saat ini:
                                    <a href="{{ asset('storage/'.$penyedia->spesimen) }}" target="_blank">Lihat</a>
                                </small>
                            @endif

                        </div>
                    </div>

                    {{-- Stempel --}}
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-2">
                            <label class="fw-bold">Stempel</label>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <input type="file" name="stempel" class="form-control" accept="image/*">
                            @if(isset($penyedia) && $penyedia->stempel)
                                <small class="text-muted">
                                    File saat ini:
                                    <a href="{{ asset('storage/'.$penyedia->stempel) }}" target="_blank">Lihat</a>
                                </small>
                            @endif

                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary">
                        {{ isset($penyedia) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
