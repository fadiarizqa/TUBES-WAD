<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Daftar Klaim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Daftar Klaim Barang Hilang</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Nama Lengkap</th>
                <th>Nomor Telepon</th>
                <th>Media Sosial</th>
                <th>Jenis Barang</th>
                <th>Deskripsi</th>
                <th>Lokasi Kehilangan</th>
                <th>Waktu Kehilangan</th>
                <th>Status</th>
                <th>Pesan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($claims as $claim)
            <tr>
                <td>{{ $claim->nama_lengkap }}</td>
                <td>{{ $claim->nomor_telepon }}</td>
                <td>{{ $claim->media_sosial }}</td>
                <td>{{ $claim->jenis_barang }}</td>
                <td>{{ $claim->deskripsi_barang }}</td>
                <td>{{ $claim->lokasi_kehilangan }}</td>
                <td>{{ $claim->waktu_kehilangan }}</td>
                <td>{{ $claim->response->status ?? 'Belum diproses' }}</td>
                <td>{{ $claim->response->message ?? '-' }}</td>
                <td>
                    <a href="{{ route('claims.response.edit', $claim->id) }}" class="btn btn-sm btn-warning mb-1">Update</a>
                    <form action="{{ route('claims.destroy', $claim->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus klaim ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
