@extends('layouts.admin')

@section('title', $user->first_name)

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">{{ $user->first_name }} {{ $user->last_name }}</h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card-tools mb-3">
                        <a href="{{ route('admin.users.index') }}" title="@lang('messages.back')"
                           class="btn btn-warning ">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                            @lang('messages.back')
                        </a>
                        <a class="btn btn-primary "
                           href="{{ route('admin.users.edit',['user' => $user]) }}"
                           title="@lang('messages.edit')">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                            @lang('messages.edit')
                        </a>
                        <form method="POST" action="{{ route('admin.users.destroy',['user' => $user]) }}"
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
                                <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.first_name')</th>
                                <td>{{ $user->first_name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.last_name')</th>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.email')</th>
                                <td> {{ $user->email }} </td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.phone')</th>
                                <td> {{ $user->phone ?? '-' }} </td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.created_at')</th>
                                <td> {{ $user->created_at_format }} </td>
                            </tr>
                            <tr>
                                <th>@lang('validation.attributes.role')</th>
                                <td>
                                    @foreach($user->roles as $role)
                                        @if($role->name === 'developer')
                                            <span
                                                class="badge badge-danger fs-base">@lang('messages.developer')</span>
                                        @elseif($role->name === 'admin')
                                            <span class="badge badge-primary fs-base">@lang('messages.admin')</span>
                                        @elseif($role->name === 'manager')
                                            <span
                                                class="badge badge-success fs-base">@lang('messages.manager')</span>
                                        @else
                                            <span class="badge badge-primary fs-base">@lang('messages.user')</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>Фото</th>
                                <td>
                                    <img class="rounded user-image-edit" src="{{ $user->photo_url }}">
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
