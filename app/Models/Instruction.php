<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Instruction
 *
 * @property int $id
 * @property int|null $title
 * @property int|null $link
 * @property string|null $image
 * @property int $is_active
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\MediaTranslate|null $fileTranslate
 * @property-read string $image_url
 * @property-read \App\Models\Translate|null $titleTranslate
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction isActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Instruction withTranslations()
 * @mixin \Eloquent
 */
class Instruction extends Model
{
    protected $guarded = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['image_url'];

    const IMAGE_PATH = 'images/instructions';
    const DEFAULT_IMAGE_PATH = 'adminlte-assets/dist/img/instructions/instruction-default.png';
    const FILE_PATH = 'files/instructions';
    const CACHE_TIME = 60 * 60 * 24;
    const DEFAULT_API_PAGINATE = 20;

    public function titleTranslate(): HasOne
    {
        return $this->hasOne(Translate::class, 'id', 'title');
    }

    public function fileTranslate(): HasOne
    {
        return $this->hasOne(MediaTranslate::class, 'id', 'link');
    }

    public function fileUrl($files, string $language = MediaTranslate::DEFAULT_LANG): string
    {
        $filteredFiles = array_filter($files->only(MediaTranslate::LANGUAGES));
        if (!$filteredFiles) return false;
        $file = $filteredFiles[$language] ?? $filteredFiles[array_key_first($filteredFiles)];
        return Storage::disk('custom')->url(self::FILE_PATH . '/' . $file);
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public static function lastPosition()
    {
        return static::query()->max('position') + 1;
    }

    public function scopeWithTranslations($query)
    {
        return $query->with(['titleTranslate', 'fileTranslate'])->orderBy('position')->orderBy('id');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::disk('custom')->url(self::IMAGE_PATH . '/' . $this->image) : asset(self::DEFAULT_IMAGE_PATH);
    }
}
