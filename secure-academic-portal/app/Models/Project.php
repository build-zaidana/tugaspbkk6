<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory;

    /**
     * Whitelist kolom yang boleh diisi massal.
     * user_id, nilai, dan catatan_review sengaja tidak dicantumkan
     * agar tidak bisa disuntikkan lewat form (mass assignment).
     *
     * @var list<string>
     */
    protected $fillable = [
        'judul',
        'deskripsi',
        'tema_agent',
        'api_key_secure',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'api_key_secure',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'api_key_secure' => 'encrypted',
            'nilai' => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
