@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Katalog Roti & Cake</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">+ Tambah Roti Baru</button>
    </div>

    <!-- Filter & Search -->
    <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama roti..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="category_id" class="form-select">
                <option value="">-- Filter Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">-- Urutkan Harga --</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Termurah</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Termahal</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-secondary w-100">Cari</button>
        </div>
    </form>

    <!-- Tabel Data Roti -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Roti</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $p)
                    <tr>
                        <td>
                            @if($p->image)
                                <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}" width="50" height="50" class="rounded-3 shadow-sm" style="object-fit: cover;">
                            @else
                                <span class="badge bg-secondary">Tanpa Foto</span>
                            @endif
                        </td>
                        <td><strong>{{ $p->name }}</strong></td>
                        <td><small class="text-muted">{{ Str::limit($p->description, 30) ?? '-' }}</small></td>
                        <td><span class="badge bg-info text-dark">{{ $p->category->name }}</span></td>
                        <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                        <td>{{ $p->stock }} pcs</td>
                        <td>
                            <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus data roti ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Data roti tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Produk + Upload Foto -->
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Roti Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Roti</label>
                    <input type="text" name="name" class="form-control" required placeholder="Misal: Red Velvet Cake">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="category_id" class="form-select" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" required min="0" placeholder="25000">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Stok Awal</label>
                        <input type="number" name="stock" class="form-control" required min="0" placeholder="15">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi Roti</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan rasa dan keunggulan roti ini..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Foto Roti (Opsional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Roti</button>
            </div>
        </form>
    </div>
</div>
@endsection