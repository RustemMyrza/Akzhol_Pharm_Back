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
                               value="{{ isset($slider) ? $slider->titleTranslate?->{$key} : (old('title.'.$key) ?? '') }}">
                        @error('title.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="form-group required ">
                        <label for="description-{{ $key }}" class="control-label">
                            @lang('validation.attributes.description') ({{ $key }})
                        </label>
                        <textarea
                            class="form-control @error('description.' . $key) is-invalid @enderror"
                            name="description[{{ $key }}]" type="text"
                            id="description-{{ $key }}" rows="8"
                        >{{ isset($slider) ? $slider->descriptionTranslate?->{$key} : (old('description.'.$key) ?? '') }}</textarea>
                        @error('description.' . $key)
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
            <label for="position" class="control-label">@lang('validation.attributes.position') </label>
            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position"
                   name="position"
                   value="{{ isset($slider) ? $slider->position : (old('position') ?? $lastPosition) }}">
            @error('position')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group required">
            <label for="image" class="control-label">@lang('validation.attributes.image_size', ['size' => 3]) </label>
            <input class="form-control @error('image') is-invalid @enderror"
                   name="image" type="file" id="image" accept="image/*" onchange="loadFile(event)">
            @error('image')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
            @if(isset($slider))
                <img id="image-preview" class="rounded slider-edit-image" src="{{ $slider->image_url }}"
                     alt="">
            @else
                <img id="image-preview" class="rounded slider-edit-image"
                     style="display: none;" alt="">
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="checkbox">@lang('validation.attributes.status'): </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_active" value="1"
                    {{ isset($slider) ? ($slider->is_active == 1 ? 'checked' : '') : 'checked' }} />
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