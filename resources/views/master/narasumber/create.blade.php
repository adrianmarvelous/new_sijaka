@extends('dashboard')

@section('content')
<div class="row p-3">
    <div class="card shadow p-3">
        <h1 class="text-center">
            {{ isset($narasumber) ? 'Edit Narasumber' : 'Tambah Narasumber Baru' }}
        </h1>

        <form action="{{ isset($narasumber) ? route('narasumber.update', $narasumber->id) : route('narasumber.store') }}"
              method="post"
              enctype="multipart/form-data">

            @csrf
            @if(isset($narasumber))
                @method('PUT')
            @endif

            {{-- Input Text --}}
            <div class="p-3 card shadow border">
                @php
                    $labels = ['Username','Password','Nama','NIP','NIK','Instansi','NPWP','Nama Bank','Rekening'];
                    $kolom = ['username','password','nama','nip','nik','instansi','npwp','nama_bank','rekening'];
                @endphp
                @foreach ($labels as $no => $label)
                    @php
                        $field = $kolom[$no];
                        // Tentukan nilai default
                        if($label === 'Password'){
                            $value = isset($narasumber) ? '' : 'SurabayaHebat';
                        } else {
                            $value = old($field, isset($narasumber) ? $narasumber->$field : '');
                        }
                    @endphp
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-2">
                            <label class="fw-bold">
                                {{ $label }}
                                <span style="color:red">
                                    {{ $label == 'Rekening' ? 'Contoh: Bank Jatim No Rek 230412445' : '' }}
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
                    $dokumens = ['npwp_upload','ktp_upload','cv_upload','kak_upload'];
                    $judul = ['NPWP','KTP','CV','KAK'];
                @endphp

                @foreach($dokumens as $index => $dokumen)
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-2">
                            <label class="fw-bold">{{ $judul[$index] }}</label>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            <input type="file" name="{{ $dokumen }}" class="form-control" accept="application/pdf">
                            @if(isset($narasumber) && $narasumber->$dokumen)
                                <small class="text-muted">
                                    File saat ini:
                                    <a href="{{ asset('storage/'.$narasumber->$dokumen) }}" target="_blank">Lihat</a>
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
                        @if(isset($narasumber) && $narasumber->spesimen)
                            <small class="text-muted">
                                File saat ini:
                                <a href="{{ asset('storage/'.$narasumber->spesimen) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary">
                    {{ isset($narasumber) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
