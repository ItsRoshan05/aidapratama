<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suplier;

class SuplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $supliers = Suplier::all();
        return view('admin.supliers.index', compact('supliers'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.supliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:100',
            'nohp' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nama_pt' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'tipe_bank' => 'nullable|string|max:50',
            'nama_bank' => 'nullable|string|max:50',
            'no_rekening' => 'nullable|string|max:20',
            'atas_nama' => 'nullable|string|max:100',
        ]);
        Suplier::create($request->all());
        return redirect()->route('admin.supliers.index')->with('success', 'Suplier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $suplier = Suplier::findOrFail($id);
        return view('admin.supliers.show', compact('suplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $suplier = Suplier::findOrFail($id);
        return view('admin.supliers.edit', compact('suplier'));
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
            'nama_pt' => 'nullable|string|max:100',
            'brand' => 'nullable|string|max:100',
            'tipe_bank' => 'nullable|string|max:50',
            'nama_bank' => 'nullable|string|max:50',
            'no_rekening' => 'nullable|string|max:20',
            'atas_nama' => 'nullable|string|max:100',
        ]);
        $suplier = Suplier::findOrFail($id);
        $suplier->update($request->all());
        return redirect()->route('admin.supliers.index')->with('success', 'Suplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $suplier = Suplier::findOrFail($id);
        $suplier->delete();
        return redirect()->route('admin.supliers.index')->with('success', 'Suplier deleted successfully.');
    }
}
