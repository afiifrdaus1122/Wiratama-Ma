<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientLogo;
use Illuminate\Support\Facades\Storage;

class ClientLogoController extends Controller
{
    public function index()
    {
        $logos = ClientLogo::orderBy('order')->paginate(10);
        return view('admin.client_logos.index', compact('logos'));
    }

    public function create()
    {
        return view('admin.client_logos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('clients', 'public');
        }

        ClientLogo::create($data);

        return redirect()->route('admin.client-logos.index')->with('success', 'Logo klien berhasil ditambahkan.');
    }

    public function edit(ClientLogo $clientLogo)
    {
        return view('admin.client_logos.edit', compact('clientLogo'));
    }

    public function update(Request $request, ClientLogo $clientLogo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($clientLogo->image) {
                Storage::disk('public')->delete($clientLogo->image);
            }
            $data['image'] = $request->file('image')->store('clients', 'public');
        }

        $clientLogo->update($data);

        return redirect()->route('admin.client-logos.index')->with('success', 'Logo klien berhasil diperbarui.');
    }

    public function destroy(ClientLogo $clientLogo)
    {
        if ($clientLogo->image) {
            Storage::disk('public')->delete($clientLogo->image);
        }
        $clientLogo->delete();
        
        return redirect()->route('admin.client-logos.index')->with('success', 'Logo klien berhasil dihapus.');
    }
}
