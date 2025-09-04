@extends('dashboard')

@section('content')
    <div class="row p-3">
        <div class="card shadow p-3">
            <h1 class="text-center">Test</h1>
            <a class="btn btn-primary" href="{{ route('test.make_users') }}">Make Users</a>
            <button id="btn-alert" class="btn btn-primary">Show Alert</button>

<script>
document.getElementById('btn-alert').addEventListener('click', function () {
    Swal.fire({
        title: 'Hello!',
        text: 'This is a SweetAlert2 demo 🚀',
        icon: 'success',
        confirmButtonText: 'Cool'
    });
});
</script>

        </div>
    </div>
    
@endsection
