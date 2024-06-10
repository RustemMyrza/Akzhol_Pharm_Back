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
                        <label for="file-{{ $key }}" class="control-label">
                            @lang('messages.document')
                            ({{ $key }}) </label>
                        <div class="custom-file @error('file.'. $key) is-invalid @enderror">
                            <input  class="custom-file-input"
                                   accept=".doc,.docx,.pdf"  name="file[{{ $key }}]" type="file" id="file-{{ $key }}">
                            <label class="custom-file-label" for="photo">Выберите документ</label>
                        </div>
                        @error('file.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>
                    @if(isset($agreement) && $agreement->fileTranslate?->{$key})
                        <a class="mt-4 mr-3" download href="{{ $agreement->fileUrl($agreement->fileTranslate, $key) }}">
                            @lang('messages.download') ({{ $key }})
                        </a>
                        <a href="{{ route('admin.agreements.deleteFile', ['agreement' => $agreement, 'language' => $key]) }}"
                           class="btn btn-sm btn-danger">
                            @lang('messages.delete')
                        </a>
                    @endif
                </div>
            @empty
                @lang('messages.translates_not_found')
            @endforelse
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group required">
            <label for="type" class="control-label"> @lang('validation.attributes.type') </label>
            <div class="select2-purple">
                <select name="type" id="type" class="form-control select2" style="width: 100%;">
                    @forelse($types as $typeKey => $type)
                        <option
                            {{ isset($agreement) && $agreement->type == $typeKey ? 'selected' : (old('type') == $typeKey ? 'selected' : '') }}
                            value="{{ $typeKey }}">
                            {{ $type }}
                        </option>
                    @empty
                        @lang('messages.types_not_found')
                    @endforelse
                </select>
            </div>
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
