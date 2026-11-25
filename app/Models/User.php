<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /** User dianggap online bila ada request dalam sekian menit terakhir. */
    public const ONLINE_MINUTES = 5;

    /**
     * Waktu aktivitas terakhir per user, diambil dari tabel sessions (SESSION_DRIVER=database).
     * Session dihapus saat logout/kedaluwarsa, jadi user tanpa session dianggap offline.
     *
     * @return Collection<int, Carbon>  [user_id => waktu terakhir aktif]
     */
    public static function lastActivityMap(iterable $ids): Collection
    {
        $ids = collect($ids)->filter()->unique()->values();
        if ($ids->isEmpty()) {
            return collect();
        }

        return DB::table(config("session.table", "sessions"))
            ->whereIn("user_id", $ids)
            ->selectRaw("user_id, MAX(last_activity) AS last_activity")
            ->groupBy("user_id")
            ->pluck("last_activity", "user_id")
            ->map(fn ($ts) => Carbon::createFromTimestamp((int) $ts, config("app.timezone")));
    }

    /** Jumlah user yang sedang online. */
    public static function onlineCount(): int
    {
        return DB::table(config("session.table", "sessions"))
            ->whereNotNull("user_id")
            ->where("last_activity", ">=", now()->subMinutes(self::ONLINE_MINUTES)->getTimestamp())
            ->distinct()
            ->count("user_id");
    }

    public static function isOnlineAt(?Carbon $lastActivity): bool
    {
        return $lastActivity !== null && $lastActivity->gte(now()->subMinutes(self::ONLINE_MINUTES));
    }
    /** URL foto profil, atau null bila belum ada (tampilkan huruf depan nama). */
    public function getAvatarUrlAttribute(): ?string
    {
        $path = $this->attributes["avatar"] ?? null;

        // asset() mengikuti alamat yang sedang dibuka (mis. localhost:8000), sama seperti gambar lain di aplikasi ini.
        // Storage::url() memakai APP_URL, yang bisa berbeda port/domain sehingga gambar tidak tampil.
        return $path ? asset('storage/' . $path) : null;
    }

    /** Huruf depan nama untuk avatar tanpa foto. */
    public function getInitialAttribute(): string
    {
        return mb_strtoupper(mb_substr(trim((string) $this->name), 0, 1)) ?: "?";
    }

    /** Kolom users.avatar sudah dibuat? (lihat migration add_avatar_to_users_table) */
    public static function supportsAvatar(): bool
    {
        static $ada;

        return $ada ??= Schema::hasColumn((new static)->getTable(), "avatar");
    }

    /** Email reset password memakai template bahasa Indonesia & tautan halaman reset panel admin. */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\AdminResetPassword($token));
    }
}
