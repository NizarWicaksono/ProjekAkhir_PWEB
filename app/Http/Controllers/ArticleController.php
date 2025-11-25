<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();
        return view('admin.artikel', compact('articles'));
    }

    public function create()
    {
        return view('admin.tambahartikel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'published_date' => 'required', // TIDAK PERLU VALIDASI LAGI
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,

            // SET OTOMATIS TANGGAL & WAKTU SEKARANG
            'published_date' => now(),

            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // 4. LIHAT DETAIL ARTIKEL
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.detailartikel', compact('article'));
    }

    // 6. PROSES UPDATE ARTIKEL
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('articles', 'public');
            $article->image = $imagePath;
        }

        // Update data lainnya
        $article->title = $request->title;
        $article->content = $request->content;
        $article->save(); // Simpan perubahan

        return redirect()->route('admin.articles.show', $article->id)->with('success', 'Artikel berhasil diperbarui!');}

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }

    // === METHOD BARU: TAMPILAN BACA UNTUK USER ===
    public function showPublic($id)
    {
        $article = Article::findOrFail($id);

        // Rekomendasi artikel lain (3 terbaru selain yang sedang dibaca)
        $otherArticles = Article::where('id', '!=', $id)->latest()->take(3)->get();

        return view('users.detailartikel', compact('article', 'otherArticles'));
    }
}
