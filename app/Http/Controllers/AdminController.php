<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Artikel;
use App\Models\UserDetail;
use Illuminate\Support\Str;
use App\Models\DokterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Function untuk User
    public function index()
    {
        $users = User::with('userDetail')->where('role', 'user')->orderBy('id', 'desc')->get();
        return view('admin.index', compact('users'));
    }

    public function tambahUser(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:100',
            'email'         => 'required|email',
            'password'      => 'required|min:6',
            'no_hp'         => 'required|string|max:20',
            'alamat'        => 'required|string|max:255',
        ]);

        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        UserDetail::create([
            'user_id'   => $user->id,
            'no_hp'     => $request->no_hp,
            'alamat'    => $request->alamat
        ]);

        return redirect()->route('admin.index')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $userDetail = $user->userDetail;
        if ($userDetail) {
            $userDetail->no_hp  = $request->no_hp;
            $userDetail->alamat = $request->alamat;
            $userDetail->save();
        }

        return redirect()->route('admin.index')->with('success', 'User berhasil diperbarui.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->userDetail) {
            $user->userDetail->delete();
        }

        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User berhasil dihapus.');
    }
    // akhir function untuk user


    // function untuk artikel
    public function getArtikel()
    {
        $artikels = Artikel::orderBy('id', 'desc')->get();
        return view('admin.artikel.index', compact('artikels'));
    }

    public function getTambahArtikel()
    {
        return view('admin.artikel.tambah');
    }

    public function storeArtikel(Request $request)
    {
        $request->validate([
            'judul'          => 'required|string|max:255',
            'konten'         => 'required|string',
            'gambar_artikel' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tanggal_terbit' => 'required|date',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar_artikel')) {
            $gambar = $request->file('gambar_artikel');
            $judulSlug = Str::slug($request->judul, '-');
            $tanggal = Carbon::now()->format('Y-m-d');
            $filename = $judulSlug . '-' . $tanggal . '.' . $gambar->getClientOriginalExtension();
            $gambarPath = $gambar->storeAs('artikel', $filename, 'public');
        }

        Artikel::create([
            'judul'          => $request->judul,
            'konten'         => $request->konten,
            'gambar_artikel' => $gambarPath,
            'penulis'        => 'Admin',
            'count_akses'    => 0,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil disimpan.');
    }

    public function editArtikel($id)
    {
        $artikel = Artikel::where('id', $id)->first();
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function updateArtikel(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'tanggal_terbit' => 'required|date',
            'gambar_artikel' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $artikel = Artikel::findOrFail($id);
        $artikel->judul = $request->judul;
        $artikel->konten = $request->konten;
        $artikel->tanggal_terbit = $request->tanggal_terbit;

        if ($request->hasFile('gambar_artikel')) {
            if ($artikel->gambar_artikel && Storage::disk('public')->exists($artikel->gambar_artikel)) {
                Storage::disk('public')->delete($artikel->gambar_artikel);
            }

            $gambar = $request->file('gambar_artikel');
            $judulSlug = Str::slug($request->judul);
            $tanggal = now()->format('Ymd_His');
            $namaFile = $judulSlug . '_' . $tanggal . '.' . $gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('artikel', $namaFile, 'public');
            $artikel->gambar_artikel = $path;
        }

        $artikel->save();

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil diperbarui.');
    }


    public function deleteArtikel($id)
    {
        $artikel = Artikel::findOrFail($id);
        if ($artikel->gambar_artikel && Storage::disk('public')->exists($artikel->gambar_artikel)) {
            Storage::disk('public')->delete($artikel->gambar_artikel);
        }

        $artikel->delete();

        return redirect()->route('admin.artikel')->with('success', 'Artikel berhasil dihapus.');
    }
    // akhir function artikel


    // Function untuk Daftar Dokter
    public function getDokter()
    {
        $dokters = User::with('dokterDetail')->where('role', 'dokter')->orderBy('id', 'desc')->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function tambahDokter(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $user = User::create([
            'name'      => $request->nama,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'dokter'
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_dokter')) {
            $foto = $request->file('foto_dokter');
            $namaFile = Str::slug($request->nama) . '-' . now()->format('Ymd') . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->storeAs('foto-dokter', $namaFile, 'public');
        }

        DokterDetail::create([
            'user_id' => $user->id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'spesialisasi' => $request->spesialisasi,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto_dokter' => $fotoPath,
        ]);

        return redirect()->back()->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function updateDokter(Request $request, $id)
    {
        $dokter = DokterDetail::with('user')->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $dokter->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        if ($request->hasFile('foto_dokter')) {
            if ($dokter->foto_dokter && Storage::disk('public')->exists($dokter->foto_dokter)) {
                Storage::disk('public')->delete($dokter->foto_dokter);
            }

            $foto = $request->file('foto_dokter');
            $namaFile = Str::slug($request->nama) . '-' . now()->format('Ymd') . '.' . $foto->getClientOriginalExtension();
            $fotoPath = $foto->storeAs('foto-dokter', $namaFile, 'public');
        } else {
            $fotoPath = $dokter->foto_dokter;
        }

        $dokter->update([
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'spesialisasi' => $request->spesialisasi,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'foto_dokter' => $fotoPath,
        ]);

        return redirect()->route('admin.dokter')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function deleteDokter($id)
    {
        $dokter = DokterDetail::with('user')->findOrFail($id);

        if ($dokter->foto_dokter && Storage::disk('public')->exists($dokter->foto_dokter)) {
            Storage::disk('public')->delete($dokter->foto_dokter);
        }

        $dokter->user->delete();
        $dokter->delete();

        return redirect()->route('admin.dokter')->with('success', 'Data dokter berhasil dihapus.');
    }
}
