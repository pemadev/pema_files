<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobListing::query()
            ->when($request->search, fn($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(request()->query());

        return view('admin.karir.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.karir.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'department'       => ['nullable', 'string', 'max:255'],
            'location'         => ['nullable', 'string', 'max:255'],
            'type'             => ['required', 'string', 'in:fulltime,parttime,contract,internship'],
            'salary_range'     => ['nullable', 'string', 'max:100'],
            'requirements'     => ['nullable', 'string'],
            'google_form_link' => ['nullable', 'url', 'max:500'],
            'thumbnail'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active'        => ['nullable', 'boolean'],
            'deadline'         => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul lowongan wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'type.required' => 'Tipe pekerjaan wajib dipilih.',
            'type.in' => 'Tipe pekerjaan tidak valid.',
            'google_form_link.url' => 'Format URL Google Form tidak valid.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail harus JPEG, PNG, atau WebP.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'deadline.date' => 'Format tanggal deadline tidak valid.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('jobs', 'public');
        }

        JobListing::create($validated);

        return redirect()->route('admin.karir.index')
            ->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function edit(JobListing $job)
    {
        return view('admin.karir.form', compact('job'));
    }

    public function update(Request $request, JobListing $job)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'department'       => ['nullable', 'string', 'max:255'],
            'location'         => ['nullable', 'string', 'max:255'],
            'type'             => ['required', 'string', 'in:fulltime,parttime,contract,internship'],
            'salary_range'     => ['nullable', 'string', 'max:100'],
            'requirements'     => ['nullable', 'string'],
            'google_form_link' => ['nullable', 'url', 'max:500'],
            'thumbnail'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active'        => ['nullable', 'boolean'],
            'deadline'         => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul lowongan wajib diisi.',
            'title.string' => 'Judul harus berupa teks.',
            'title.max' => 'Judul maksimal 255 karakter.',
            'type.required' => 'Tipe pekerjaan wajib dipilih.',
            'type.in' => 'Tipe pekerjaan tidak valid.',
            'google_form_link.url' => 'Format URL Google Form tidak valid.',
            'thumbnail.image' => 'Thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Format thumbnail harus JPEG, PNG, atau WebP.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'deadline.date' => 'Format tanggal deadline tidak valid.',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('thumbnail')) {
            if ($job->thumbnail) {
                Storage::disk('public')->delete($job->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('jobs', 'public');
        }

        $job->update($validated);

        return redirect()->route('admin.karir.index')
            ->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(JobListing $job)
    {
        if ($job->thumbnail) {
            Storage::disk('public')->delete($job->thumbnail);
        }
        $job->delete();

        return redirect()->route('admin.karir.index')
            ->with('success', 'Lowongan berhasil dihapus.');
    }
}
