<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artists = Artist::all();
        return view('admin.artists.index', compact('artists'));
    }

    public function create()
    {
        return view('admin.artists.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
            ],
            [
                'name.required' => 'Nama artis wajib diisi.',
                'photo.required' => 'Foto Artis wajib diisi.',
                'photo.image' => 'Gambar tidak valid.',
                'photo.max' => 'Gambar tidak boleh lebih besar dari 2MB.',
                'photo.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            ]
        );

        $data = $validatedData;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        Artist::create($data);

        return redirect()->route('admin.artists.index')->with('success', 'Artis Berhasih Ditambahkan.');
    }

    public function show(Artist $artist)
    {
        return view('admin.artists.show', compact('artist'));
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    public function update(Request $request, Artist $artist)
    {
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'name.required' => 'Nama artis wajib diisi.',
                'photo.required' => 'Foto Artis wajib diisi.',
                'photo.image' => 'Gambar tidak valid.',
                'photo.max' => 'Gambar tidak boleh lebih besar dari 2MB.',
                'photo.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            ]
        );

        $data = $validatedData;

        if ($request->hasFile('photo')) {
            if ($artist->photo && Storage::exists('public/photos/' . $artist->photo)) {
                Storage::delete('public/photos/' . $artist->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        $artist->update($data);
        return redirect()->route('admin.artists.index')->with('success', 'Data Artis barhasil Di Edit.');
    }

    public function destroy(Artist $artist)
    {
        if ($artist->songs()->count() > 0) {
            return redirect()->route('admin.artists.index')
                ->with('error', 'Artis ini tidak bisa dihapus karena ada lagu yang terkait.');
        }

        if ($artist->photo && Storage::exists('public/photos/' . $artist->photo)) {
            Storage::delete('public/photos/' . $artist->photo);
        }

        $artist->delete();

        return redirect()->route('admin.artists.index')->with('success', 'Data Artis Berhasil Dihapus.');
    }
}
