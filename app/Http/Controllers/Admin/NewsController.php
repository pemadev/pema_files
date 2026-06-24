<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    // ==================== BERITA ====================

    public function index(Request $request)
    {
        $newsList = News::type('berita')
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->filter !== null, fn($q) => $q->where('is_published', $request->filter === 'published'))
            ->latest()
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.berita.index', compact('newsList'));
    }

    public function create()
    {
        return view('admin.berita.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'date'        => ['required', 'date'],
            'author'      => ['required', 'string', 'max:255'],
            'is_published'=> ['nullable', 'boolean'],
        ], [
            'title.required'       => 'Judul wajib diisi.',
            'title.string'         => 'Judul harus berupa teks.',
            'title.max'            => 'Judul maksimal :max karakter.',
            'content.required'     => 'Konten wajib diisi.',
            'content.string'       => 'Konten harus berupa teks.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'image.max'            => 'Ukuran gambar maksimal :max KB.',
            'date.required'        => 'Tanggal wajib diisi.',
            'date.date'            => 'Format tanggal tidak valid.',
            'author.required'      => 'Penulis wajib diisi.',
            'author.string'        => 'Penulis harus berupa teks.',
            'author.max'           => 'Penulis maksimal :max karakter.',
            'is_published.boolean' => 'Status publikasi tidak valid.',
        ]);

        $validated['type'] = 'berita';
        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.berita.form', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'date'        => ['required', 'date'],
            'author'      => ['required', 'string', 'max:255'],
            'is_published'=> ['nullable', 'boolean'],
        ], [
            'title.required'       => 'Judul wajib diisi.',
            'title.string'         => 'Judul harus berupa teks.',
            'title.max'            => 'Judul maksimal :max karakter.',
            'content.required'     => 'Konten wajib diisi.',
            'content.string'       => 'Konten harus berupa teks.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'image.max'            => 'Ukuran gambar maksimal :max KB.',
            'date.required'        => 'Tanggal wajib diisi.',
            'date.date'            => 'Format tanggal tidak valid.',
            'author.required'      => 'Penulis wajib diisi.',
            'author.string'        => 'Penulis harus berupa teks.',
            'author.max'           => 'Penulis maksimal :max karakter.',
            'is_published.boolean' => 'Status publikasi tidak valid.',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        if ($request->boolean('remove_image') && $news->image) {
            Storage::disk('public')->delete($news->image);
            $validated['image'] = null;
        }

        $news->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    // ==================== PENGUMUMAN ====================

    public function indexPengumuman(Request $request)
    {
        $newsList = News::type('pengumuman')
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->filter !== null, fn($q) => $q->where('is_published', $request->filter === 'published'))
            ->latest()
            ->paginate(10)
            ->appends(request()->query());

        return view('admin.pengumuman.index', compact('newsList'));
    }

    public function createPengumuman()
    {
        return view('admin.pengumuman.form');
    }

    public function storePengumuman(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'document'    => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:10240'],
            'date'        => ['required', 'date'],
            'author'      => ['required', 'string', 'max:255'],
            'is_published'=> ['nullable', 'boolean'],
        ], [
            'title.required'       => 'Judul wajib diisi.',
            'title.string'         => 'Judul harus berupa teks.',
            'title.max'            => 'Judul maksimal :max karakter.',
            'content.required'     => 'Konten wajib diisi.',
            'content.string'       => 'Konten harus berupa teks.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'image.max'            => 'Ukuran gambar maksimal :max KB.',
            'document.file'        => 'File harus berupa dokumen.',
            'document.mimes'       => 'Format dokumen harus pdf, doc, docx, xls, xlsx, ppt, atau pptx.',
            'document.max'         => 'Ukuran dokumen maksimal 10MB.',
            'date.required'        => 'Tanggal wajib diisi.',
            'date.date'            => 'Format tanggal tidak valid.',
            'author.required'      => 'Penulis wajib diisi.',
            'author.string'        => 'Penulis harus berupa teks.',
            'author.max'           => 'Penulis maksimal :max karakter.',
            'is_published.boolean' => 'Status publikasi tidak valid.',
        ]);

        $validated['type'] = 'pengumuman';
        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        if ($request->hasFile('document')) {
            $validated['document_name'] = $request->file('document')->getClientOriginalName();
            $validated['document_path'] = $request->file('document')->store('documents', 'public');
        }

        News::create($validated);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function editPengumuman(News $news)
    {
        return view('admin.pengumuman.form', compact('news'));
    }

    public function updatePengumuman(Request $request, News $news)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'document'    => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx', 'max:10240'],
            'date'        => ['required', 'date'],
            'author'      => ['required', 'string', 'max:255'],
            'is_published'=> ['nullable', 'boolean'],
        ], [
            'title.required'       => 'Judul wajib diisi.',
            'title.string'         => 'Judul harus berupa teks.',
            'title.max'            => 'Judul maksimal :max karakter.',
            'content.required'     => 'Konten wajib diisi.',
            'content.string'       => 'Konten harus berupa teks.',
            'image.image'          => 'File harus berupa gambar.',
            'image.mimes'          => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'image.max'            => 'Ukuran gambar maksimal :max KB.',
            'document.file'        => 'File harus berupa dokumen.',
            'document.mimes'       => 'Format dokumen harus pdf, doc, docx, xls, xlsx, ppt, atau pptx.',
            'document.max'         => 'Ukuran dokumen maksimal 10MB.',
            'date.required'        => 'Tanggal wajib diisi.',
            'date.date'            => 'Format tanggal tidak valid.',
            'author.required'      => 'Penulis wajib diisi.',
            'author.string'        => 'Penulis harus berupa teks.',
            'author.max'           => 'Penulis maksimal :max karakter.',
            'is_published.boolean' => 'Status publikasi tidak valid.',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        if ($request->boolean('remove_image') && $news->image) {
            Storage::disk('public')->delete($news->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('document')) {
            if ($news->document_path) {
                Storage::disk('public')->delete($news->document_path);
            }
            $validated['document_name'] = $request->file('document')->getClientOriginalName();
            $validated['document_path'] = $request->file('document')->store('documents', 'public');
        }

        $news->update($validated);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroyPengumuman(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        if ($news->document_path) {
            Storage::disk('public')->delete($news->document_path);
        }

        $news->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
