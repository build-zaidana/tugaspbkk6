<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseTask extends Model
{
    /** @use HasFactory<\Database\Factories\CourseTaskFactory> */
    use HasFactory;

    protected $fillable = ['judul', 'mata_kuliah', 'deskripsi', 'tanggal_pengumpulan'];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return ['tanggal_pengumpulan' => 'date'];
    }

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
