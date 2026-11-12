<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Mengambil daftar akun pengguna PPID dari API eksternal.
 *
 * Format respons yang diharapkan:
 * { status: true, data: { meta: { total_records, total_pages, ... }, data: [ {id, name, email, telepon, created_at, active, kategori_pemohon}, ... ] } }
 */
class PpidUserApi
{
    /** Batas halaman yang diambil, supaya dashboard tidak macet bila API bermasalah. */
    private const MAX_PAGES = 50;

    public function isConfigured(): bool
    {
        return filled(config('services.ppid_api.users_url'));
    }

    /**
     * Ringkasan akun untuk dashboard. Hasil di-cache agar API tidak dipanggil tiap kali dashboard dibuka.
     *
     * @return array{configured: bool, error: ?string, total: int, aktif: int, bulanIni: int, terbaru: array, fetchedAt: ?Carbon}
     */
    public function summary(int $latest = 10): array
    {
        $empty = ['configured' => $this->isConfigured(), 'error' => null, 'total' => 0, 'aktif' => 0, 'bulanIni' => 0, 'terbaru' => [], 'fetchedAt' => null];

        if (! $this->isConfigured()) {
            return $empty;
        }

        try {
            $users = Cache::remember('ppid_api_users', (int) config('services.ppid_api.cache_ttl', 600), fn () => $this->fetchAll());
        } catch (Throwable $e) {
            Log::warning('Gagal mengambil data user PPID dari API: ' . $e->getMessage());

            $status = $e instanceof \Illuminate\Http\Client\RequestException ? $e->response->status() : null;
            $error = match (true) {
                in_array($status, [401, 403], true) => 'API menolak akses (HTTP ' . $status . '). Periksa PPID_API_TOKEN di file .env.',
                $e instanceof \Illuminate\Http\Client\ConnectionException => 'Server API tidak dapat dihubungi.',
                default => 'Data akun pengguna tidak dapat diambil dari API.',
            };

            return array_merge($empty, ['error' => $error]);
        }

        $rows = collect($users['data'])->map(fn ($u) => [
            'id'       => $u['id'] ?? null,
            'name'     => $u['name'] ?? '-',
            'email'    => $u['email'] ?? '-',
            'telepon'  => $u['telepon'] ?? null,
            'active'   => (bool) ($u['active'] ?? false),
            'kategori' => $u['kategori_pemohon'] ?? null,
            'created'  => ! empty($u['created_at']) ? Carbon::parse($u['created_at'])->timezone(config('app.timezone')) : null,
        ]);

        $monthStart = now()->startOfMonth();

        return [
            'configured' => true,
            'error'      => null,
            'total'      => $users['total'],
            'aktif'      => $rows->where('active', true)->count(),
            'bulanIni'   => $rows->filter(fn ($r) => $r['created'] && $r['created']->gte($monthStart))->count(),
            'terbaru'    => $rows->sortByDesc(fn ($r) => $r['created']?->timestamp ?? 0)->take($latest)->values()->all(),
            'fetchedAt'  => Carbon::parse($users['fetched_at']),
        ];
    }

    /** Ambil semua halaman dari API. */
    private function fetchAll(): array
    {
        $limit = (int) config('services.ppid_api.page_size', 100);
        $page = 1;
        $data = [];
        $total = 0;

        do {
            $json = $this->request()
                ->get(config('services.ppid_api.users_url'), ['page' => $page, 'limit' => $limit])
                ->throw()
                ->json();

            if (! ($json['status'] ?? false) || ! isset($json['data']['data'])) {
                throw new \RuntimeException('Format respons API tidak dikenali: ' . ($json['message'] ?? 'tanpa pesan'));
            }

            $data = array_merge($data, $json['data']['data']);
            $total = (int) ($json['data']['meta']['total_records'] ?? count($data));
            $totalPages = (int) ($json['data']['meta']['total_pages'] ?? 1);
            $page++;
        } while ($page <= $totalPages && $page <= self::MAX_PAGES);

        return ['data' => $data, 'total' => $total, 'fetched_at' => now()->toIso8601String()];
    }

    private function request()
    {
        $http = Http::acceptJson()
            ->timeout((int) config('services.ppid_api.timeout', 10))
            ->retry(1, 300, throw: false);

        if ($token = config('services.ppid_api.token')) {
            $http = $http->withToken($token);
        }

        return $http;
    }
}
