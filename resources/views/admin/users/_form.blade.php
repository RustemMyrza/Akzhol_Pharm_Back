<div class="row">
    <div class="col-6">
        <div class="form-group required">
            <label for="first_name" class="control-label">@lang('validation.attributes.first_name'): </label>
            <input type="text" class="form-control" id="first_name" name="first_name" required max="150"
                   value="{{ isset($user) ? $user->first_name : (old('first_name') ?? '') }}">
            @error('first_name')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group required">
            <label for="last_name" class="control-label">@lang('validation.attributes.last_name'): </label>
            <input type="text" class="form-control" id="last_name" name="last_name" required max="150"
                   value="{{ isset($user) ? $user->last_name : (old('last_name') ?? '') }}">
            @error('last_name')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group required">
            <label for="email" class="control-label">@lang('validation.attributes.email'): </label>
            <input type="text" class="form-control" id="email" name="email" required max="150"
                   value="{{ isset($user) ? $user->email : (old('email') ?? '') }}">
            @error('email')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group ">
            <label for="phone" class="control-label">Телефон </label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                   value="{{ isset($user) ? $user->phone : (old('phone') ?? '') }}" maxlength="100" placeholder="">
            @error('phone')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group required">
            <label for="password" class="control-label">@lang('validation.attributes.password'):</label>
            <input type="password" class="form-control" id="password" name="password"
                   value="" autocomplete="off" max="150">
            @error('password')
            <span class="error invalid-feedback">{{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group required">
            <label for="role" class="control-label">@lang('messages.role'): </label>
            <select name="role" id="role" class="form-control type select2" style="width: 100%;">
                @forelse($roles as $keyRole => $role)
                    <option value="{{ $keyRole }}"
                        {{ (isset($user) && $user->roles[0]->name == $keyRole)
                            ? 'selected' : (old('role') && old('role') == $keyRole ? 'selected' : '')  }}>
                        {{ $role }}
                    </option>
                @empty
                    <option selected disabled>
                        @lang('messages.role_not_found')
                    </option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <label for="photo">Фото </label>
            <div class="custom-file @error('photo') is-invalid @enderror">
                <input type="file" name="photo" class="custom-file-input" id="photo"
                       accept="image/*" onchange="loadFile(event)">
                <label class="custom-file-label" for="photo">Выберите фото</label>
            </div>
            @error('photo')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror

            @if(isset($user))
                <img id="image-preview" class="rounded user-image-edit" src="{{ $user->photo_url }}" alt="">
            @else
                <img id="image-preview" class="rounded user-image-edit" style="display: none" alt="">
            @endif
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">
            @lang('messages.save')
        </button>
    </div>
</div>
