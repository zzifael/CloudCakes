@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Manajemen Kategori Roti</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCatModal">+ Tambah Kategori</button>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Slug</th>
                        <th>Jumlah Produk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td><strong>{{ $cat->name }}</strong></td>
                        <td><code>{{ $cat->slug }}</code></td>
                        <td><span class="badge bg-secondary">{{ $cat->products_count }} Roti</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="createCatModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('categories.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Kategori Roti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Misal: Roti Sobek" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection