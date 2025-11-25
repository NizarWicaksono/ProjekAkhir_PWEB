<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Cloudinary\Api\Upload\UploadApi;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(6);
        return view('admin.artikel', compact('articles'));
    }

    public function create()
    {
        return view('admin.tambahartikel');
    }

    public function store(Request $request)
    {
         $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image|max:5048',
        ]);

        $folderPath = 'artikel_f1';
        $file = $request->file('image')->getClientOriginalName();
        $file_name = pathinfo($file, PATHINFO_FILENAME);
        $public_id = date('y-m-d_His') . '_' . $file_name;
        $upload  =  (new  UploadApi())->upload(  $request->file('image')->getRealPath(),
        [
            'public_id'  =>  $public_id,
            'folder'  =>  $folderPath
        ]);
        $secureUrl  =  $upload['secure_url'];

        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $secureUrl,
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $dataToUpdate = [
            'title' => $request->title,
            'content' => $request->content,
        ];
        $secureUrl = $article->image;

        if ($request->hasFile('image')) {
            $folderPath = 'artkel_f1';
            $file = $request->file('image')->getClientOriginalName();
            $file_name = pathinfo($file, PATHINFO_FILENAME);
            $public_id = date('y-m-d_His') . '_' . $file_name;
            $upload  =  (new  UploadApi())->upload(  $request->file('image')->getRealPath(),
            [
                'public_id'  =>  $public_id,
                'folder'  =>  $folderPath
            ]);
            $secureUrl  =  $upload['secure_url'];
            $dataToUpdate['image'] = $secureUrl;
        }

        $article->update($dataToUpdate);
        return redirect()->route('admin.articles.show', $article->id)->with('success', 'Artikel berhasil diperbarui!');
    }
    // 7. PROSES HAPUS ARTIKEL
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
