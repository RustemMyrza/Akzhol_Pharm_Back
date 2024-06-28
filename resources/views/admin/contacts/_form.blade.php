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
         <div class="form-group required">
            <label for="title[{{$key}}]" class="control-label">
                @lang('validation.attributes.title') ({{ $key }})
            </label>
            <input class="form-control @error('title.' . $key) is-invalid @enderror" name="title[{{$key}}]" type="text"
                id="title-{{$key}}" value="{{ isset($contents) ? $contents->titleTranslate->$key : '' }}">
            @error('title.' . $key)
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
        <div class="form-group required">
            <label for="description[{{$key}}]" class="control-label">
                @lang('validation.attributes.description') ({{ $key }})
            </label>
                <textarea rows="4"
                class="form-control @error('description.' . $key) is-invalid @enderror"
                name="description[{{$key}}]" type="text" id="description-{{$key}}" maxlength="5000"
                >{{ isset($contents) ? $contents->descriptionTranslate->$key : '' }}</textarea>
                @error('description.' . $key)
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
        <div class="form-group required ">
            <label for="address-{{ $key }}" class="control-label">
                @lang('validation.attributes.address') ({{ $key }})
            </label>
            <input class="form-control @error('address.' . $key) is-invalid @enderror"
                   name="address[{{ $key }}]" type="text"
                   id="address-{{ $key }}"
                   value="{{ isset($contact) ? $contact->addressTranslate?->{$key} : (old('address.' . $key) ?? '') }}">
            @error('address.' . $key)
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
        <div class="form-group required ">
            <label for="work_time-{{ $key }}" class="control-label">
                @lang('validation.attributes.work_time') ({{ $key }})
            </label>
            <textarea
                class="form-control @error('work_time.' . $key) is-invalid @enderror"
                name="work_time[{{ $key }}]" type="text"
                id="work_time-{{ $key }}"
            >{{ isset($contact) ? $contact->workTimeTranslate?->{$key} : (old('work_time.' . $key) ?? '') }}</textarea>
            @error('work_time.' . $key)
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>
@empty
    @lang('messages.translates_not_found')
@endforelse

        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group required">
            <label for="email" class="control-label">
                @lang('validation.attributes.email')
            </label>
            <input class="form-control @error('email') is-invalid @enderror" name="email" type="email"
                   id="email" value="{{ old('email') ?? (isset($contact) ? $contact->email : '') }}"
                   required>
            @error('email')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group required ">
            <label for="phone" class="control-label">
                @lang('validation.attributes.phone'):
            </label>
            <input class="form-control @error('phone') is-invalid @enderror" name="phone" type="text"
                   id="phone" value="{{ old('phone') ?? (isset($contact) ? $contact->phone : '') }}"
                   required>
            @error('phone')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="phone_2" class="control-label">
                @lang('validation.attributes.phone') (Whatsapp):
            </label>
            <input class="form-control @error('phone_2') is-invalid @enderror" name="phone_2" type="text"
                   id="phone_2" value="{{ old('phone_2') ?? (isset($contact) ? $contact->phone_2 : '') }}">
            @error('phone_2')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="map_link" class="control-label">Ссылка для схема проезда</label>
                <textarea rows="4"
                    class="form-control @error('map_link') is-invalid @enderror"
                    name="map_link" type="text" id="map_link" maxlength="5000"
                >{{ isset($contact) ? $contact->map_link : (old('map_link') ?? '') }}</textarea>
                @error('map_link')
                <span class="error invalid-feedback">{{ $message }} </span>
                @enderror
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
