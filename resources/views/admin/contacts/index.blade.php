@extends('layouts.admin')

@section('title', trans('messages.contacts'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.contacts')</h5>
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
                        <a href="{{ route('admin.contacts.create') }}"
                           class="btn btn-success btn-sm mr-1 mb-2 mb-sm-0" title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>

                    <div class="info-box info-card flex-column shadow-none">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead">
                                <tr>
                                    <th>#ID</th>
                                    <th>@lang('validation.attributes.email')</th>
                                    <th>@lang('validation.attributes.phone')</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse($contacts as $contact)
                                    <tr>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->phone }}</td>
                                        <td>
                                            <div class="card-tools">
                                                <a href="{{ route('admin.contacts.edit', ['contact' => $contact]) }}"
                                                   title="@lang('messages.edit')"
                                                   class="btn btn-primary btn-sm">
                                                    @lang('messages.edit')
                                                </a>
                                                <form method="POST" class="d-inline"
                                                      action="{{ route('admin.contacts.destroy', ['contact' => $contact]) }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                            title="Удалить"
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
                                            @lang('messages.contacts_not_found')
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
