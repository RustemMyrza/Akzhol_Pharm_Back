@extends('layouts.admin')

@section('title', 'Главная')

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">Главная</h5>
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
                        <a href="{{ route('admin.homeContents.create') }}"
                           class="btn btn-success btn-sm" title="@lang('messages.add')">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                            @lang('messages.add')
                        </a>
                    </div>

                   @if(!count($homeContents))
                        <div class="alert alert-danger alert-dismissible border-0">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p class="m-0"><i class="icon fas fa-ban"></i> Главная контент не найдено </p>
                        </div>
                    @else
                    <div class="info-box info-card flex-column shadow-none">
                    <div class="table-responsive" id="for_sort">
                        <table class="table table-hover">
                            <thead class="thead">
                            <tr>
                                <th>#ID</th>
                                <th>Заголовок</th>
                                <th>Описание</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($homeContents as $content)
                                <tr>
                                    <td>{{ $content->id }}</td>
                                    <td>
                                        {{ $content->titleTranslate?->ru }}
                                    </td>
                                    <td style="white-space: normal">{{ $content->descriptionTranslate?->ru }}</td>
                                    <td>
                                        <a href="{{ route('admin.homeContents.edit', ['homeContent' => $content->id]) }}"
                                            title="@lang('messages.edit')"
                                            class="btn btn-primary btn-icon">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                                    
                                    </div>
                                </div>
                            @endif
                </div>
            </div>
        </div>
    </section>
@endsection
