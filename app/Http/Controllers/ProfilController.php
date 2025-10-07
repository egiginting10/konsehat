<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $title = 'Konsehat - Profil';

        $idUser = Auth::user()->id;
        $user = User::with('userDetail')->where('id', $idUser)->first();

        return view('profil.index', compact('title', 'user'));
    }

    public function updateProfilUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $userDetail = $user->userDetail ?? new UserDetail();
        $userDetail->user_id = $user->id;
        $userDetail->alamat = $request->alamat;
        $userDetail->berat_badan = $request->berat_badan;
        $userDetail->tinggi_badan = $request->tinggi_badan;
        $userDetail->tanggal_lahir = $request->tanggal_lahir;
        $userDetail->jenis_kelamin = $request->jenis_kelamin;

        if ($request->hasFile('foto_user')) {
            if ($userDetail->foto_user && Storage::exists('public/img/foto/' . $userDetail->foto_user)) {
                Storage::delete('public/img/foto/' . $userDetail->foto_user);
            }

            $fileName = time() . '_' . $request->file('foto_user')->getClientOriginalName();
            $request->file('foto_user')->storeAs('public/img/foto', $fileName);
            $userDetail->foto_user = $fileName;
        }

        $userDetail->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
