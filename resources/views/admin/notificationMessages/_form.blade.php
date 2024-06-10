<div class="row">
    <div class="col-md-12">

        <div class="form-group required ">
            <label for="title" class="control-label">
                @lang('validation.attributes.title')
            </label>
            <input class="form-control @error('title') is-invalid @enderror"
                   name="title" id="title" max="255" type="text"
                   value="{{ isset($notificationMessage) ? $notificationMessage->title : (old('title') ?? '') }}">
            @error('title')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>

        <div class="form-group required ">
            <label for="description" class="control-label">
                @lang('validation.attributes.description')
            </label>
            <textarea type="text" name="description" id="description" cols="30"
                      class="form-control ckeditor4 @error('description') is-invalid @enderror"
                      rows="15"
            >{{ isset($notificationMessage) ? $notificationMessage->description : (old('description') ?? '') }}</textarea>
            @error('description')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>

        <div class="form-group required">
            <label for="type" class="control-label"> Рубрики: </label>
            <select id="type" class="select2" name="type"
                    data-placeholder="Выберите рубрику" style="width: 100%;">
                @forelse($types as $typeKey => $type)
                    <option {{ isset($notificationMessage) && $typeKey == $notificationMessage->type ? 'selected'
                            : (old('type') && $typeKey == old('type') ? 'selected' : '') }}
                            value="{{ $typeKey }}">
                        {{ $type }}
                    </option>
                @empty
                    <option disabled>Рубрики не найдены</option>
                @endforelse
            </select>
        </div>

        <button type="submit" class="btn btn-primary mt-2">
            @lang('messages.save')
        </button>
    </div>
</div>
