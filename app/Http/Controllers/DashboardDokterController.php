<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RiwayatKonsultasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardDokterController extends Controller
{
    public function daftarKonsultasi()
    {
        $idDokter = Auth::user()->id;
        $chats = DB::table('chats')
            ->join('users', 'chats.user_id', '=', 'users.id')
            ->select('users.name', 'chats.*')
            ->where('chats.dokter_id', $idDokter)
            ->get();

        $statusActive = DB::table('users')
            ->select('is_active')
            ->where('id', $idDokter)
            ->first();

        return view('roleDokter.index', compact('chats', 'statusActive'));
    }

    public function bumbleChat($userid)
    {
        $dokterId = auth()->id();

        $chat = Chat::firstOrCreate(
            ['user_id' => $userid, 'dokter_id' => $dokterId]
        );

        $chat->messages()
            ->where('receiver_id', $dokterId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $messages = $chat->messages()->with('sender')->get();

        return view('roleDokter.chat', compact('chat', 'messages'));
    }

    public function getRiwayat()
    {
        $idDokter = Auth::user()->id;
        $riwayats = DB::table('riwayat_konsultasi')
            ->join('users', 'riwayat_konsultasi.user_id', '=', 'users.id')
            ->join('user_profiles', 'riwayat_konsultasi.user_id', '=', 'user_profiles.user_id')
            ->select('riwayat_konsultasi.*', 'users.name', 'user_profiles.jenis_kelamin')
            ->where('dokter_id', $idDokter)
            ->get();

        $users = User::where('role', 'user')->get();
        return view('roleDokter.riwayat', compact('riwayats', 'users'));
    }

    public function riwayatKonsul(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'diagnosa' => 'required|string',
            'obat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        RiwayatKonsultasi::create([
            'user_id' => $request->user_id,
            'diagnosa' => $request->diagnosa,
            'obat' => $request->obat,
            'keterangan' => $request->keterangan,
            'dokter_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Riwayat berhasil ditambahkan.');
    }

    public function udpateRiwayat(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'diagnosa' => 'required|string',
            'obat' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $riwayat = RiwayatKonsultasi::findOrFail($id);

        $riwayat->update([
            'user_id' => $request->user_id,
            'diagnosa' => $request->diagnosa,
            'obat' => $request->obat,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Riwayat berhasil diperbarui.');
    }

    public function deleteRiwayat($id)
    {
        $riwayat = RiwayatKonsultasi::findOrFail($id);
        $riwayat->delete();

        return redirect()->back()->with('success', 'Riwayat berhasil dihapus.');
    }

    public function toggleStatus(Request $request)
    {
        $status = $request->status === 'aktif' ? 1 : 0;

        User::where('id', $request->user_id)->update([
            'is_active' => $status
        ]);

        return redirect()->route('dokter.index');
    }
}
