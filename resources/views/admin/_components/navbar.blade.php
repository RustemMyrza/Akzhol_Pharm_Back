<nav class="main-header navbar navbar-expand navbar-white navbar-light">
{{--    <a href="/" class="brand-link text-center p-0">--}}
{{--        <img src="{{ asset('adminlte-assets/dist/img/logo.png') }}" alt="{{ config('app.name') }}"--}}
{{--             style="max-height: 36px; margin: 10px auto 0">--}}
{{--    </a>--}}

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link"
               data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-align-left"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto mr-1 mr-md-5 ">
        @includeIf('admin._components.languageDropdown')

        <li class="nav-item dropdown">
                <a href="javascript: void(0)" class="nav-link dropdown-toggle nav-link-btn" data-toggle="dropdown">
                    <img src="{{ auth()->user()->photo_url }}" class="nav-link-image">
                </a>
            <div class="dropdown-menu dropdown-menu-right">
                @if(\Route::has('admin.users.edit'))
                    <a href="{{ route('admin.users.edit', ['user' => auth()->id()]) }}" class="dropdown-item">
                        <span>Редактировать </span>
                    </a>
                @endif
                @if(\Route::has('logout'))
                    <a href="javascript: void(0)">
                        <form method="POST" class="d-inline-block" action="{{ route('logout') }}">
                            @method('POST')
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-item-logout">
                                <i class="fa fa-fw fa-power-off"></i>
                                @lang('messages.logout')
                            </button>
                        </form>
                    </a>
                @endif
            </div>
        </li>
    </ul>
</nav>


