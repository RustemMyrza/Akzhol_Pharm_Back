<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaTranslate extends Model
{
    protected $guarded = false;

    protected $fillable = [
        'kz',
        'ru',
        'en',
        'kz_size',
        'ru_size',
        'en_size'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    const LANGUAGES = ['ru', 'en'];
    const DEFAULT_LANG = 'ru';
}
