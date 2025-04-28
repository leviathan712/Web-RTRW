<?php
namespace App\Http\Controllers\API;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    // Mengambil semua berita
    public function index()
    {
        $beritas = Berita::all();
        return response()->json($beritas);
    }

    // Menambahkan berita baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi_berita' => 'required|string',
            'tempat_kejadian' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $berita = Berita::create([
            'judul_berita' => $request->judul_berita,
            'tanggal' => $request->tanggal,
            'isi_berita' => $request->isi_berita,
            'tempat_kejadian' => $request->tempat_kejadian,
        ]);

        return response()->json($berita, 201);
    }

    // Mengupdate berita
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul_berita' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'isi_berita' => 'required|string',
            'tempat_kejadian' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $berita->update([
            'judul_berita' => $request->judul_berita,
            'tanggal' => $request->tanggal,
            'isi_berita' => $request->isi_berita,
            'tempat_kejadian' => $request->tempat_kejadian,
        ]);

        return response()->json($berita);
    }

    // Menghapus berita
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return response()->json(['message' => 'Berita deleted successfully']);
    }
}
