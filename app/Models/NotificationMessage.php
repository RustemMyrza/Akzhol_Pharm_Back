<?php

namespace App\Models;

use App\Enum\NotificationMessageStatusEnum;
use App\Enum\NotificationMessageTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Bus;

/**
 * App\Models\NotificationMessage
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $batch_id
 * @property int $type
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $status_name
 * @property-read string $type_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubscriberNotification> $subscriberNotifications
 * @property-read int|null $subscriber_notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationMessage extends Model
{
    protected $guarded = false;

    protected $casts = ['types' => 'array'];

    protected $appends = [
        'status_name',
        'type_name',
    ];

    public function getStatusNameAttribute(): string
    {
        return NotificationMessageStatusEnum::statuses()[$this->status] ?? 'Статус неизвестен';
    }

    public function getTypeNameAttribute(): string
    {
        return NotificationMessageTypeEnum::types()[$this->type] ?? 'Типы неизвестен';
    }

    public function subscriberNotifications(): HasMany
    {
        return $this->hasMany(SubscriberNotification::class, 'notification_id', 'id');
    }

    public function batch()
    {
        return $this->batch_id ? Bus::findBatch($this->batch_id) : null;
    }
}
