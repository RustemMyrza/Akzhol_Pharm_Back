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
                    <div class="form-group required ">
                        <label for="title-{{ $key }}" class="control-label">
                            @lang('validation.attributes.title') ({{ $key }})
                        </label>
                        <input class="form-control @error('title.' . $key) is-invalid @enderror"
                               name="title[{{ $key }}]" type="text"
                               id="title-{{ $key }}"
                               value="{{ isset($seoPage) ? $seoPage->titleTranslate?->{$key} : (old('title.'.$key) ?? '') }}">
                        @error('title.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="meta_title-{{ $key }}">
                            @lang('validation.attributes.meta_title') ({{ $key }})
                        </label>
                        <textarea
                            class="form-control @error('meta_title.' . $key) is-invalid @enderror"
                            name="meta_title[{{ $key }}]" type="text"
                            id="meta_title-{{ $key }}" rows="3"
                        >{{ isset($seoPage) ? $seoPage->metaTitleTranslate?->{$key} : (old('meta_title.'.$key) ?? '') }}</textarea>
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
                        >{{ isset($seoPage) ? $seoPage->metaDescriptionTranslate?->{$key} : (old('meta_description.'.$key) ?? '') }}</textarea>
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
                        >{{ isset($seoPage) ? $seoPage->metaKeywordTranslate?->{$key} : (old('meta_keyword.'.$key) ?? '') }}</textarea>
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

    @if(authHasRole())
        <div class="col-md-12">
            <div class="form-group">
                <label for="page-ru">Страница</label>
                <input class="form-control @error('page') is-invalid @enderror"
                       name="page" type="text" id="page"
                       value="{{ old('page') ?? (isset($seoPage) ? $seoPage->page : '') }}">
                @error('page')
                <span class="error invalid-feedback">{{ $message }} </span>
                @enderror
            </div>
        </div>
    @endif


    <div class="col-md-12">
        <div class="form-group">
            <label for="position" class="control-label">@lang('validation.attributes.position') </label>
            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position"
                   name="position"
                   value="{{ isset($seoPage) ? $seoPage->position : (old('position') ?? $lastPosition) }}">
            @error('position')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="checkbox">@lang('validation.attributes.status'): </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_active" value="1"
                    {{ isset($seoPage) ? ($seoPage->is_active == 1 ? 'checked' : '') : 'checked' }} />
                <i></i>
                <span>Активный</span>
            </label>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-0">
            <button class="btn btn-primary" type="submit">Сохранить</button>
        </div>
    </div>
</div>
