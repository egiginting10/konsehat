<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtikelController extends Controller
{
    public function index()
    {
        $title = 'Konsehat - Artikel';

        $artikelTerbaru = DB::table('artikels')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $artikelPopuler = DB::table('artikels')
            ->orderBy('count_akses', 'desc')
            ->limit(5)
            ->get();

        return view('artikel.index', compact('title', 'artikelTerbaru', 'artikelPopuler'));
    }


    public function artikel($id)
    {
        $title = 'Konsehat - Artikel';

        $artikel = Artikel::findOrFail($id);
        $artikel->count_akses = ($artikel->count_akses ?? 0) + 1;
        $artikel->save();
        $artikelLainnya = Artikel::where('id', '!=', $id)->latest()->take(3)->get();

        return view('artikel.artikel', compact('title', 'artikel', 'artikelLainnya'));
    }
}
