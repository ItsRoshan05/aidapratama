<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customers = Customer::all();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nohp' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        $data['email'] = '-'; // otomatis isi email dengan '-'
        $data['jenis_kelamin'] = $request->jenis_kelamin ?? 'L'; // default jenis kelamin Laki-laki

        Customer::create($data);
        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:100',
            'nohp' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tipe_bank' => 'nullable|string|max:50',
            'nama_bank' => 'nullable|string|max:50',
            'no_rekening' => 'nullable|string|max:20',
            'atas_nama' => 'nullable|string|max:100',
        ]);
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());
        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}
