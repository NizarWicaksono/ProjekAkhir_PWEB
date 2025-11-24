<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // 1. Halaman List Artikel
    public function index()
    {
        $articles = Article::latest()->get();
        // PERUBAHAN: View ada di admin.artikel
        return view('admin.artikel', compact('articles'));
    }

    // 2. Halaman Form Tambah
    public function create()
    {
        // PERUBAHAN: View ada di admin.tambahartikel
        return view('admin.tambahartikel');
    }

    // 3. Proses Simpan
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_date' => 'required|date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'published_date' => $request->published_date,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // 4. Hapus Artikel
    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();
        return redirect()->back()->with('success', 'Artikel berhasil dihapus.');
    }
}
