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
            .tox-tinymce { border-radius: 0.75rem !important; border-color: oklch(0.928 0.006 264.531) !important; }
            .tox-tinymce:focus-within { border-color: #0A6AC9 !important; box-shadow: 0 0 0 3px rgba(10,106,201,0.1); }
            .tox .tox-promotion, .tox .tox-statusbar__branding { display: none !important; }
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
                    toolbar: [
                        'undo redo | blocks fontfamily fontsize lineheight | bold italic underline strikethrough subscript superscript | forecolor backcolor removeformat',
                        'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent blockquote | link image media table | hr pagebreak charmap emoticons insertdatetime | searchreplace visualblocks preview fullscreen code',
                    ],
                    toolbar_mode: 'wrap',
                    toolbar_sticky: true,
                    quickbars_selection_toolbar: 'bold italic underline | forecolor backcolor | quicklink blockquote',
                    quickbars_insert_toolbar: false,

                    font_family_formats: 'Default=inherit; Arial=arial,helvetica,sans-serif; Calibri=calibri,sans-serif; Cambria=cambria,serif; Georgia=georgia,serif; Tahoma=tahoma,sans-serif; Times New Roman=times new roman,times,serif; Verdana=verdana,sans-serif; Courier New=courier new,courier,monospace',
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

                    content_style: "body { font-family: 'Inter', system-ui, sans-serif; font-size: 15px; line-height: 1.7; color: #374151; margin: 1rem 1.25rem; } img { max-width: 100%; height: auto; } table td, table th { padding: 6px 8px; }",

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
