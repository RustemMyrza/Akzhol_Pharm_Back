<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs mb-3" id="custom-tabs-two-tab" role="tablist">
            @foreach(\App\Models\Translate::LANGUAGES_ASSOC as $key => $language)
                <li class="nav-item">
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
                        <label for="image-{{ $key }}" class="control-label">
                            @lang('validation.attributes.image_desktop_size', ['size' => 5])
                            ({{ $key }})
                        </label>
                        <div class="custom-file @error('image.'. $key) is-invalid @enderror">
                            <input class="custom-file-input" onchange="loadFile2(event, '{{ $key }}')"
                                   accept="image/*" name="image[{{ $key }}]" type="file" id="image-{{ $key }}">
                            <label class="custom-file-label" for="image">Выберите изображение</label>
                        </div>

                        @error('image.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror

                        @if(isset($banner) && $banner->imageTranslate?->{$key})
                            <img id="image-preview-{{ $key }}" class="rounded banner-image-edit"
                                 src="{{ $banner->imageUrl($banner->imageTranslate, $key) }}" alt="">
                        @else
                            <img id="image-preview-{{ $key }}" class="rounded banner-image-edit" style="display: none"
                                 alt="">
                        @endif

                        @if(isset($banner) && $banner->imageTranslate?->{$key})
                            <a href="{{ route('admin.banners.deleteImage', ['banner' => $banner, 'language' => $key, 'banner_type' => 'desktop']) }}"
                               class="btn btn-sm btn-danger">
                                @lang('messages.delete')
                            </a>
                        @endif
                    </div>
                    <div class="form-group required">
                        <label for="mobile_image-{{ $key }}" class="control-label">
                            @lang('validation.attributes.image_mobile_size', ['size' => 5])
                            ({{ $key }})
                        </label>
                        <div class="custom-file @error('mobile_image.'. $key) is-invalid @enderror">
                            <input class="custom-file-input" onchange="loadFile2(event,'mobile-{{$key}}')"
                                   accept="image/*" name="mobile_image[{{ $key }}]" type="file"
                                   id="mobile_image-{{ $key }}">
                            <label class="custom-file-label" for="mobile_image">Выберите изображение</label>
                        </div>
                        @error('mobile_image.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror

                        @if(isset($banner) && $banner->mobileImageTranslate?->{$key})
                            <img id="image-preview-mobile-{{$key}}" class="rounded banner-image-edit"
                                 src="{{ $banner->imageUrl($banner->mobileImageTranslate, $key) }}" alt="">
                        @else
                            <img id="image-preview-mobile-{{$key}}" class="rounded banner-image-edit" style="display: none" alt="">
                        @endif

                        @if(isset($banner) && $banner->mobileImageTranslate?->{$key})
                            <a href="{{ route('admin.banners.deleteImage', ['banner' => $banner, 'language' => $key, 'banner_type' => 'mobile']) }}"
                               class="btn btn-sm btn-danger">
                                @lang('messages.delete')
                            </a>
                        @endif
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
                   value="{{ isset($banner) ? $banner->position : (old('position') ?? $lastPosition) }}">
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
                    {{ isset($banner) ? ($banner->is_active == 1 ? 'checked' : '') : 'checked' }} />
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
