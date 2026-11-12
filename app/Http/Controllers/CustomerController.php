<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(5);
        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string',
        ]);

        Customer::create($request->only(['name', 'phone', 'address']));

        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }
}