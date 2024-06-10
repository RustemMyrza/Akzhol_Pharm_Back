@extends('layouts.admin')

@section('title', $application->name)

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">{{ $application->name }}</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-tools mb-3">
                        <a href="{{ route('admin.applications.index') }}" title="@lang('messages.back')"
                           class="btn btn-warning ">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            @lang('messages.back')
                        </a>
                        <a class="btn btn-primary "
                           href="{{ route('admin.applications.edit',['application' => $application]) }}"
                           title="@lang('messages.edit')">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            @lang('messages.edit')
                        </a>
                        <form method="POST"
                              action="{{ route('admin.applications.destroy', ['application' => $application]) }}"
                              class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger" title="Удалить "
                                    onclick="return confirm('@lang('messages.confirm_deletion')')">
                                <i class="fas fa-trash" aria-hidden="true"></i>
                                @lang('messages.delete')
                            </button>
                        </form>
                    </div>
                </div>

                @include('admin._components.alert')

                <div class="col-12 col-lg-12">
                    <div class="info-box shadow-none">
                        <table class="table table-show not-styles">
                            <tbody>
                            <tr>
                                <th>ID</th>
                                <td>{{ $application->id }}</td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.name')</th>
                                <td>{{ $application->name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.phone')</th>
                                <td> {{ $application->phone }} </td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.email')</th>
                                <td> {{ $application->email }} </td>
                            </tr>
                            <tr>
                                <th>Сообщение</th>
                                <td> {{ $application->message }} </td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.time')</th>
                                <td> {{ $application->time_format }} </td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.status')</th>
                                <td>
                                    @if($application->status == 1)
                                        <span class="badge badge-success">Прочитано</span>
                                    @else
                                        <span class="badge badge-primary">Новый</span>
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
