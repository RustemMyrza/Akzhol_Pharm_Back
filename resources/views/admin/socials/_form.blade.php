<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label for="image" class="control-label">@lang('validation.attributes.icon_size', ['size' => 2])</label>
            <div class="custom-file @error('image') is-invalid @enderror">
                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                       id="image" accept="image/*" onchange="loadFile(event)">
                <label class="custom-file-label" for="image">Выберите иконка</label>
            </div>
            @error('image')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror

            @if(isset($social))
                <img id="image-preview" class="rounded social-form-image" src="{{ $social->image_url }}"
                     alt="">
            @else
                <img id="image-preview" class="rounded social-form-image"
                     style="display: none; " alt="">
            @endif
        </div>

        <div class="form-group">
            <label for="link">@lang('validation.attributes.link')</label>
            <input class="form-control @error('link') is-invalid @enderror"
                   name="link" type="text" id="link" min="0" max="255" required
                   value="{{ isset($social) && $social->link ? $social->link : (old('link') ?? '') }}">
            @error('link')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="checkbox">@lang('validation.attributes.status'): </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_active" value="1" max="255"
                    {{ isset($social) ? ($social->is_active == 1 ? 'checked' : '') : 'checked' }} />
                <i></i>
                <span>Активный</span>
            </label>
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary">
                @lang('messages.save')
            </button>
        </div>
    </div>
</div>
