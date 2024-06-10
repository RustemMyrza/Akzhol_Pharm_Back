@extends('layouts.admin')

@section('title', 'E-mail рассылки')

@push('styles')
    <style>
        .table tbody tr td {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">E-mail рассылки ({{ $notificationMessages->total() }})</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            @include('admin._components.alert')

            <div class="card-tools d-flex align-items-center flex-wrap justify-content-between mb-3">
                <div class="card-tool">
                    <a href="{{ route('admin.notificationMessages.create') }}"
                       class="btn btn-primary btn-sm"
                       title="@lang('messages.add')">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                        @lang('messages.add')
                    </a>
                </div>
                <form method="GET" action="{{ route('admin.notificationMessages.index')  }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="@lang('messages.search')..."
                               value="{{ request('search') ?? '' }}">
                        <span class="input-group-append">
                            <button class="btn btn-secondary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="info-box info-card flex-column shadow-none">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead">
                        <tr>
                            <th>#ID</th>
                            <th>@lang('validation.attributes.title')</th>
                            <th>Рубрики</th>
                            <th>@lang('validation.attributes.status')</th>
                            <th>@lang('messages.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($notificationMessages as $notificationMessage)
                            <tr>
                                <td>{{ $notificationMessage->id }}</td>
                                <td style="white-space: normal">{{ $notificationMessage->title }}</td>
                                <td>{{ $notificationMessage->type_name }}</td>
                                <td>
                                    @if($notificationMessage->status != 1)
                                        <span class="badge badge-warning">
                                                {{ $notificationMessage->status_name }}
                                            </span>
                                        <form
                                            action="{{ route('admin.notificationMessages.sendMessages', $notificationMessage) }}"
                                            method="POST" class="d-inline-block ml-2">
                                            @method('POST')
                                            @csrf
                                            <button type="submit"
                                                    onclick="return confirm('@lang('messages.are_you_sure_send_notifications')')"
                                                    class="btn btn-sm btn-success">
                                                <i class="fas fa-envelope"></i>
                                                @lang('messages.send')
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge badge-success">
                                                {{ $notificationMessage->status_name }}
                                            </span>

                                        @if($notificationMessage->batch())
                                            @php
                                                $batch = $notificationMessage->batch();
                                            @endphp

                                            @if($batch)
                                                <button class="btn btn-default ml-2">
                                                            <span
                                                                class="text-success">@lang('messages.success'): {{ $batch->processedJobs() }} </span>
                                                    /
                                                    <span
                                                        class="text-danger">@lang('messages.error'): {{ $batch->failedJobs }}</span>
                                                    /
                                                    @lang('messages.all') {{ $batch->totalJobs }}.
                                                    @lang('messages.sent'): {{ $batch->progress() }}%
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="card-tools button-wrap">
                                        <a href="{{ route('admin.notificationMessages.show',$notificationMessage) }}"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.notificationMessages.edit',$notificationMessage) }}"
                                           class="btn btn-primary btn-sm">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <form method="POST"
                                              action="{{ route('admin.notificationMessages.destroy', $notificationMessage) }}"
                                              style="display:inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td align="center" class="text-danger p-2" colspan="5">
                                E-mail рассылки не найдены
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="pagination-wrapper">
                        {!! $notificationMessages->appends(['search' => request('search')])->render() !!}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
