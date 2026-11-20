{{-- Gaya isi konten dari editor Word (TinyMCE). Tailwind preflight mereset heading/list/tabel, jadi dikembalikan di sini. --}}
@once
    @push('styles')
        <style>
            .word-content { overflow-wrap: break-word; }
            .word-content > * + * { margin-top: 0.9em; }
            .word-content h1 { font-size: 1.875rem; font-weight: 700; line-height: 1.25; color: #111827; }
            .word-content h2 { font-size: 1.5rem; font-weight: 700; line-height: 1.3; color: #111827; }
            .word-content h3 { font-size: 1.25rem; font-weight: 600; line-height: 1.35; color: #111827; }
            .word-content h4 { font-size: 1.125rem; font-weight: 600; color: #111827; }
            .word-content ul { list-style: disc; padding-left: 1.75em; }
            .word-content ol { list-style: decimal; padding-left: 1.75em; }
            .word-content ul ul { list-style: circle; } .word-content ul ul ul { list-style: square; }
            .word-content ol[style*="list-style-type"], .word-content ul[style*="list-style-type"] { list-style-position: outside; }
            .word-content li + li { margin-top: 0.25em; }
            .word-content a { color: #0A6AC9; text-decoration: underline; }
            .word-content blockquote { border-left: 4px solid #d1d5db; padding: 0.25em 0 0.25em 1em; color: #4b5563; font-style: italic; }
            .word-content pre { background: #f3f4f6; padding: 0.75em 1em; border-radius: 0.5rem; overflow-x: auto; font-family: ui-monospace, monospace; font-size: 0.875em; }
            .word-content hr { border: 0; border-top: 1px solid #e5e7eb; margin: 1.5em 0; }
            .word-content img { max-width: 100%; height: auto; display: inline-block; }
            .word-content figure.image { display: table; margin: 1em auto; }
            .word-content figure.image figcaption { display: table-caption; caption-side: bottom; text-align: center; font-size: 0.85em; color: #6b7280; padding-top: 0.4em; }
            .word-content table { border-collapse: collapse; max-width: 100%; display: block; overflow-x: auto; }
            .word-content table td, .word-content table th { border: 1px solid #d1d5db; padding: 6px 10px; vertical-align: top; }
            .word-content table th { background: #f9fafb; font-weight: 600; }
            .word-content sub { vertical-align: sub; font-size: smaller; } .word-content sup { vertical-align: super; font-size: smaller; }
            .word-content iframe, .word-content video { max-width: 100%; }
            .word-content .mce-pagebreak { display: none; }
        </style>
    @endpush
@endonce
