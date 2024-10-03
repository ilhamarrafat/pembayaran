<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Tagihan Santri</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2,
        h3 {
            margin: 0 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
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

        th {
            background-color: #f2f2f2;
        }

        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }

        .signature {
            text-align: center;
            width: 30%;
        }

        .stamp {
            text-align: center;
            width: 30%;
            margin-top: 40px;
        }

        .stamp img {
            width: 80px;
            /* Ukuran gambar stampel */
            height: auto;
        }

        .total {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <h2>Tagihan Santri</h2>
    <p><strong>Nama Santri:</strong> {{ $santri->nama }}</p>
    <p><strong>Kelas:</strong> {{ $santri->kelas->kelas }}</p>
    <p><strong>Tingkat:</strong> {{ $santri->tingkat->tingkat }}</p>
    <p><strong>Waktu Transaksi:</strong> {{ $transaksi->waktu_transaksi }}</p>

    <h3>Detail Tagihan</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tagihan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tagihan as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama_tagihan }}</td>
                <td>{{ number_format($item->nominal_tagihan, 2, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" class="total">Total Bayar</td>
                <td class="total">{{ number_format($transaksi->total_bayar, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature">
            <p><strong>Bendahara</strong></p>
            <p></p>
            <p></p>
            <p>(____________________)</p>
            <p>Tanda Tangan</p>
        </div>
    </div>
</body>

</html>