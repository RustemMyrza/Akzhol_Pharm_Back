<aside class="main-sidebar sidebar-dark-primary ">
    <a href="/" class="brand-link">
        <img src="{{ asset('adminlte-assets/dist/img/logo.png') }}" alt="{{ config('app.name') }}">
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @if(\Route::has('admin.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>@lang('messages.main')</p>
                        </a>
                    </li>
                @endif

                <!-- @if(\Route::has('admin.applications.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.applications.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-phone-square"></i>
                            <p>Обратной связи</p>
                        </a>
                    </li>
                @endif -->

                {{--  @if(\Route::has('admin.countries.index'))--}}
                {{--      <li class="nav-item">--}}
                {{--          <a href="{{ route('admin.countries.index') }}" class="nav-link">--}}
                {{--              <i class="nav-icon fas fa-map-marked-alt"></i>--}}
                {{--              <p>Страны</p>--}}
                {{--          </a>--}}
                {{--      </li>--}}
                {{--  @endif--}}

                @if(\Route::has('admin.cities.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.cities.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-map-marker-alt"></i>
                            <p>Города</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.categories.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Категорий</p>
                        </a>
                    </li>
                @endif

                {{--                @if(\Route::has('admin.brands.index'))--}}
                {{--                    <li class="nav-item">--}}
                {{--                        <a href="{{ route('admin.brands.index') }}" class="nav-link">--}}
                {{--                            <i class="nav-icon fas fa-bold"></i>--}}
                {{--                            <p>Бренды</p>--}}
                {{--                        </a>--}}
                {{--                    </li>--}}
                {{--                @endif--}}

                @if(\Route::has('admin.filters.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.filters.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-filter"></i>
                            <p>Фильтр</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.features.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.features.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>Характеристики</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.products.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-boxes"></i>
                            <p>Товары</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.orders.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.orders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            {{-- <i class="nav-icon fas fa-truck"></i>--}}
                            <p>Заказы</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.users.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>@lang('messages.users')</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.notificationMessages.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.notificationMessages.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>E-mail рассылки</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">Настройки</li>

                <li class="nav-item">
                    <a href="javascript: void(0)" class="nav-link">
                        <i class="nav-icon fas fa-tv"></i>
                        <p>
                            Cтраницы
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @if(\Route::has('admin.homeContents.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.homeContents.index') }}"
                                   class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>Главная</p>
                                </a>
                            </li>
                        @endif

                        @if(\Route::has('admin.aboutUsContents.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.aboutUsContents.index') }}"
                                   class="nav-link">
                                    <i class="nav-icon fas fa-address-card"></i>
                                    <p>О компании</p>
                                </a>
                            </li>
                        @endif

                        @if(\Route::has('admin.dealerContents.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.dealerContents.index') }}"
                                   class="nav-link">
                                    <i class="nav-icon fas fa-handshake"></i>
                                    <p>Каталог товаров</p>
                                </a>
                            </li>
                        @endif

                        @if(\Route::has('admin.deliveryContents.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.deliveryContents.index') }}"
                                   class="nav-link ">
                                    <i class="nav-icon fas fa-people-carry"></i>
                                    <p>Доставка</p>
                                </a>
                            </li>
                        @endif

                        @if(\Route::has('admin.paymentContent.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.paymentContent.index') }}"
                                   class="nav-link ">
                                    <i class="nav-icon fas fa-credit-card"></i>
                                    <p>Оплата</p>
                                </a>
                            </li>
                        @endif

                        @if(\Route::has('admin.instructions.index'))
                            <li class="nav-item">
                                <a href="{{ route('admin.instructions.index') }}"
                                   class="nav-link">
                                    <i class="nav-icon fas fa-paste"></i>
                                    <p>Отзывы</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

                @if(\Route::has('admin.seoPages.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.seoPages.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-puzzle-piece"></i>
                            <p>Меню / SEO страницы</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.banners.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.banners.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Баннер</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.sliders.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.sliders.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-image"></i>
                            <p>Слайдер</p>
                        </a>
                    </li>
                @endif

                @role('developer')
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>@lang('messages.settings')</p>
                    </a>
                </li>
                @endrole

                @if(\Route::has('admin.contacts.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.contacts.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-phone"></i>
                            <p>@lang('messages.contacts')</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.socials.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.socials.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-share-alt"></i>
                            <p>@lang('messages.socials')</p>
                        </a>
                    </li>
                @endif

                @if(\Route::has('admin.agreements.index'))
                    <li class="nav-item">
                        <a href="{{ route('admin.agreements.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>@lang('messages.documents')</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
