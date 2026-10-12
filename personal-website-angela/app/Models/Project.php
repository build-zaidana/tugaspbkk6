<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'role',
        'year',
        'type',
        'summary',
        'description',
        'image_path',
        'link',
    ];

    /**
     * Route model binding pakai slug, bukan id, biar URL rapi:
     * /projects/tappcom, /projects/claritas
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
