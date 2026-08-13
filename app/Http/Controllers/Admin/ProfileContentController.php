<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileContentController extends Controller
{
    public function index()
    {
        $profiles = ProfileContent::all()->groupBy('type');

        return view('admin.profil.index', compact('profiles'));
    }

    public function edit(string $type)
    {
        $profile = ProfileContent::firstOrNew(['type' => $type]);

        return view('admin.profil.edit', compact('profile', 'type'));
    }

    public function update(Request $request, $type)
    {
        $profile = ProfileContent::where('type', $type)->firstOrFail();

        $validated = $request->validate([
            'title'           => 'nullable|string|max:255',
            'content'         => 'nullable|string',
            'additional_info' => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_left'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'image_right'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageFields = ['image', 'image_left', 'image_right'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                if ($profile->$field) {
                    Storage::disk('public')->delete($profile->$field);
                }
                $validated[$field] = $request->file($field)->store('profil', 'public');
            } else {
                unset($validated[$field]);
            }
        }

        $profile->update($validated);

        return redirect()->route('admin.profil.index')->with('success', "$type berhasil diperbarui.");
    }
}