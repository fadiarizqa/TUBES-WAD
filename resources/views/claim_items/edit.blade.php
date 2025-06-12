<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Response Klaim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4">Edit Response Klaim</h2>

        <div class="card mb-4">
            <div class="card-header">Data Klaim</div>
            <div class="card-body">
                <p><strong>Nama Lengkap:</strong> {{ $claimUser->nama_lengkap }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $claimUser->nomor_telepon }}</p>
                <p><strong>Media Sosial:</strong> {{ $claimUser->media_sosial }}</p>
                <p><strong>Lokasi Kehilangan:</strong> {{ $claimUser->lokasi_kehilangan }}</p>
                <p><strong>Waktu Kehilangan:</strong> {{ $claimUser->waktu_kehilangan }}</p>
                <p><strong>Deskripsi Klaim:</strong> {{ $claimUser->deskripsi_claim }}</p>
                @if($claimUser->bukti_kepemilikan)
                    <p><strong>Bukti Kepemilikan:</strong></p>
                    <img src="{{ asset('storage/' . $claimUser->bukti_kepemilikan) }}" alt="Bukti Kepemilikan" style="max-width: 300px;">
                @endif
            </div>
        </div>

        <form action="{{ route('admin.claim_response.update', $claimUser->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="pending" {{ $claimUser->response?->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ $claimUser->response?->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ $claimUser->response?->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="message" class="form-label">Pesan untuk Pengklaim</label>
                <textarea name="message" id="message" rows="4" class="form-control">{{ $claimUser->response?->message }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Response</button>
            <a href="{{ route('claim_r_
