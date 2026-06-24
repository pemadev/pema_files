<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $enquiries = Enquiry::query()
            ->when($request->search, fn($q, $v) => $q->where('name', 'like', "%{$v}%")->orWhere('email', 'like', "%{$v}%")->orWhere('subject', 'like', "%{$v}%"))
            ->when($request->filter !== null, fn($q) => $q->where('is_read', $request->filter === 'read' ? 1 : 0))
            ->latest()
            ->paginate(15)
            ->appends(request()->query());

        $unread_count = Enquiry::where('is_read', false)->count();

        return view('admin.enquiry.index', compact('enquiries', 'unread_count'));
    }

    public function show(Enquiry $enquiry)
    {
        return view('admin.enquiry.show', compact('enquiry'));
    }

    public function markAsRead(Enquiry $enquiry)
    {
        $enquiry->update(['is_read' => true]);
        
        return redirect()->route('admin.enquiry.index')
            ->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    public function markAsUnread(Enquiry $enquiry)
    {
        $enquiry->update(['is_read' => false]);
        
        return redirect()->route('admin.enquiry.index')
            ->with('success', 'Pesan ditandai sebagai belum dibaca.');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        
        return redirect()->route('admin.enquiry.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    public function destroyAll(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return back()->with('error', 'Pilih minimal satu pesan.');
        }

        Enquiry::whereIn('id', $ids)->delete();
        
        return redirect()->route('admin.enquiry.index')
            ->with('success', 'Pesan terpilih berhasil dihapus.');
    }
}
