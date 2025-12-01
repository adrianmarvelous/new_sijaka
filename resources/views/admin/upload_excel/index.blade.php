@extends('dashboard')

@section('content')
<div class="row p-3">
    <div class="card shadow p-3">
        <h1 class="text-center">Upload Excel</h1>
        <div class="d-flex justify-content-end">
            <button id="btnUpload" class="btn btn-primary">Upload Excel</button>
        </div>

        <div class="table-responsive mt-3">
            <div id="previewTable"></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btnUpload').addEventListener('click', function() {
    Swal.fire({
        title: 'Upload Excel',
        html: `
            <form id="formUpload" enctype="multipart/form-data">
                <input type="file" id="fileExcel" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Preview',
        preConfirm: () => {
            const fileInput = document.getElementById('fileExcel');
            if (!fileInput.files[0]) {
                Swal.showValidationMessage('Please select a file!');
            }
            return fileInput.files[0];
        }
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData();
            formData.append('file', result.value);
            formData.append('_token', '{{ csrf_token() }}');

            fetch("{{ route('upload_excel.preview') }}", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(html => {
                document.getElementById('previewTable').innerHTML = html;

                // Find Save button inside preview
                const btnSave = document.getElementById('btnSave');
                if (btnSave) {
                    btnSave.addEventListener('click', function() {
                        console.log("Save button clicked!");
                        const rows = JSON.parse(document.getElementById('rows-data').textContent);
                        console.log("Rows to send:", rows);

                        fetch("{{ route('upload_excel.store') }}", {
                            method: "POST",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ rows: rows })
                        })
                        .then(res => res.json())
                        .then(res => {
                            console.log("Response:", res);
                            if (res.error) {
                                console.error("Server error:", res.error);
                            } else {
                                Swal.fire('Success', res.message, 'success');
                                document.getElementById('previewTable').innerHTML = '';
                            }
                        })
                        .catch(err => {
                            console.error("Fetch error:", err);
                        });
                    });
                }
            })
            .catch(err => {
                console.error("Preview error:", err);
            });
        }
    });
});
</script>
@endsection
