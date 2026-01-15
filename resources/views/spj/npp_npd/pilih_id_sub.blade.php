@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">
                Buat NPP - NPD
            </h1>
            <form action="{{  route('npp_npd.npp_npd_temp') }}" method="get">
                <div class="row">
                    <div class="col-lg-2">
                        <label for="" class="fw-bold">Pilih NPP/NPD/KKPD</label>
                    </div>
                    <div class="col-lg-10">
                        <select class="form-control" name="npp_npd_kkpd" id="">
                            <option value="npp">NPP</option>
                            <option value="npd">NPD</option>
                            <option value="kkpd">KKPD</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-2">
                        <label for="" class="fw-bold">Pilih Id Sub</label>
                    </div>
                    <div class="col-lg-10">
                        <select class="form-control" name="id_sub" id="" required>
                            <option value="" selected disabled>Pilh Id Sub</option>
                            @foreach ($id_sub as $item)
                                <option value="{{ $item->id_sub }}">{{ $item->id_sub }} - {{ $item->uraian_sub }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary" type="submit">Pilih</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection
