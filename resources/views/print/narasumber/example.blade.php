<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saran Masukan Narasumber</title>
</head>
<style>
    table td, table th {
        vertical-align: top;
    }
</style>

<body>
    <h1 style="text-align:center">Saran/Masukan Narasumber</h1>
    <table>
        <tr>
            <td>Tangal</td>
            <td>:</td>
            <td>{{ date('d-m-Y',strtotime($data->header->tanggal)) }}</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>:</td>
            <td>{{ date('H:i',strtotime($data->header->pukul_mulai)) }} - {{ date('H:i',strtotime($data->header->pukul_selesai)) }}</td>
        </tr>
        <tr>
            <td>Acara</td>
            <td>:</td>
            <td>{{ $data->header->acara }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>{{ $data->header->tempat }}</td>
        </tr>
    </table>

    <p style="text-decoration: underline">Masukan Rapat :</p>
    <p>{!! $data->masukan !!}</p>
    <table style="margin-top:20px; width:100%">
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%;text-align:center">Hormat Saya</td>
        </tr>
        <tr>
            <td style="width: 50%"></td>
            {{-- <td style="width: 50%;text-align:center">{{ $data->master_narasumber->spesimen }}</td> --}}
            <td style="width: 50%;text-align:center"><img src="{{ asset('storage/upload/master/narasumber/spesimen/'.$data->master_narasumber->spesimen) }}" alt=""></td>
        </tr>
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%;text-align:center">{{ $data->master_narasumber->nama }}</td>
        </tr>
    </table>
</body>
</html>