<div class="row">
    <div class="col-12">
        <label>Тип плательщика:</label>
        <div class="d-flex flex-wrap mb-3">
            @foreach($userTypes as $userTypeKey => $userType)
                <div class="form-group mr-3 mb-0">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input trigger"
                               data-rel="{{ $userTypeKey }}" type="radio"
                               id="user_type_{{ $userTypeKey }}"
                               name="user_type" value="{{ $userTypeKey }}"
                            {{ (isset($order) && $order->user_type == $userTypeKey) ? 'checked' : (old('type') == $userTypeKey ? 'checked' : '')  }}>
                        <label for="user_type_{{ $userTypeKey }}" class="custom-control-label">
                            {{ $userType }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <label>Доставка: </label>
        <div class="d-flex flex-wrap mb-3">
            @foreach($deliveryTypes as $deliveryTypeKey => $deliveryType)
                <div class="form-group mr-3 mb-0">
                    <div class="custom-control custom-radio">
                        <input class="custom-control-input trigger-delivery"
                               data-rel="{{ $deliveryTypeKey }}" type="radio"
                               id="delivery_type_{{ $deliveryTypeKey }}"
                               name="delivery_type" value="{{ $deliveryTypeKey }}"
                            {{ (isset($order) && $order->delivery_type == $deliveryTypeKey) ? 'checked' : (old('type') == $deliveryTypeKey ? 'checked' : '')  }}>
                        <label for="delivery_type_{{ $deliveryTypeKey }}" class="custom-control-label">
                            {{ $deliveryType }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-12">
        <div class="form-group required">
            <label for="user_id" class="control-label">Пользователь: </label>
            <select name="user_id" id="user_id" class="form-control select2" style="width: 100%;">
                @forelse($users as $user)
                    <option value="{{ $user->id }}"
                        {{ (isset($order) && $order->user_id == $user->id)
                            ? 'selected' : (old('user_id') == $user->id ? 'selected' : '')  }}>
                        {{ $user->full_name }} ({{ $user->email }})
                    </option>
                @empty
                    <option selected disabled>
                        Пользователи не найдены
                    </option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="col-12 content-type content-type-0">
        <div class="row">
            <div class="col-3">
                <div class="form-group required">
                    <label for="first_name" class="control-label">@lang('validation.attributes.first_name') </label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                           name="first_name"
                           value="{{ isset($order) ? $order->first_name : (old('first_name') ?? '') }}" maxlength="255">
                    @error('first_name')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group required">
                    <label for="last_name" class="control-label">@lang('validation.attributes.last_name') </label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                           name="last_name"
                           value="{{ isset($order) ? $order->last_name : (old('last_name') ?? '') }}" maxlength="255">
                    @error('last_name')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group required">
                    <label for="email" class="control-label">@lang('validation.attributes.email') </label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                           value="{{ isset($order) ? $order->email : (old('email') ?? '') }}" maxlength="255">
                    @error('email')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-3">
                <div class="form-group required">
                    <label for="phone" class="control-label">@lang('validation.attributes.phone') </label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                           value="{{ isset($order) ? $order->phone : (old('phone') ?? '') }}" maxlength="255">
                    @error('phone')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-12">
                <div class="form-group required">
                    <label for="address" class="control-label">Адресс </label>
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                           name="address"
                           value="{{ isset($order) ? $order->address : (old('address') ?? '') }}" maxlength="255">
                    @error('address')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="message" class="control-label">Комментарий к заказу: </label>
                    <textarea type="text" class="form-control @error('message') is-invalid @enderror" id="message"
                              name="message" maxlength="5000" rows="3"
                    >{{ isset($order) ? $order->message : (old('message') ?? '') }}</textarea>
                    @error('message')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label>Cпособ оплаты: </label>
                <div class="d-flex flex-wrap mb-3">
                    @foreach($paymentMethods as $paymentMethodKey => $paymentMethod)
                        <div class="form-group mr-3 mb-0">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input"
                                       type="radio"
                                       id="payment_method_{{ $paymentMethodKey }}"
                                       name="payment_method" value="{{ $paymentMethodKey }}"
                                    {{ (isset($order) && $order->payment_method == $paymentMethodKey) ? 'checked' : (old('type') == $paymentMethodKey ? 'checked' : '')  }}>
                                <label for="payment_method_{{ $paymentMethodKey }}" class="custom-control-label">
                                    {{ $paymentMethod }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 content-type content-type-1">
        <div class="row">
            <div class="col-4">
                <div class="form-group required">
                    <label for="organization_name" class="control-label">Наименование организации </label>
                    <input type="text" class="form-control @error('organization_name') is-invalid @enderror" id="organization_name"
                           name="organization_name"
                           value="{{ isset($order) ? $order->organization_name : (old('organization_name') ?? '') }}" maxlength="255">
                    @error('organization_name')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group required">
                    <label for="organization_bin" class="control-label">БИН/ИИН </label>
                    <input type="text" class="form-control @error('organization_bin') is-invalid @enderror" id="organization_bin"
                           name="organization_bin"
                           value="{{ isset($order) ? $order->organization_bin : (old('organization_bin') ?? '') }}" maxlength="255">
                    @error('organization_bin')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group required">
                    <label for="organization_email" class="control-label">Почта </label>
                    <input type="text" class="form-control @error('organization_email') is-invalid @enderror" id="organization_email"
                           name="organization_email"
                           value="{{ isset($order) ? $order->organization_email : (old('organization_email') ?? '') }}" maxlength="255">
                    @error('organization_email')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group required">
                    <label for="organization_phone" class="control-label">Телефон </label>
                    <input type="text" class="form-control @error('organization_phone') is-invalid @enderror" id="organization_phone"
                           name="organization_phone"
                           value="{{ isset($order) ? $order->organization_phone : (old('organization_phone') ?? '') }}" maxlength="255">
                    @error('organization_phone')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group required">
                    <label for="organization_legal_address" class="control-label">Юридический адресс </label>
                    <input type="text" class="form-control @error('organization_legal_address') is-invalid @enderror" id="organization_legal_address"
                           name="organization_legal_address"
                           value="{{ isset($order) ? $order->organization_legal_address : (old('organization_legal_address') ?? '') }}" maxlength="255">
                    @error('organization_legal_address')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group required">
                    <label for="organization_current_address" class="control-label">Фактический адрессс </label>
                    <input type="text" class="form-control @error('organization_current_address') is-invalid @enderror" id="organization_current_address"
                           name="organization_current_address"
                           value="{{ isset($order) ? $order->organization_current_address : (old('organization_current_address') ?? '') }}" maxlength="255">
                    @error('organization_current_address')
                    <span class="error invalid-feedback"> {{ $message }} </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group required">
            <label for="status" class="control-label">@lang('validation.attributes.status'): </label>
            <select name="status" id="status" class="form-control type select2" style="width: 100%;">
                @forelse($statuses as $index => $status)
                    <option value="{{ $index }}"
                        {{ (isset($order) && $order->status == $index)
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
