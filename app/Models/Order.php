<?php

namespace App\Models;

use App\Enum\DeliveryTypeEnum;
use App\Enum\OrderStatusEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\UserTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $user_type
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $address
 * @property string|null $message
 * @property string|null $organization_name
 * @property string|null $organization_bin
 * @property string|null $organization_email
 * @property string|null $organization_phone
 * @property string|null $organization_legal_address
 * @property string|null $organization_current_address
 * @property int $delivery_type
 * @property int $payment_method
 * @property int $payment_status
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $created_at_format
 * @property-read string $delivery_type_name
 * @property-read string $full_name
 * @property-read string $payment_method_name
 * @property-read string $status_name
 * @property-read string $user_type_name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderProduct> $orderProducts
 * @property-read int|null $order_products_count
 * @property-read \App\Models\Payment|null $payment
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrganizationBin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrganizationCurrentAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrganizationEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrganizationLegalAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrganizationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrganizationPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserType($value)
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'message',
        'organization_name',
        'organization_bin',
        'organization_email',
        'organization_phone',
        'organization_legal_address',
        'organization_current_address',
        'delivery_type',
        'payment_method',
        'payment_status',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function getStatusNameAttribute(): string
    {
        return OrderStatusEnum::statuses()[$this->status] ?? 'Статус неизвестен';
    }

    public function getUserTypeNameAttribute(): string
    {
        return UserTypeEnum::types()[$this->user_type] ?? 'Тип неизвестен';
    }

    public function getDeliveryTypeNameAttribute(): string
    {
        return DeliveryTypeEnum::types()[$this->delivery_type] ?? 'Тип неизвестен';
    }

    public function getPaymentMethodNameAttribute(): string
    {
        return PaymentMethodEnum::methods()[$this->payment_method] ?? 'Метод неизвестен';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function getCreatedAtFormatAttribute(): string
    {
        return $this->created_at ? date('d.m.Y H:i', strtotime($this->created_at)) : 'Время не неизвестен';
    }
}
