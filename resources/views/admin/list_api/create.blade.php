@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                {{ isset($api) ? 'Edit API' : 'Buat API Baru' }}
            </h1>

            <form action="{{ isset($api) ? route('list_api.update', $api->id) : route('list_api.store') }}" method="post">
                @csrf
                @if (isset($api))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-lg-2 col-md-4">
                        <p class="fw-bold">Nama OPD</p>
                    </div>
                    <div class="col-lg-10 col-md-8">
                        <select name="opd_name" class="form-select">
                            <option value="" disabled {{ !isset($api) ? 'selected' : '' }}>Pilih OPD</option>
                            @foreach ($opds as $opd)
                                <option value="{{ $opd->opd }}"
                                    {{ isset($api) && $api->opd_name == $opd->opd ? 'selected' : '' }}>
                                    {{ $opd->opd }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-2 col-md-4">
                        <p class="fw-bold">Nama API</p>
                    </div>
                    <div class="col-lg-10 col-md-8">
                        <select class="form-select" name="api_name">
                            <option value="" disabled
                                {{ old('api_name', $api->api_name ?? '') == '' ? 'selected' : '' }}>
                                Pilih Salah Satu
                            </option>

                            <option value="f1" {{ old('api_name', $api->api_name ?? '') == 'f1' ? 'selected' : '' }}>
                                F1
                            </option>

                            <option value="id_transaksi"
                                {{ old('api_name', $api->api_name ?? '') == 'id_transaksi' ? 'selected' : '' }}>
                                Id Transaksi
                            </option>

                            <option value="edelivery_spl"
                                {{ old('api_name', $api->api_name ?? '') == 'edelivery_spl' ? 'selected' : '' }}>
                                Edelivery SPL
                            </option>

                            <option value="edelivery_honor"
                                {{ old('api_name', $api->api_name ?? '') == 'edelivery_honor' ? 'selected' : '' }}>
                                Edelivery Honor
                            </option>

                            <option value="edelivery_data_pendukung"
                                {{ old('api_name', $api->api_name ?? '') == 'edelivery_data_pendukung' ? 'selected' : '' }}>
                                Edelivery Data Pendukung
                            </option>

                            <option value="edelivery_data_pendukung_narasumber"
                                {{ old('api_name', $api->api_name ?? '') == 'edelivery_data_pendukung_narasumber' ? 'selected' : '' }}>
                                Edelivery Data Pendukung Narasumber
                            </option>
                        </select>

                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-2 col-md-4">
                        <p class="fw-bold">URL</p>
                    </div>
                    <div class="col-lg-10 col-md-8">
                        <input type="text" class="form-control" name="api_url"
                            value="{{ old('api_url', $api->api_url ?? '') }}" placeholder="Masukkan URL">
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-2 col-md-4">
                        <p class="fw-bold">Username</p>
                    </div>
                    <div class="col-lg-10 col-md-8">
                        <input type="text" class="form-control" name="username"
                            value="{{ old('username', $api->username ?? '') }}" placeholder="Masukkan username">
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-2 col-md-4">
                        <p class="fw-bold">Secret Key</p>
                    </div>
                    <div class="col-lg-10 col-md-8">
                        <input type="text" class="form-control" name="secret"
                            value="{{ old('secret', $api->secret ?? '') }}" placeholder="Masukkan secret key">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($api) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
