@extends('layouts.app')

@section('content')
<div class="container py-2">
    <h3 class="fw-bold mb-4">Transaksi Baru</h3>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
        @csrf
        <div class="row">
            <!-- Left Side: Select Customer & Product -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">1. Data Pelanggan</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Pelanggan</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach($customers as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">2. Pilih Roti / Cake</h5>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Pilih Roti</label>
                            <select id="productSelect" class="form-select">
                                <option value="">-- Pilih Roti --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" 
                                            data-name="{{ $p->name }}" 
                                            data-price="{{ $p->price }}" 
                                            data-stock="{{ $p->stock }}"
                                            data-image="{{ $p->image ? asset('storage/' . $p->image) : '' }}">
                                        {{ $p->name }} - Rp {{ number_format($p->price, 0, ',', '.') }} (Stok: {{ $p->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah (Qty)</label>
                            <input type="number" id="qtyInput" class="form-control" value="1" min="1">
                        </div>
                        <button type="button" id="btnAddItem" class="btn btn-primary w-100">+ Tambah ke Pesanan</button>
                    </div>
                </div>
            </div>

            <!-- Right Side: Cart Table -->
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Rincian Belanja</h5>
                        <div class="table-responsive">
                            <table class="table align-middle" id="cartTable">
                                <thead>
                                    <tr>
                                        <th>Foto</th>
                                        <th>Roti</th>
                                        <th>Harga</th>
                                        <th width="90">Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="emptyRow">
                                        <td colspan="6" class="text-center text-muted">Belum ada item dipilih.</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-end fw-bold fs-5">Total Pembayaran:</th>
                                        <th colspan="2" class="fw-bold fs-5 text-primary" id="totalDisplay">Rp 0</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold mt-3" id="btnSubmit">Proses & Simpan Transaksi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let cart = [];
    const productSelect = document.getElementById('productSelect');
    const qtyInput = document.getElementById('qtyInput');
    const btnAddItem = document.getElementById('btnAddItem');
    const cartTableBody = document.querySelector('#cartTable tbody');
    const totalDisplay = document.getElementById('totalDisplay');

    btnAddItem.addEventListener('click', function() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (!selectedOption.value) {
            alert('Silakan pilih roti terlebih dahulu!');
            return;
        }

        const id = selectedOption.value;
        const name = selectedOption.dataset.name;
        const price = parseFloat(selectedOption.dataset.price);
        const stock = parseInt(selectedOption.dataset.stock);
        const image = selectedOption.dataset.image;
        const qty = parseInt(qtyInput.value);

        if (qty <= 0 || isNaN(qty)) {
            alert('Jumlah item minimal 1!');
            return;
        }

        if (qty > stock) {
            alert(`Stok tidak mencukupi! Stok tersisa: ${stock}`);
            return;
        }

        const existingIndex = cart.findIndex(item => item.id === id);
        if (existingIndex > -1) {
            if (cart[existingIndex].qty + qty > stock) {
                alert(`Total jumlah melebihi stok yang tersedia (${stock})!`);
                return;
            }
            cart[existingIndex].qty += qty;
        } else {
            cart.push({ id, name, price, qty, image });
        }

        renderCart();
    });

    function renderCart() {
        cartTableBody.innerHTML = '';

        if (cart.length === 0) {
            cartTableBody.innerHTML = '<tr id="emptyRow"><td colspan="6" class="text-center text-muted">Belum ada item dipilih.</td></tr>';
            totalDisplay.innerText = 'Rp 0';
            return;
        }

        let total = 0;

        cart.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            total += subtotal;

            const imageHtml = item.image 
                ? `<img src="${item.image}" width="40" height="40" class="rounded-3 shadow-sm" style="object-fit: cover;">`
                : `<span class="badge bg-secondary" style="font-size: 10px;">Tanpa Foto</span>`;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${imageHtml}</td>
                <td>
                    <strong>${item.name}</strong>
                    <input type="hidden" name="details[${index}][product_id]" value="${item.id}">
                </td>
                <td>Rp ${item.price.toLocaleString('id-ID')}</td>
                <td>
                    <input type="number" name="details[${index}][quantity]" class="form-control form-control-sm" value="${item.qty}" min="1" onchange="updateQty(${index}, this.value)">
                </td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeItem(${index})">✕</button>
                </td>
            `;
            cartTableBody.appendChild(tr);
        });

        totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    function updateQty(index, newQty) {
        const qty = parseInt(newQty);
        if (qty > 0) {
            cart[index].qty = qty;
            renderCart();
        }
    }

    function removeItem(index) {
        cart.splice(index, 1);
        renderCart();
    }

    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        if (cart.length === 0) {
            e.preventDefault();
            alert('Keranjang belanja masih kosong! Tambahkan roti terlebih dahulu.');
        }
    });
</script>
@endsection