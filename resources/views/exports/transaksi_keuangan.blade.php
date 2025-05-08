<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Keterangan</th>
            <th>Pemasukan</th>
            <th>Pengeluaran</th>
            <th>Kumulatif Saldo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $row['tanggal'] }}</td>
                <td>{{ $row['judul'] }}</td>
                <td>{{ number_format($row['pemasukan'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['pengeluaran'], 0, ',', '.') }}</td>
                <td>{{ number_format($row['saldo'], 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
