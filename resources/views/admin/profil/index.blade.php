@extends('admin.layouts.master')

@section('title', 'Profil Perusahaan')
@section('page_title', 'Profil Perusahaan')

@section('content')
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-100">
                <th class="w-10 text-left py-3 px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Konten Profil</th>
                <th class="text-left px-5 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
                <th class="text-center px-5 py-4 font-semibold text-gray-600 text-xs uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @php
                $profileTypes = [
                    'sambutan'   => ['label' => 'Sambutan',     'icon' => 'fi fi-rs-hand-wave', 'desc' => 'Kata sambutan dari pimpinan perusahaan'],
                    'sejarah'    => ['label' => 'Sejarah',       'icon' => 'fi fi-rs-timeline',  'desc' => 'Riwayat dan perjalanan perusahaan'],
                    'visi_misi'  => ['label' => 'Visi & Misi',   'icon' => 'fi fi-rs-bullseye',  'desc' => 'Visi, misi, dan nilai-nilai perusahaan'],
                    'stakeholder' => ['label' => 'Stakeholder',   'icon' => 'fi fi-rs-users',     'desc' => 'Informasi pemangku kepentingan'],
                ];
            @endphp
            @foreach($profileTypes as $key => $typeInfo)
                @php
                    $content = $profiles->get($key)?->first();
                    $hasContent = !is_null($content) && $content->title;
                @endphp
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="py-3 px-3 text-gray-400 text-xs">{{ $loop->iteration }}</td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-pema-50 flex items-center justify-center flex-shrink-0">
                                <i class="{{ $typeInfo['icon'] }} text-pema-500 text-sm"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">{{ $typeInfo['label'] }}</p>
                                <p class="text-xs text-gray-400">{{ $typeInfo['desc'] }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @if($hasContent)
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded-lg">
                                <i class="fi fi-rs-check-circle text-xs"></i>
                                Terisi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">
                                <i class="fi fi-rs-circle text-xs"></i>
                                Kosong
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center">
                        <a href="{{ route('admin.profil.edit', $key) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-amber-600 bg-amber-50 hover:bg-amber-100 rounded-lg transition-all text-xs font-medium">
                            <i class="fi fi-rs-edit"></i>
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
