@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="mb-3">
        <h3 class="fw-bold">Riwayat Transaksi</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>No. Invoice</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Item Roti</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td><span class="badge bg-dark">{{ $t->invoice_number }}</span></td>
                        <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                        <td><strong>{{ $t->customer->name ?? 'Umum' }}</strong></td>
                        <td>
                            <ul class="list-unstyled mb-0 small">
                                @foreach($t->details as $d)
                                    <li>• {{ $d->product->name ?? 'Produk Dihapus' }} (x{{ $d->quantity }})</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="fw-bold text-primary">Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection