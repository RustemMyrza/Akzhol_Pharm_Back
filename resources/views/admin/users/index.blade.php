@extends('layouts.admin')

@section('title', trans('messages.users'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.users') ({{ $users->total() }})</h5>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container">

            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <div class="card-tools flex-wrap justify-content-between mb-2 mb-md-3">
                        <div class="card-tools flex-wrap">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary"
                               title="@lang('messages.add')">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>

                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#danger">
                                <i class="fas fa-file-import"></i>
                                Импортировать
                            </button>

                            <div class="modal fade text-left" id="danger" tabindex="-1"
                                 role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <h6 class="modal-title white">Импортировать</h6>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.users.import') }}"
                                                  method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="custom-file required @error('document') is-invalid @enderror">
                                                    <label for="document" class="control-label custom-file-label">Excel файл (Макс: 20Мб): </label>
                                                    <input type="file" class="custom-file-input" id="document"
                                                           accept=".xlsx, .xls"
                                                           name="document" required>
                                                    @error('document')
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                                <div class="buttons d-flex align-items-center justify-content-center mt-3">
                                                    <button type="reset"
                                                            class="btn btn-outline-danger"
                                                            data-dismiss="modal">
                                                        @lang('messages.cancel')
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary ml-1">
                                                        Импортировать
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('admin.users.importExample') }}"
                                                  method="POST" class="w-100 d-flex align-items-center justify-content-center">
                                                @csrf
                                                <button type="submit" class="text-primary">
                                                    Скачать образец
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#primary">
                                <i class="fas fa-file-download"></i>
                                @lang('messages.excel_upload')
                            </button>

                            <div class="modal fade text-left" id="primary" tabindex="-1"
                                 role="dialog"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
                                     role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-secondary">
                                            <h6 class="modal-title white">@lang('messages.excel_upload')</h6>
                                        </div>
                                        <form action="{{ route('admin.users.export') }}"
                                              method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="role" class="control-label">@lang('messages.by_role')
                                                        : </label>
                                                    <select name="role" id="role" class="form-control select2"
                                                            style="width: 100%;">
                                                        <option value="">@lang('messages.not_selected')</option>
                                                        @forelse($roles as $index => $role)
                                                            <option value="{{ $index }}"
                                                                    @if(old('role') == $index) selected @endif>
                                                                {{ $role }}
                                                            </option>
                                                        @empty
                                                            <option selected disabled>
                                                                @lang('messages.role_not_found')
                                                            </option>
                                                        @endforelse
                                                    </select>
                                                </div>

                                                <div class="buttons d-flex align-items-center justify-content-center">
                                                    <button type="reset"
                                                            class="btn btn-outline-danger"
                                                            data-dismiss="modal">
                                                        @lang('messages.cancel')
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-primary ml-1">
                                                        Выгрузить
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end">
                            <form method="GET" class="search-form form-inline"
                                  action="{{ route('admin.users.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                           placeholder="@lang('messages.search')..."
                                           value="{{ request('search') ?? '' }}">
                                    <span class="input-group-append">
                                        <button class="btn btn-secondary" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#</th>
                                    <th>@lang('validation.attributes.first_name') @lang('validation.attributes.last_name')</th>
                                    <th>@lang('validation.attributes.email')</th>
                                    <th>@lang('validation.attributes.phone')</th>
                                    <th>@lang('validation.attributes.created_at')</th>
                                    <th>@lang('validation.attributes.role')</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img class="user-photo" src="{{ $user->photo_url }}" alt="">
                                                {{ $user->full_name }} <br>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? '-' }}</td>
                                        <td>{{ $user->created_at_format }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                @if($role->name === 'developer')
                                                    <span class="badge badge-danger">@lang('messages.developer')</span>
                                                @elseif($role->name === 'admin')
                                                    <span class="badge badge-primary">@lang('messages.admin')</span>
                                                @elseif($role->name === 'manager')
                                                    <span class="badge badge-warning">@lang('messages.manager')</span>
                                                @else
                                                    <span class="badge badge-info">@lang('messages.user')</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.users.show',['user' => $user]) }}"
                                                   title="@lang('messages.view')" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('admin.users.edit', ['user' => $user]) }}"
                                                   title="@lang('messages.edit')" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('admin.users.destroy', ['user' => $user]) }}"
                                                      style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"
                                                            title="@lang('messages.delete')"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                        Удалить
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td align="center" class="text-danger p-2" colspan="7">
                                        @lang('messages.users_not_found')
                                    </td>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {!! $users->appends(['search' => request('search')])->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.select2Scripts')
    @include('admin._components.customFileInput')
@endpush
