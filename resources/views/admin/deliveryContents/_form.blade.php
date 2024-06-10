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
                    <div class="form-group">
                        <label for="description-{{ $key }}" class="control-label">
                            @lang('validation.attributes.description') ({{ $key }})
                        </label>
                        <textarea type="text" name="description[{{ $key }}]" id="description-{{ $key }}" cols="30"
                                  class="form-control ckeditor4 @error('description.' . $key) is-invalid @enderror"
                                  rows="15"
                        >{{ isset($deliveryContent) ? $deliveryContent->descriptionTranslate?->{$key} : (old('description.'.$key) ?? '') }}</textarea>
                        @error('description.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content-{{ $key }}" class="control-label">
                            @lang('validation.attributes.content') ({{ $key }})
                        </label>
                        <textarea type="text" name="content[{{ $key }}]" id="content-{{ $key }}" cols="30"
                                  class="form-control ckeditor4 @error('content.' . $key) is-invalid @enderror"
                                  rows="15"
                        >{{ isset($deliveryContent) ? $deliveryContent->contentTranslate?->{$key} : (old('content.'.$key) ?? '') }}</textarea>
                        @error('content.' . $key)
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
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                @lang('messages.save')
            </button>
        </div>
    </div>
</div>
