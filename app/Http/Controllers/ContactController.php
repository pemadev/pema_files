<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:500'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Enquiry::create($validated);

        return redirect()->route('kontak')
            ->with('success', 'Pesan Anda telah terkirim.');
    }
}
