<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    // Halaman Dashboard
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::sum('total_amount');
        $recentTransactions = Transaction::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'totalTransactions', 
            'totalRevenue', 
            'recentTransactions'
        ));
    }

    // Tampilkan Riwayat Transaksi (Untuk Admin & Kasir)
    public function index()
    {
        $transactions = Transaction::with(['customer', 'user', 'details.product'])
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    // Form Tambah Transaksi (Khusus Kasir)
    public function create()
    {
        if (Auth::user()->role !== 'kasir') {
            return redirect()->route('transactions.index')->with('error', 'Admin hanya bertugas memantau riwayat transaksi.');
        }

        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.create', compact('customers', 'products'));
    }

    // Proses Simpan Transaksi (Khusus Kasir)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'kasir') {
            return redirect()->route('transactions.index')->with('error', 'Admin tidak diperbolehkan melakukan transaksi.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'details' => 'required|array|min:1',
        ], [
            'customer_id.required' => 'Pilih pelanggan terlebih dahulu!',
            'details.required' => 'Keranjang belanja tidak boleh kosong!',
        ]);

        DB::beginTransaction();
        try {
            $invoiceNumber = 'TRX-' . strtoupper(Str::random(8));

            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => Auth::id(),
                'customer_id' => $request->customer_id,
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            foreach ($request->details as $item) {
                if (!isset($item['product_id']) || !isset($item['quantity'])) {
                    continue;
                }

                $product = Product::findOrFail($item['product_id']);
                $qty = (int) $item['quantity'];
                $subtotal = $product->price * $qty;
                $totalAmount += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                // Potong Stok Roti
                $product->decrement('stock', $qty);
            }

            $transaction->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaksi ' . $invoiceNumber . ' berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
}