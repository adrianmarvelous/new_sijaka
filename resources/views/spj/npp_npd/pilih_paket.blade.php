@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                Pilih Paket Pekerjaan Id Sub {{ $id_sub }}
            </h1>
            <div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Tambah Paket Pekerjaan
                </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold" id="exampleModalLabel">Tambah Paket Pekerjaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <form action="{{ route('npp_npd.tambah_paket') }}" method="get">
                            <div class="modal-body">
                                <label for="">Pilih Id Paket Pekerjaan</label>
                                
                                <input class="form-select" type="text" id="fruit" name="paket"
                                    list="fruits" autocomplete="off">
                                <datalist id="fruits">
                                    <?php
                                    foreach ($grouped_data1  as $index => $item) { ?>
                                        <option value="<?= $item['pekerjaan_id'] ?>"><?= $item['pekerjaan_id'] . ' - ' . $item['nama_pekerjaan'] ?></option>
                                    <?php } ?>
                                </datalist>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id_sub" value="{{$id_sub}}">
                                <input type="hidden" name="npp_npd_kkpd" value="{{$npp_npd_kkpd}}">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <form action="{{ route('npp_npd.pilih_rekening') }}" method="get">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table-primary">
                                <th>No</th>
                                <th>Id Sub</th>
                                <th>Paket Pekerjaan</th>
                                <th>Uraian</th>
                                <th>Alokasi</th>
                                <th>Persentase</th>
                                <th>Rencana Penyerapan</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paket_pekerjaan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->id_sub }}</td>
                                    <td>{{ $item->paket_pekerjaan }}</td>
                                    <td>{{ $item->uraian }}</td>
                                    <td class="text-end">{{ number_format($item->alokasi, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        {{ number_format($item->alokasi / $item->rencana, 2, ',', '.') }}%</td>
                                    <td class="text-end">{{ number_format($item->rencana, 0, ',', '.') }}</td>
                                    <td>
                                        <input type="checkbox" name="paket_pekerjaan[]"
                                            value="{{ $item->paket_pekerjaan }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    <input type="hidden" name="id_sub" value="{{$id_sub}}">
                    <input type="hidden" name="npp_npd_kkpd" value="{{$npp_npd_kkpd}}">
                    <button class="btn btn-primary" type="submit">Lanjut</button>
                </div>
            </form>
        </div>
    </div>
@endsection
