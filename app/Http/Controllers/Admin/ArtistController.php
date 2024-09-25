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
        // Validasi data
        $validatedData = $request->validate(
            [
                'name' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ],
            [
                'name.required' => 'Nama artis wajib diisi.',
                'photo.required' => 'Foto Artis wajib diisi.',
            ]
        );

        // Menyiapkan data untuk disimpan
        $data = $validatedData;

        // Menyimpan file foto
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/photos', $filename);
            $data['photo'] = $filename;
        }

        // Membuat artis baru
        Artist::create($data);

        // Redirect dengan pesan sukses
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
        // Cek apakah artis sedang digunakan di tabel songs
        if ($artist->songs()->count() > 0) {
            // Jika artis terkait dengan satu atau lebih lagu, tampilkan pesan kesalahan
            return redirect()->route('admin.artists.index')
                ->with('error', 'Artis ini tidak bisa dihapus karena ada lagu yang terkait.');
        }

        // Hapus foto jika ada
        if ($artist->photo && Storage::exists('public/photos/' . $artist->photo)) {
            Storage::delete('public/photos/' . $artist->photo);
        }

        // Hapus artis
        $artist->delete();

        return redirect()->route('admin.artists.index')->with('success', 'Data Artis Berhasil Dihapus.');
    }
}
