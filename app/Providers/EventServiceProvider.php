<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        collect([
            \App\Models\AboutUsContent::class,
            \App\Models\Agreement::class,
            \App\Models\Application::class,
            \App\Models\Banner::class,
            \App\Models\Brand::class,
            \App\Models\Category::class,
            \App\Models\City::class,
            \App\Models\Contact::class,
            \App\Models\Country::class,
            \App\Models\DealerContent::class,
            \App\Models\DeliveryContent::class,
            \App\Models\DeliveryFeature::class,
            \App\Models\DeliveryList::class,
            \App\Models\Feature::class,
            \App\Models\FeatureItem::class,
            \App\Models\FilterItem::class,
            \App\Models\Filter::class,
            \App\Models\HomeContent::class,
            \App\Models\Instruction::class,
            \App\Models\Order::class,
            \App\Models\PaymentMethod::class,
            \App\Models\Product::class,
            \App\Models\SeoPage::class,
            \App\Models\Slider::class,
            \App\Models\SubCategory::class,
            \App\Models\Social::class,
            \App\Models\User::class,
        ])->map(function ($model) {
            $observerClass = "\App\Observers\\" . class_basename($model) . 'Observer';
            $model::observe($observerClass);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
