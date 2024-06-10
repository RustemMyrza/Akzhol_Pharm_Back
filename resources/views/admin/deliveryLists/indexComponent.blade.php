<div class="col-12">
    <h5 class="mb-3">Доставка информация</h5>
</div>

<div class="col-12">
    <div class="card-tools mb-2 mb-md-3">
        <a href="{{ route('admin.deliveryLists.create') }}"
           class="btn btn-primary btn-sm" title="@lang('messages.add')">
            <i class="fa fa-plus" aria-hidden="true"></i>
            @lang('messages.add')
        </a>
    </div>

    <div class="info-box info-card flex-column shadow-none">
        <div class="table-responsive">
            <table class="table table-hover not-styles">
                <thead class="thead">
                <tr>
                    <th>@lang('validation.attributes.title')</th>
                    <th>@lang('validation.attributes.status')</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @forelse($deliveryLists as $deliveryList)
                    <tr>
                        <td style="white-space: normal">{!! $deliveryList->descriptionTranslate?->ru !!}</td>
                        <td>
                            <label class="checkbox-label">
                                <input id="checkbox" class="checkbox cb cb1 update_is_active_2"
                                       type="checkbox" name="is_active" value="1"
                                       data-id="{{ $deliveryList->id }}"
                                        {{ $deliveryList->is_active == 1 ? 'checked' : '' }} />
                                <i></i>
                            </label>
                        </td>
                        <td>
                            <div class="card-tools">
                                <a href="{{ route('admin.deliveryLists.edit', ['deliveryList' => $deliveryList]) }}"
                                   title="@lang('messages.edit')"
                                   class="btn btn-primary btn-sm">
                                    @lang('messages.edit')
                                </a>
                                <form method="POST" class="d-inline"
                                      action="{{ route('admin.deliveryLists.destroy', ['deliveryList' => $deliveryList]) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"
                                            title="@lang('messages.delete')"
                                            onclick="return confirm('@lang('messages.confirm_deletion')')">
                                        @lang('messages.delete')
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td align="center" class="text-danger p-2" colspan="3">
                            Доставка информация не найдено
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>