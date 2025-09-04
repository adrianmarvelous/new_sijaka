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
                
            </div>
        </div>
    </div>
    
@endsection
