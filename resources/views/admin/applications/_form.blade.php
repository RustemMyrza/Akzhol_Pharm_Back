<div class="row">
    <div class="col-12">
        <div class="form-group required">
            <label for="name" class="control-label">@lang('validation.attributes.name') </label>
            <input type="text" class="form-control" id="name" name="name" max="150" required
                   value="{{ isset($application) ? $application->name : (old('name') ?? '') }}">
            @error('name')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label for="phone" class="control-label">Телефон </label>
            <input type="text" class="form-control phone @error('phone') is-invalid @enderror" id="phone" name="phone"
                   value="{{ isset($application) ? $application->phone : (old('phone') ?? '') }}" maxlength="255">
            @error('phone')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label for="email" class="control-label">@lang('validation.attributes.email') </label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                   value="{{ isset($application) ? $application->email : (old('email') ?? '') }}" maxlength="255">
            @error('email')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label for="message" class="control-label">Сообщение </label>
            <textarea type="text" class="form-control @error('message') is-invalid @enderror" id="message"
                      name="message"
                      maxlength="5000" rows="3"
            >{{ isset($application) ? $application->message : (old('message') ?? '') }}</textarea>
            @error('message')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group required">
            <label for="status" class="control-label">@lang('validation.attributes.status'): </label>
            <select name="status" id="status" class="form-control type select2" style="width: 100%;">
                @forelse($statuses as $index => $status)
                    <option value="{{ $index }}"
                        {{ (isset($application) && $application->status == $index)
                            ? 'selected' : (old('status') && old('status') == $index ? 'selected' : '')  }}>
                        {{ $status }}
                    </option>
                @empty
                    <option selected disabled>
                        Статусы не найдены
                    </option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">
            @lang('messages.save')
        </button>
    </div>
</div>
