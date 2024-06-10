@extends('layouts.admin')

@section('title', trans('messages.documents'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.documents') </h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">

            <div class="row">
                @include('admin._components.alert')

                <div class="col-12">
                    <div class="card-tools mb-4">
                        <a href="{{ route('admin.agreements.create') }}"
                           class="btn btn-primary mb-2 mb-sm-0"
                           title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>
                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th>@lang('validation.attributes.type')</th>
                                    <th>@lang('messages.document')</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($agreements as $agreement)
                                    <tr>
                                        <td>{{ $agreement->id }}</td>
                                        <td>{{ $agreement->type_name }}</td>
                                        <td>
                                            @if($agreement->fileUrl($agreement->fileTranslate))
                                                <a href="{{ $agreement->fileUrl($agreement->fileTranslate, app()->getLocale()) }}">
                                                    @lang('messages.download')
                                                    ({{ app()->getLocale() }})</a>
                                            @else
                                                @lang('messages.document_not_attached')
                                            @endif
                                        </td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.agreements.edit', ['agreement' => $agreement]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    @lang('messages.edit')
                                                </a>

                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.agreements.destroy', ['agreement' => $agreement]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            title="@lang('messages.delete')"
                                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                                        @lang('messages.delete')
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td align="center" class="text-danger p-2" colspan="4">
                                            @lang('messages.documents_not_found')
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
