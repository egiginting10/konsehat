<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\DokterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Konsehat - Dokter';

        $query = DB::table('dokter_profiles')
            ->select(DB::raw('spesialisasi'))
            ->whereNotNull('spesialisasi');

        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where('spesialisasi', 'like', '%' . $search . '%');
        }

        $spesialisasiDokter = $query->groupBy('spesialisasi')->pluck('spesialisasi');
        if ($spesialisasiDokter->isEmpty()) {
            return view('dokter.index', [
                'spesialisasiDokter' => $spesialisasiDokter,
                'title' => $title,
                'message' => 'Data Dokter Spesialis Tidak ditemukan.'
            ]);
        }

        return view('dokter.index', compact('title', 'spesialisasiDokter'));
    }

    public function listDokter(Request $request)
    {
        $title = 'Konsehat - List Dokter';
        $spesialisasi = $request->query('spesialisasi');
        $nama = $request->query('nama');

        $dokterList = DokterDetail::with(['user' => function ($query) {
            $query->orderByDesc('is_active');
        }])
            ->whereRaw('LOWER(spesialisasi) = ?', [strtolower($spesialisasi)])
            ->when($nama, function ($query, $nama) {
                $query->whereHas('user', function ($q) use ($nama) {
                    $q->where('name', 'like', '%' . $nama . '%');
                });
            })
            ->orderByRaw('(SELECT is_active FROM users WHERE users.id = dokter_profiles.user_id) DESC')
            ->get();

        if ($dokterList->isEmpty()) {
            return view('dokter.listDokter', [
                'dokterList' => $dokterList,
                'title' => $title,
                'message' => 'Data Dokter Tidak ditemukan.'
            ]);
        }

        return view('dokter.listDokter', compact('title', 'dokterList'));
    }

    public function chatDokter($dokterId)
    {
        $title = 'Konsehat - Chat Dokter';
        $userId = auth()->id();

        $chat = Chat::firstOrCreate(
            ['user_id' => $userId, 'dokter_id' => $dokterId]
        );

        $chat->messages()
            ->where('receiver_id', $userId)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        $messages = $chat->messages()->with('sender')->get();

        return view('dokter.chat', compact('title', 'chat', 'messages'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_id'        => 'required|exists:chats,id',
            'receiver_id'    => 'required|exists:users,id',
            'message'        => 'nullable|string',
            'preview_message' => 'nullable|string',
            'file'           => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx|max:5120',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('chat_files', 'public');
        }

        $messageText = $request->preview_message ?? $request->message;

        if (!$filePath && empty($messageText)) {
            return back()->with('error', 'Pesan atau file harus diisi.');
        }

        ChatMessage::create([
            'chat_id'     => $request->chat_id,
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $messageText,
            'attachment'   => $filePath,
            'sent_at'     => now(),
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
    }
}
