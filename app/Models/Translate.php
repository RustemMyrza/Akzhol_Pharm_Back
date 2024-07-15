<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Translate
 *
 * @property int $id
 * @property string|null $ru
 * @property string|null $kz
 * @property string|null $en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Translate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Translate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Translate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translate whereEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translate whereKz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translate whereRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Translate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Translate extends Model
{
    protected $guarded = false;

    protected $fillable = [
        'kz',
        'ru',
        'en'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    const LANGUAGES = ['ru', 'en', 'kz'];
    const LANGUAGES_ASSOC = ['ru' => 'Текст на русском', 'en' => 'Текст на английском', 'kz' => 'Текст на казахском'];
    const DEFAULT_LANG = 'ru';
}
