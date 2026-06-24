<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $keys = [
            'alamat', 'email', 'telepon', 'fax',
            'instagram', 'facebook', 'twitter', 'youtube',
            'karir_link', 'produk_link', 'visi', 'misi',
            'latitude', 'longitude',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::getValue($key) ?: '';
        }

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alamat'     => ['nullable', 'string', 'max:1000'],
            'email'      => ['nullable', 'email', 'max:255'],
            'telepon'    => ['nullable', 'string', 'max:50'],
            'fax'        => ['nullable', 'string', 'max:50'],
            'instagram'  => ['nullable', 'string', 'max:255'],
            'facebook'   => ['nullable', 'string', 'max:255'],
            'twitter'    => ['nullable', 'string', 'max:255'],
            'youtube'    => ['nullable', 'string', 'max:255'],
            'karir_link' => ['nullable', 'url', 'max:500'],
            'produk_link' => ['nullable', 'url', 'max:500'],
            'visi'       => ['nullable', 'string', 'max:5000'],
            'misi'       => ['nullable', 'string', 'max:5000'],
            'latitude'   => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'  => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? ''],
            );
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
