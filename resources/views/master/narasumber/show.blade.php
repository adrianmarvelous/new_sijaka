@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Detail narasumber {{ $narasumber->nama }}</h1>
            <div class="p-3 card shadow border border-secondary">
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">Username</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->username }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">NIP</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->nip }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">NIK</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->nik }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">Nama</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->nama }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">Instansi</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->instansi }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">NPWP</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->npwp }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">Nama Bank</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->nama_bank }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold" for="">Rekening</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <p>{{ $narasumber->rekening }}</p>
                    </div>
                </div>
            </div>
            <div class="p-3 card shadow border border-secondary">
                <h3>Dokumen Upload</h3>
                @php
                    $dokumens = ['npwp_upload','ktp_upload','cv_upload','kak_upload'];
                    $folders = ['npwp','pkp','ref_bank','siup'];
                    $judul = ['NPWP','PKP','Referensi Bank','SIUP'];
                @endphp
                @foreach ($dokumens as $index => $dokumen)
                    <div class="row mt-3">
                        <div class="col-lg-2 col-md-2">
                            <label class="fw-bold">{{ $judul[$index] }}</label>
                        </div>
                        <div class="col-lg-10 col-md-10">
                            @if(!empty($narasumber->$dokumen))
                            <button 
                                class="btn btn-danger view-pdf-btn" 
                                data-pdf="{{ asset('storage/'.$narasumber->$dokumen) }}">
                                <i class="fa fa-file-pdf"></i>
                            </button>

                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="row mt-3">
                    <div class="col-lg-2 col-md-2">
                        <label class="fw-bold">Spesimen</label>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <img src="{{ asset('storage/'.$narasumber->spesimen) }}" width="200" alt="">
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('narasumber.edit',['narasumber' => $narasumber->id]) }}"><i class="fa fa-pen"></i></a>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:90%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview PDF</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="pdfFrame" src="" width="100%" height="600px" frameborder="0"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const buttons = document.querySelectorAll('.view-pdf-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const pdfUrl = this.dataset.pdf;

            // Check if device is mobile
            if (window.innerWidth <= 768) {
                window.open(pdfUrl, '_blank'); // Open in new tab
            } else {
                document.getElementById('pdfFrame').src = pdfUrl;
                const pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
                pdfModal.show();
            }
        });
    });
});
</script>
    
@endsection
