@extends('layouts.admin')

@section('title', trans('messages.edit'))

@section('content')
    <div class="content-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5 class="m-0">@lang('messages.edit') </h5>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container">
            <div class="row">
                @include('admin._components.alert')
                <div class="col-12">
                    <a href="{{ route('admin.products.index') }}" title="@lang('messages.back')"
                       class="btn btn-warning btn-sm mb-3">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @lang('messages.back')
                    </a>
                    <div class="info-box flex-column shadow-none">
                        <form method="POST" class="form-horizontal"
                              action="{{ route('admin.products.updateSeo', ['product' => $product]) }}">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs mb-3" id="custom-tabs-two-tab" role="tablist">
                                        @foreach(\App\Models\Translate::LANGUAGES_ASSOC as $key => $language)
                                            <li class="nav-item @if($loop->first) @endif">
                                                <button class="nav-link @if($loop->first) active @endif"
                                                        id="{{ $key }}-tab" data-toggle="pill"
                                                        href="#{{ $key }}-tab-content"
                                                        role="tab" aria-controls="ru-tab-content" aria-selected="true">
                                                    {{ $language }}
                                                </button>
                                            </li>
                                        @endforeach
                                        <div class="glider"></div>
                                    </ul>
                                    <div class="tab-content" id="custom-tabs-two-tabContent">
                                        @forelse(\App\Models\Translate::LANGUAGES_ASSOC as $key => $language)
                                            <div class="tab-pane fade @if($loop->first) active in show @endif"
                                                 id="{{ $key }}-tab-content"
                                                 role="tabpanel" aria-labelledby="{{ $key }}-tab">
                                                <div class="form-group">
                                                    <label for="meta_title-{{ $key }}">
                                                        @lang('validation.attributes.meta_title') ({{ $key }})
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('meta_title.' . $key) is-invalid @enderror"
                                                        name="meta_title[{{ $key }}]" type="text"
                                                        id="meta_title-{{ $key }}" rows="3"
                                                    >{{ isset($product) ? $product->metaTitleTranslate?->{$key} : (old('meta_title.'.$key) ?? '') }}</textarea>
                                                    @error('meta_title.' . $key)
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="meta_description-{{ $key }}">
                                                        @lang('validation.attributes.meta_description') ({{ $key }})
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('meta_description.' . $key) is-invalid @enderror"
                                                        name="meta_description[{{ $key }}]" type="text"
                                                        id="meta_description-{{ $key }}" rows="3"
                                                    >{{ isset($product) ? $product->metaDescriptionTranslate?->{$key} : (old('meta_description.'.$key) ?? '') }}</textarea>
                                                    @error('meta_description.' . $key)
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="meta_keyword-{{ $key }}">
                                                        @lang('validation.attributes.meta_keyword') ({{ $key }})
                                                    </label>
                                                    <textarea
                                                        class="form-control @error('meta_keyword.' . $key) is-invalid @enderror"
                                                        name="meta_keyword[{{ $key }}]" type="text"
                                                        id="meta_keyword-{{ $key }}" rows="3"
                                                    >{{ isset($product) ? $product->metaKeywordTranslate?->{$key} : (old('meta_keyword.'.$key) ?? '') }}</textarea>
                                                    @error('meta_keyword.' . $key)
                                                    <span class="error invalid-feedback">{{ $message }} </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @empty
                                            @lang('messages.translates_not_found')
                                        @endforelse
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('messages.save')
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @includeIf('admin._components.formTabs')
@endpush
