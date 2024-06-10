<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs mb-3" id="custom-tabs-two-tab" role="tablist">
            @foreach(\App\Models\Translate::LANGUAGES_ASSOC as $key => $language)
                <li class="nav-item @if($loop->first) @endif">
                    <button class="nav-link @if($loop->first) active @endif"
                            id="{{ $key }}-tab" data-toggle="pill" href="#{{ $key }}-tab-content"
                            role="tab" aria-controls="ru-tab-content" aria-selected="true">
                        {{ $language }}
                    </button>
                </li>
            @endforeach
            <div class="glider"></div>
        </ul>
        <div class="tab-content" id="custom-tabs-two-tabContent">
            @forelse(\App\Models\Translate::LANGUAGES_ASSOC as $key => $language)
                <div class="tab-pane fade @if($loop->first) active in show @endif" id="{{ $key }}-tab-content"
                     role="tabpanel" aria-labelledby="{{ $key }}-tab">
                    <div class="form-group required ">
                        <label for="title-{{ $key }}" class="control-label">
                            @lang('validation.attributes.title') ({{ $key }})
                        </label>
                        <input class="form-control @error('title.' . $key) is-invalid @enderror"
                               name="title[{{ $key }}]" type="text"
                               id="title-{{ $key }}"
                               value="{{ isset($category) ? $category->titleTranslate?->{$key} : (old('title.'.$key) ?? '') }}">
                        @error('title.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="form-group required ">
                        <label for="plural_title-{{ $key }}" class="control-label">
                            Множественный заголовок ({{ $key }})
                        </label>
                        <input class="form-control @error('plural_title.' . $key) is-invalid @enderror"
                               name="plural_title[{{ $key }}]" type="text"
                               id="plural_title-{{ $key }}"
                               value="{{ isset($category) ? $category->pluralTitleTranslate?->{$key} : (old('plural_title.'. $key) ?? '') }}">
                        @error('plural_title.' . $key)
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
            <label for="filters">Фильтр </label>
            <select id="filters" class="form-control select2" name="filters[]" multiple="multiple"
                    data-placeholder="Выберите фильтр" style="width: 100%;">
                @forelse($filters as $filter)
                    <option {{ isset($category) && in_array($filter->id, $categoryFilters) ? 'selected'
                            : (old('filters') && in_array($filter->id, old('filters')) ? 'selected' : '') }}
                            value="{{ $filter->id }}">
                        {{ $filter->titleTranslate?->ru}}
                    </option>
                @empty
                    <option disabled>Фильтры не найдены</option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group required">
            <label for="image" class="control-label">@lang('validation.attributes.image_size', ['size' => 4]) </label>
            <div class="custom-file @error('image') is-invalid @enderror">
                <input type="file" name="image" class="custom-file-input" id="image"
                       accept="image/*" onchange="loadFile(event)">
                <label class="custom-file-label" for="image">Выберите изображение</label>
            </div>

            @error('image')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror

            @if(isset($category) && $category->image_url)
                <img id="image-preview" class="rounded product-edit-image" src="{{ $category->image_url }}" alt="">
            @else
                <img id="image-preview" class="rounded product-edit-image" style="display: none" alt="">
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="position" class="control-label">@lang('validation.attributes.position') </label>
            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position"
                   name="position"
                   value="{{ isset($category) ? $category->position : (old('position') ?? $lastPosition) }}">
            @error('position')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group required">
            <div class="icheck-primary">
                <input type="checkbox" name="is_important" id="is_important" value="1"
                    {{ isset($category) && $category->is_important == 1? 'checked'  : (old('is_important') && old('is_important') == 1 ? 'checked' : '') }} >
                <label for="is_important">
                    Показать на главном странице товары этого каталога
                </label>
            </div>
            @error('is_important')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="checkbox">@lang('validation.attributes.status'): </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_active" value="1"
                    {{ isset($category) ? ($category->is_active == 1 ? 'checked' : '') : 'checked' }} />
                <i></i>
                <span>Активный</span>
            </label>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="checkbox2">Новинки: </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox2" class="checkbox cb cb1" type="checkbox" name="is_new" value="1"
                    {{ isset($category) ? ($category->is_new == 1 ? 'checked' : '') : 'checked' }} />
                <i></i>
                <span>Активный</span>
            </label>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                @lang('messages.save')
            </button>
        </div>
    </div>
</div>
