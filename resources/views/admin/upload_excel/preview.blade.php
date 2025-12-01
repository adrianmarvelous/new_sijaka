<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach ($rows->first() as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows->skip(1) as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <button id="btnSave" class="btn btn-success mt-3">Save to Database</button>

    {{-- Hidden JSON rows --}}
    <script type="application/json" id="rows-data">
        {!! json_encode($rows->toArray()) !!}
    </script>
</div>
