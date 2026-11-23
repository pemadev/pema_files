{{--
    Editor teks lengkap ala Microsoft Word (TinyMCE 7, lisensi GPL, dimuat dari CDN).
    Pemakaian:
        @include('admin.partials.word-editor', [
            'name'        => 'content',
            'value'       => old('content', $news->content ?? ''),
            'height'      => 520,                              // opsional
            'uploadUrl'   => route('admin.berita.upload-image'), // opsional, untuk upload gambar
            'placeholder' => 'Masukkan konten...',
        ])
    Event 'word-editor-change' (detail: { name, html }) dikirim setiap isi berubah, untuk preview Alpine.
--}}
@php
    $editorId = 'word-editor-' . $name;
@endphp

<textarea id="{{ $editorId }}" name="{{ $name }}" class="word-editor"
          data-upload-url="{{ $uploadUrl ?? '' }}"
          data-height="{{ $height ?? 520 }}"
          data-placeholder="{{ $placeholder ?? '' }}"
          style="visibility:hidden; min-height:{{ $height ?? 520 }}px; width:100%;">{{ $value ?? '' }}</textarea>

@once
    @push('styles')
        <style>
            /* ── Tampilan modern editor (TinyMCE) ── */
            .tox.tox-tinymce { border: 1px solid #e5e7eb !important; border-radius: 16px !important; box-shadow: 0 1px 2px rgba(16,24,40,.04); transition: border-color .15s, box-shadow .15s; font-family: inherit; }
            .tox.tox-tinymce:focus-within { border-color: #0A6AC9 !important; box-shadow: 0 0 0 4px rgba(10,106,201,.10); }
            .tox .tox-promotion, .tox .tox-statusbar__branding { display: none !important; }

            /* Header: menu + toolbar dengan latar lembut */
            .tox:not(.tox-tinymce-inline) .tox-editor-header { background: #eaf2fb !important; border-bottom: 1px solid #d6e4f5 !important; box-shadow: none !important; padding: 0 !important; }
            .tox .tox-menubar, .tox .tox-toolbar, .tox .tox-toolbar__primary, .tox .tox-toolbar__overflow, .tox .tox-toolbar-overlord { background: transparent !important; background-image: none !important; }
            .tox .tox-menubar { background: linear-gradient(90deg, #0A6AC9 0%, #0b5cad 100%) !important; padding: 5px 8px !important; gap: 2px; }
            .tox .tox-toolbar-overlord { padding: 4px 8px 6px !important; }
            .tox .tox-mbtn { height: 30px !important; padding: 0 12px !important; border-radius: 8px !important; background: transparent !important; color: rgba(255,255,255,.88) !important; font-size: 13px !important; font-weight: 500; }
            .tox .tox-mbtn .tox-mbtn__select-label { color: inherit !important; }
            .tox .tox-mbtn:hover:not(:disabled), .tox .tox-mbtn--active, .tox .tox-mbtn:focus:not(:disabled) { background: rgba(255,255,255,.18) !important; color: #fff !important; box-shadow: none !important; }

            /* Kelompok tombol berbentuk "pil" */
            .tox .tox-toolbar__group { background: #fff; border: 1px solid #d6e4f5 !important; border-radius: 12px; padding: 2px 3px !important; margin: 3px 4px 3px 0 !important; box-shadow: 0 1px 1px rgba(16,24,40,.03); }
            .tox .tox-toolbar__group:not(:last-of-type) { border-right: 1px solid #d6e4f5 !important; }
            .tox .tox-toolbar__overflow { background: #f3f8fd !important; border-top: 1px dashed #c9dbf1 !important; margin: 4px -8px -6px !important; padding: 4px 8px 6px !important; }

            /* Tombol */
            .tox .tox-tbtn { height: 32px !important; min-width: 32px; margin: 1px !important; border-radius: 8px !important; color: #334155 !important; transition: background-color .12s, color .12s; }
            .tox .tox-tbtn svg { fill: #475569 !important; }
            .tox .tox-tbtn:hover:not(.tox-tbtn--disabled), .tox .tox-split-button:hover { background: #f1f5f9 !important; color: #0f172a !important; box-shadow: none !important; }
            .tox .tox-tbtn--enabled, .tox .tox-tbtn--enabled:hover { background: #e0edfb !important; color: #0A6AC9 !important; }
            .tox .tox-tbtn--enabled svg, .tox .tox-tbtn--enabled:hover svg { fill: #0A6AC9 !important; }
            .tox .tox-tbtn--disabled svg, .tox .tox-tbtn:disabled svg { fill: #cbd5e1 !important; }
            .tox .tox-split-button { border-radius: 8px !important; margin: 1px !important; }
            .tox .tox-split-button .tox-tbtn { margin: 0 !important; }
            .tox .tox-split-button__chevron { width: 16px !important; }

            /* Dropdown gaya, huruf, ukuran */
            .tox .tox-tbtn--select, .tox .tox-tbtn--bespoke { background: #f1f6fc !important; padding: 0 6px 0 10px !important; font-size: 13px !important; }
            .tox .tox-tbtn--bespoke .tox-tbtn__select-label { width: 6.5em !important; }
            .tox .tox-tbtn--select:hover, .tox .tox-tbtn--bespoke:hover { background: #eef2f7 !important; }

            /* Menu yang muncul (dropdown) */
            .tox .tox-menu { border: 1px solid #e5e7eb !important; border-radius: 12px !important; box-shadow: 0 12px 32px -8px rgba(15,23,42,.18) !important; padding: 4px !important; }
            .tox .tox-collection--list .tox-collection__item { border-radius: 8px; }
            .tox .tox-collection--list .tox-collection__item--active { background: #eef4fc !important; color: #0A6AC9 !important; }
            /* ── Jendela dialog (gambar, tautan, tabel, dll.) ── */
            .tox .tox-dialog-wrap__backdrop { background: rgba(15,23,42,.45) !important; backdrop-filter: blur(4px); }
            .tox .tox-dialog { border-radius: 20px !important; border: 0 !important; box-shadow: 0 32px 64px -16px rgba(15,23,42,.35) !important; max-width: 680px !important; overflow: hidden; font-family: inherit; }
            .tox .tox-dialog__header { padding: 20px 24px 16px !important; border-bottom: 1px solid #f1f5f9 !important; background: #fff !important; }
            .tox .tox-dialog__title { font-size: 18px !important; font-weight: 600 !important; color: #0f172a !important; letter-spacing: -.01em; }
            .tox .tox-dialog__header .tox-button--naked { width: 36px; height: 36px; border-radius: 10px !important; color: #64748b !important; }
            .tox .tox-dialog__header .tox-button--naked:hover { background: #f1f5f9 !important; color: #0f172a !important; }
            .tox .tox-dialog__header .tox-button--naked svg { fill: currentColor !important; }

            /* Tab di samping: gaya menu pil */
            .tox .tox-dialog__body { padding-top: 4px; }
            .tox .tox-dialog__body-nav { padding: 18px 12px 18px 16px !important; gap: 4px; min-width: 150px; border-right: 1px solid #f1f5f9; background: #fafbfc; }
            .tox .tox-dialog__body-nav-item { display: flex !important; align-items: center; gap: 8px; padding: 9px 14px !important; margin: 0 !important; border: 0 !important; border-radius: 10px !important; color: #64748b !important; font-size: 14px !important; font-weight: 500; transition: background-color .12s, color .12s; }
            .tox .tox-dialog__body-nav-item:hover { background: #f1f5f9 !important; color: #0f172a !important; }
            .tox .tox-dialog__body-nav-item--active, .tox .tox-dialog__body-nav-item--active:hover { background: #e0edfb !important; color: #0A6AC9 !important; font-weight: 600; }
            .tox .tox-dialog__body-nav-item:focus { box-shadow: 0 0 0 3px rgba(10,106,201,.15) !important; }
            .tox .tox-dialog__body-content { padding: 18px 24px 8px !important; }

            /* Kolom isian */
            .tox .tox-form__group { margin-bottom: 14px !important; }
            .tox .tox-label, .tox .tox-toolbar-label { font-size: 13px !important; font-weight: 500 !important; color: #334155 !important; padding-bottom: 6px !important; }
            .tox .tox-textfield, .tox .tox-textarea, .tox .tox-selectfield select, .tox .tox-listbox--select, .tox .tox-custom-editor { border: 1px solid #e2e8f0 !important; border-radius: 10px !important; background: #f8fafc !important; padding: 9px 12px !important; min-height: 40px; font-size: 14px !important; color: #0f172a !important; transition: border-color .12s, box-shadow .12s, background-color .12s; }
            .tox .tox-textfield:hover, .tox .tox-listbox--select:hover { border-color: #cbd5e1 !important; }
            .tox .tox-textfield:focus, .tox .tox-textarea:focus, .tox .tox-selectfield select:focus, .tox .tox-listbox--select:focus { border-color: #0A6AC9 !important; background: #fff !important; box-shadow: 0 0 0 4px rgba(10,106,201,.12) !important; outline: none !important; }
            .tox .tox-control-wrap .tox-textfield { padding-right: 36px !important; }
            .tox .tox-form__controls-h-stack { gap: 10px; align-items: flex-end; }
            .tox .tox-form__controls-h-stack > * { margin-left: 0 !important; }
            .tox .tox-lock.tox-button { width: 40px; height: 40px; border-radius: 10px !important; background: #f1f5f9 !important; border: 1px solid #e2e8f0 !important; }
            .tox .tox-lock.tox-button--enabled, .tox .tox-lock.tox-locked { background: #e0edfb !important; border-color: #bcd6f5 !important; }
            .tox .tox-lock svg { fill: #475569 !important; }
            .tox .tox-lock.tox-locked svg { fill: #0A6AC9 !important; }
            .tox .tox-browse-url { border-radius: 0 10px 10px 0 !important; }

            /* Kotak centang */
            .tox .tox-checkbox { gap: 2px; border-radius: 10px; padding: 4px 6px !important; }
            .tox .tox-checkbox:hover { background: #f8fafc; }
            .tox .tox-checkbox__label { font-size: 14px !important; color: #334155 !important; }
            .tox .tox-checkbox-icon__unchecked svg { fill: #cbd5e1 !important; }
            .tox .tox-checkbox-icon__checked svg { fill: #0A6AC9 !important; }

            /* Area unggah (tab Unggah) */
            .tox .tox-dropzone-container { padding: 4px 0 8px; }
            .tox .tox-dropzone { min-height: 200px !important; border: 2px dashed #cbd5e1 !important; border-radius: 16px !important; background: #f8fafc !important; gap: 10px; transition: border-color .15s, background-color .15s; }
            .tox .tox-dropzone:hover, .tox .tox-dropzone--active { border-color: #0A6AC9 !important; background: #f0f6fd !important; }
            .tox .tox-dropzone p { color: #64748b !important; font-size: 14px !important; }
            .tox .tox-dropzone .tox-button { margin-top: 4px; }

            /* Bagian bawah & tombol */
            .tox .tox-dialog__footer { padding: 14px 24px !important; border-top: 1px solid #f1f5f9 !important; background: #fafbfc !important; }
            .tox .tox-dialog__footer-end { gap: 8px; }
            .tox .tox-dialog__footer .tox-button { margin-left: 0 !important; }
            .tox .tox-button { min-height: 40px; padding: 8px 20px !important; border-radius: 10px !important; font-size: 14px !important; font-weight: 600 !important; transition: background-color .12s, box-shadow .12s, transform .05s; }
            .tox .tox-button:active { transform: translateY(1px); }
            .tox .tox-button:not(.tox-button--secondary):not(.tox-button--naked) { background: #0A6AC9 !important; border-color: #0A6AC9 !important; color: #fff !important; box-shadow: 0 1px 2px rgba(10,106,201,.25); }
            .tox .tox-button:not(.tox-button--secondary):not(.tox-button--naked):hover { background: #0858a8 !important; border-color: #0858a8 !important; box-shadow: 0 4px 12px -2px rgba(10,106,201,.35); }
            .tox .tox-button--secondary { background: #fff !important; border: 1px solid #e2e8f0 !important; color: #334155 !important; }
            .tox .tox-button--secondary:hover { background: #f8fafc !important; border-color: #cbd5e1 !important; }
            .tox .tox-dialog__header .tox-button--naked, .tox .tox-lock.tox-button { min-height: 0; padding: 0 !important; }

            @media (max-width: 640px) {
                .tox .tox-dialog__body-nav { min-width: 0; flex-direction: row !important; border-right: 0; border-bottom: 1px solid #f1f5f9; padding: 10px 12px !important; overflow-x: auto; }
            }

            /* Bilah status bawah */
            .tox .tox-statusbar { border-top: 1px solid #f1f5f9 !important; background: #fcfcfd !important; color: #94a3b8 !important; font-size: 12px !important; padding: 0 12px !important; height: 28px !important; }
            .tox .tox-statusbar a, .tox .tox-statusbar__wordcount { color: #94a3b8 !important; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tinymce@7.6.0/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            // Pastikan isi editor tersalin ke textarea sebelum form dikirim (termasuk form yang submit lewat JS)
            document.addEventListener('submit', function () { if (window.tinymce) tinymce.triggerSave(); }, true);

            document.querySelectorAll('textarea.word-editor').forEach(function (textarea) {
                const uploadUrl = textarea.dataset.uploadUrl;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

                tinymce.init({
                    target: textarea,
                    license_key: 'gpl',
                    language: 'id',
                    language_url: 'https://cdn.jsdelivr.net/npm/tinymce-i18n@25.6.2/langs7/id.js',
                    placeholder: textarea.dataset.placeholder,
                    height: parseInt(textarea.dataset.height, 10) || 520,
                    min_height: 240,
                    resize: true,
                    branding: false,
                    promotion: false,
                    browser_spellcheck: true,
                    contextmenu: 'link image table',

                    // Menu & toolbar seperti Word
                    menubar: 'file edit view insert format table tools help',
                    plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks visualchars code fullscreen insertdatetime media table help wordcount pagebreak nonbreaking emoticons directionality quickbars',
                    // Satu baris yang ringkas; tombol yang tidak muat masuk ke tombol "⋯" (lainnya)
                    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline forecolor backcolor | align lineheight | bullist numlist outdent indent | link image table media | strikethrough subscript superscript removeformat blockquote | hr pagebreak charmap emoticons insertdatetime | searchreplace visualblocks preview code fullscreen',
                    toolbar_mode: 'sliding',
                    toolbar_sticky: true,
                    toolbar_sticky_offset: 64, // tinggi header admin yang menempel di atas
                    quickbars_selection_toolbar: 'bold italic underline | forecolor backcolor | quicklink blockquote',
                    quickbars_insert_toolbar: false,

                    font_family_formats: 'Inter=inter,system-ui,sans-serif; Arial=arial,helvetica,sans-serif; Calibri=calibri,sans-serif; Cambria=cambria,serif; Georgia=georgia,serif; Tahoma=tahoma,sans-serif; Times New Roman=times new roman,times,serif; Verdana=verdana,sans-serif; Courier New=courier new,courier,monospace',
                    font_size_formats: '8pt 9pt 10pt 11pt 12pt 14pt 16pt 18pt 20pt 24pt 28pt 36pt 48pt 72pt',
                    line_height_formats: '1 1.15 1.5 2 2.5 3',
                    block_formats: 'Paragraf=p; Judul 1=h1; Judul 2=h2; Judul 3=h3; Judul 4=h4; Kutipan=blockquote; Kode=pre',

                    table_default_attributes: { border: '1' },
                    table_default_styles: { 'border-collapse': 'collapse', width: '100%' },
                    image_caption: true,
                    image_advtab: true,
                    link_default_target: '_blank',
                    link_assume_external_targets: true,

                    // Simpan URL gambar apa adanya (absolut), jangan diubah jadi relatif
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: false,

                    // Tempel dari Word: pertahankan format, buang gaya bawaan Office yang tidak perlu
                    paste_data_images: !!uploadUrl,
                    paste_webkit_styles: 'color font-size font-weight font-style text-decoration text-align background-color',

                    content_style: "body { font-family: inter, system-ui, sans-serif; font-size: 12pt; line-height: 1.7; color: #374151; margin: 1.25rem 1.5rem; } body::before { color: #94a3b8 !important; } img { max-width: 100%; height: auto; border-radius: 6px; } table td, table th { padding: 6px 8px; border-color: #d1d5db; } blockquote { border-left: 4px solid #cbd5e1; margin-left: 0; padding-left: 1em; color: #4b5563; } a { color: #0A6AC9; }",

                    automatic_uploads: !!uploadUrl,
                    images_file_types: 'jpeg,jpg,png,gif,webp',
                    images_upload_handler: uploadUrl ? function (blobInfo, progress) {
                        const data = new FormData();
                        data.append('image', blobInfo.blob(), blobInfo.filename());

                        return fetch(uploadUrl, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                            body: data,
                        }).then(function (res) {
                            if (res.status === 422) throw { message: 'Gambar tidak valid. Format JPG/PNG/GIF/WebP, maks. 2MB.', remove: true };
                            if (!res.ok) throw { message: 'Gagal mengunggah gambar (HTTP ' + res.status + ').', remove: true };
                            return res.json();
                        }).then(function (json) {
                            return json.url;
                        });
                    } : undefined,

                    setup: function (editor) {
                        const notify = function () {
                            editor.save();
                            textarea.dispatchEvent(new CustomEvent('word-editor-change', {
                                bubbles: true,
                                detail: { name: textarea.name, html: editor.getContent() },
                            }));
                        };
                        editor.on('init change input undo redo SetContent', notify);
                    },
                });
            });
        </script>
    @endpush
@endonce
