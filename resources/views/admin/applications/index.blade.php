@extends('layouts.admin')

@section('title', 'Обратной связи')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Обратной связи ({{ $applications->total() }})</h5>
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
                            <a href="{{ route('admin.applications.create') }}" class="btn btn-primary"
                               title="@lang('messages.add')">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                @lang('messages.add')
                            </a>

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
                                        <form action="{{ route('admin.applications.export') }}"
                                              method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="status" class="control-label">
                                                        @lang('messages.by_status'):
                                                    </label>
                                                    <select name="status" class="form-control select2"
                                                            style="width: 100%;">
                                                        <option value="">@lang('messages.not_selected')</option>
                                                        @forelse($statuses as $index => $status)
                                                            <option value="{{ $index }}"
                                                                    @if(!is_null(request('status')) && old('status') == $index) selected @endif>
                                                                {{ $status }}
                                                            </option>
                                                        @empty
                                                            <option selected disabled>
                                                                @lang('messages.statuses_not_found')
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
                        <div class="d-flex justify-content-end">
                            <form method="GET" class="search-form form-inline" action="{{ route('admin.applications.index') }}">
                                <div class="form-group mb-2 mb-lg-0 mr-0 mr-lg-2">
                                    <select name="status" class="form-control select2"
                                            onchange="this.form.submit()">
                                        <option value="">Выберите статус ... </option>
                                        @forelse($statuses as $index => $status)
                                            <option {{ !is_null(request('status')) && $index == request('status') ? 'selected' : '' }}
                                                    value="{{ $index }}">
                                               {{ $status }}
                                            </option>
                                        @empty
                                            <option selected disabled>Статусы не найдены</option>
                                        @endforelse
                                    </select>
                                </div>
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
                                    <th>@lang('validation.attributes.name')</th>
                                    <th>@lang('validation.attributes.phone')</th>
                                    <th>@lang('validation.attributes.email')</th>
                                    <th>Сообщение</th>
                                    <th>@lang('validation.attributes.time')</th>
                                    <th>@lang('validation.attributes.status')</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($applications as $application)
                                    <tr>
                                        <td>{{ $application->id }}</td>
                                        <td style="white-space: normal">{{ $application->name }}</td>
                                        <td style="white-space: normal">{{ $application->phone }}</td>
                                        <td style="white-space: normal">{{ $application->email }}</td>
                                        <td style="white-space: normal">{{ miniText($application->message, 30) }}</td>
                                        <td style="white-space: normal">{{ $application->time_format }}</td>
                                        <td>
                                            @if($application->status == 1)
                                                <span class="badge badge-success">Прочитано</span>
                                            @else
                                                <span class="badge badge-primary">Новый</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.applications.show',['application' => $application]) }}"
                                                   title="@lang('messages.view')" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('admin.applications.edit', ['application' => $application]) }}"
                                                   title="@lang('messages.edit')" class="btn btn-primary btn-icon">
                                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                                </a>

                                                <form method="POST"
                                                      action="{{ route('admin.applications.destroy', ['application' => $application]) }}"
                                                      style="display:inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"
                                                            title="@lang('messages.delete')"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        <i class="fas fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td align="center" class="text-danger p-2" colspan="8">
                                        Обратной связи не найдены
                                    </td>
                                @endforelse
                                </tbody>
                            </table>

                            <div class="pagination-wrapper">
                                {!! $applications->appends(['search' => request('search')])->render() !!}
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
@endpush
