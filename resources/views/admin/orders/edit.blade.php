@extends('layouts.admin')

@section('title', trans('messages.edit'))

@section('content')
    <div class="content-header">
        <div class="container">
            <h3 class="m-0">@lang('messages.edit')</h3>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-warning mb-3" href="{{ route('admin.orders.index') }}"
                       title="@lang('messages.back')">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                </div>
                @include('admin._components.alert')
                <div class="col-12 col-lg-12">
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" action="{{ route('admin.orders.update', ['order' => $order]) }}">
                            @method('PATCH')
                            @csrf
                            @include('admin.orders._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @include('admin._components.select2Scripts')
    <script>
        $('.trigger').change(function () {
            $('.content-type').hide();
            $('.content-type-' + $('.trigger:checked').data('rel')).show();
        }).change();
    </script>
@endpush
