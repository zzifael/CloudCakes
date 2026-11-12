@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Data Pelanggan Toko</h3>
        
        <!-- Tombol Tambah Pelanggan (Khusus Kasir) -->
        @if(Auth::user()->role === 'kasir')
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCustModal">+ Tambah Pelanggan</button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr>
                        <td><strong>{{ $c->name }}</strong></td>
                        <td>{{ $c->phone }}</td>
                        <td>{{ $c->address ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada data pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Pelanggan (Khusus Kasir) -->
@if(Auth::user()->role === 'kasir')
<div class="modal fade" id="createCustModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('customers.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Pelanggan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Pelanggan</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukkan nama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">No. HP / WhatsApp</label>
                    <input type="text" name="phone" class="form-control" placeholder="08xxxxxxxxxx" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Alamat</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="Masukkan alamat (opsional)"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection