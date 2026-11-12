@extends('layouts.app')

@section('content')
<div class="container py-2">
    <h3 class="fw-bold mb-4">Dashboard Toko CloudCakes</h3>

    <div class="row g-3 mb-4">
    <!-- Total Produk Roti (Soft Purple / Dusty Lavender) -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white" style="background-color: #6c5ce7; border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-2">Total Produk Roti</h6>
                <h2 class="fw-bold mb-0">{{ $totalProducts }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Transaksi (Soft Purple Red / Mauve) -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white" style="background-color: #a29bfe; border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-2">Total Transaksi</h6>
                <h2 class="fw-bold mb-0">{{ $totalTransactions }}</h2>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan (Soft Pastel Amber) -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-white" style="background-color: #fdcb6e; border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-semibold mb-2 text-dark">Total Pendapatan</h6>
                <h2 class="fw-bold mb-0 text-dark">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>
</div>
    <!-- Tabel Transaksi Terbaru -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold py-3">
            🛒 Transaksi Penjualan Terbaru
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Pelanggan</th>
                        <th>Kasir</th>
                        <th>Total Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $t)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $t->invoice_number }}</span></td>
                        <td>{{ $t->customer->name }}</td>
                        <td>{{ $t->user->name }}</td>
                        <td><strong>Rp {{ number_format($t->total_amount, 0, ',', '.') }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada transaksi penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection