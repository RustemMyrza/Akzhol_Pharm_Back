@extends('layouts.admin')

@section('title', 'Настройки сайта')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <h5 class="m-0">Настройки сайта для разработчика</h5>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @include('admin._components.alertSettings')

            <div class="card-tools flex-wrap mb-2">
                <a class="btn btn-primary btn-sm mr-1" href="{{ url('/admin/settings/log-viewer') }}">
                    <i class="fas fa-external-link-alt"></i>
                    Посмотреть логи
                </a>

                <a class="btn btn-primary btn-sm mr-1" href="{{ url('/admin/pulse') }}">
                    <i class="fas fa-external-link-alt"></i>
                    Laravel Pulse
                </a>

                <a class="btn btn-primary btn-sm mr-1" href="{{ route('admin.settings.fileManager') }}">
                    <i class="fas fa-external-link-alt"></i>
                    File Manager
                </a>

                @if(Route::has('telescope'))
                <a class="btn btn-primary btn-sm mr-1" href="{{ route('telescope') }}">
                    <i class="fas fa-external-link-alt"></i>
                    Telescope
                </a>
                @endif

                <a class="btn btn-primary btn-sm mr-1" href="{{ url('phpinfo') }}">
                    <i class="fas fa-external-link-alt"></i>
                    PHP INFO
                </a>
            </div>

            <div class="card-tools flex-wrap mb-2">
                <form method="POST" action="{{ route('admin.commands.optimizeClear') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Optimize-clear
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.commands.storageLink') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Storage-link
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.commands.configClear') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Config-clear
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.commands.configCache') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Config-cache
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.commands.routeClear') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Route-clear
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.commands.routeCache') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Route-cache
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.commands.cacheClear') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-danger btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Cache-clear
                    </button>
                </form>
            </div>


            <div class="card-tools flex-wrap mb-2">
                <form method="POST" action="{{ route('admin.commands.migrate') }}"
                      class="d-inline">
                    @method('POST')
                    @csrf
                    <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                            class="btn btn-warning btn-sm" title="Storage-link">
                        <i class="fas fa-cog"></i>
                        Migrate Run
                    </button>
                </form>
            </div>

            <br>
            <br>

            @if(Route::has('admin.commands.shellExec'))
                <div class="card-tools flex-wrap mb-2">
                    <form method="POST" action="{{ route('admin.commands.shellExec') }}"
                          class="d-inline">
                        @method('POST')
                        @csrf
                        <div class="form-row">
                            <input style="width: 350px;" type="text" class="form-control  mr-2" name="command"
                                   maxlength="255">
                            <button type="submit" onclick="return confirm('Вы уверенны запустить этот процесс?')"
                                    class="btn btn-secondary" title="Storage-link">
                                <i class="fas fa-cog"></i>
                                Run
                            </button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </section>
@endsection
