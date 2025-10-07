<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatKonsultasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Konsehat - Riwayat';
        $idUser = Auth::user()->id;

        $totalRiwayat = DB::table('riwayat_konsultasi')
            ->where('user_id', $idUser)
            ->count();

        if ($totalRiwayat === 0) {
            return view('riwayat.index', compact('title'));
        }

        $query = DB::table('riwayat_konsultasi')
            ->join('users', 'riwayat_konsultasi.dokter_id', '=', 'users.id')
            ->join('dokter_profiles', 'riwayat_konsultasi.dokter_id', '=', 'dokter_profiles.user_id')
            ->select(
                'riwayat_konsultasi.*',
                'users.name as nama_dokter',
                'dokter_profiles.foto_dokter'
            )
            ->where('riwayat_konsultasi.user_id', $idUser);

        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('diagnosa', 'like', "%{$search}%")
                    ->orWhere('obat', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhere('users.name', 'like', "%{$search}%");
            });
        }

        $riwayats = $query->get();

        if ($riwayats->isEmpty()) {
            return view('riwayat.user', [
                'riwayats' => $riwayats,
                'title' => $title,
                'message' => 'Data tidak ditemukan untuk pencarian tersebut.'
            ]);
        }

        return view('riwayat.user', compact('riwayats', 'title'));
    }


    public function riwayatUser()
    {
        return view('riwayat.user');
    }
}
