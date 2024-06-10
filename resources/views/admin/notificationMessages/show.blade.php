@extends('layouts.admin')

@section('title', trans('messages.info'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.info')</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <div class="card-tools mb-3">
                        <a href="{{ route('admin.notificationMessages.index') }}" title="@lang('messages.back')"
                           class="btn btn-warning btn-sm ">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            @lang('messages.back')
                        </a>
                        <a class="btn btn-primary btn-sm"
                           href="{{ route('admin.notificationMessages.edit', ['notificationMessage' => $notificationMessage]) }}"
                           title="@lang('messages.edit')">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            @lang('messages.edit')
                        </a>
                        <form method="POST"
                              action="{{ route('admin.notificationMessages.destroy', ['notificationMessage' => $notificationMessage]) }}"
                              class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm" title="@lang('messages.delete') "
                                    onclick="return confirm('@lang('messages.confirm_deletion')')">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                                @lang('messages.delete')
                            </button>
                        </form>
                    </div>

                    <div class="info-box shadow-none">
                        <div class="table-responsive">
                            <table class="table table-show not-styles">
                                <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $notificationMessage->id }}</td>
                                </tr>

                                <tr>
                                    <th>@lang('validation.attributes.title')</th>
                                    <td> {{ $notificationMessage->title }} </td>
                                </tr>

                                <tr>
                                    <th>Рубрики</th>
                                    <td> {{ $notificationMessage->type_name }} </td>
                                </tr>

                                <tr>
                                    <th>@lang('validation.attributes.status')</th>
                                    <td>
                                        @if($notificationMessage->status != 1)
                                            <span class="badge badge-warning">
                                    {{ $notificationMessage->status_name }}
                                </span>
                                        @else
                                            <span class="badge badge-success">
                                                {{ $notificationMessage->status_name }}
                                            </span>
                                            @if($notificationMessage->batch())
                                                @php
                                                    $batch = $notificationMessage->batch();
                                                @endphp

                                                <button class="btn btn-default ml-2">
                                                    <span class="text-success">@lang('messages.success'): {{ $batch->processedJobs() }} </span>
                                                    /
                                                    <span
                                                            class="text-danger">@lang('messages.error'): {{ $batch->failedJobs }}</span>
                                                    /
                                                    @lang('messages.all') {{ $batch->totalJobs }}.
                                                    @lang('messages.sent'): {{ $batch->progress() }}%
                                                </button>

                                                @if($batch && $batch->hasFailures())
                                                    <form class="d-inline-block"
                                                          action="{{ route('admin.notificationMessages.retrySendMessages', ['notificationMessage' => $notificationMessage]) }}"
                                                          method="POST">
                                                        @method('POST')
                                                        @csrf
                                                        <button class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-undo-alt"></i>
                                                            @lang('messages.send_retry')
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <h6>
                        @lang('messages.users')
                        ({{ count($notificationMessage->subscriberNotifications) }})
                    </h6>

                    @if(count($notificationMessage->subscriberNotifications))
                        <div class="info-box info-card flex-column shadow-none">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead">
                                    <tr>
                                        <th>#ID</th>
                                        <th>@lang('messages.user')</th>
                                        <th>@lang('validation.attributes.status')</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($notificationMessage->subscriberNotifications as $subscriberNotification)
                                        <tr>
                                            <td>
                                                {{ $subscriberNotification->id }}
                                            </td>
                                            <td>
                                                {{ $subscriberNotification->subscriber?->email }}
                                            </td>
                                            <td>
                                                @if($notificationMessage->status == 0)
                                                    <span class="badge badge-danger">@lang('messages.not_sent')</span>
                                                @else
                                                    <span class="badge badge-success">@lang('messages.sent')</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger alert-dismissible border-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="m-0"><i class="icon fas fa-ban"></i>
                                @lang('messages.users_not_found')
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection
