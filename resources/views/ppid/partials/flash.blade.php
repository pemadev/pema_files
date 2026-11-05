@if (session('success'))
    <div role="status" class="mb-6 rounded-xl border border-success-500 bg-success-50 p-4 text-sm text-success-700 dark:border-success-500/30 dark:bg-success-500/15 dark:text-success-500">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div role="alert" class="mb-6 rounded-xl border border-error-500 bg-error-50 p-4 text-sm text-error-700 dark:border-error-500/30 dark:bg-error-500/15 dark:text-error-500">
        <ul class="list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
