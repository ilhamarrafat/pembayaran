<!DOCTYPE html>
<html>

<head>
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>{{ $data['title'] }}</h1>

    <table>
        <tr>
            <th>Nama</th>
            <td>{{ $data['santri']->nama }}</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $data['santri']->Jenis_kelamin }}</td>
        </tr>
        <tr>
            <th>Tempat Lahir</th>
            <td>{{ $data['santri']->Tmp_lhr }}</td>
        </tr>
        <tr>
            <th>Tanggal Lahir</th>
            <td>{{ $data['santri']->Tgl_lhr }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $data['santri']->alamat }}</td>
        </tr>
        <tr>
            <th>Tahun Masuk</th>
            <td>{{ $data['santri']->Thn_masuk }}</td>
        </tr>
        <tr>
            <th>Tahun Keluar</th>
            <td>{{ $data['santri']->Thn_keluar }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $data['santri']->kelas->kelas }}</td>
        </tr>
        <tr>
            <th>Tingkat</th>
            <td>{{ $data['santri']->tingkat->tingkat }}</td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td>{{ $data['santri']->telepon }}</td>
        </tr>
    </table>
</body>

</html>