<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SubscriberNotification
 *
 * @property int $id
 * @property int $subscriber_id
 * @property int $notification_id
 * @property int $is_sent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Subscriber|null $subscriber
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification whereIsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification whereSubscriberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SubscriberNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SubscriberNotification extends Model
{
    protected $guarded = false;

    public function subscriber()
    {
        return $this->hasOne(Subscriber::class, 'id','subscriber_id');
    }
}
