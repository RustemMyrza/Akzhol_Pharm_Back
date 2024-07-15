<div class="row">

    <div class="col-md-12">
        <div class="form-group">
            <label for="status" class="control-label">Статус на складе </label>
            <div class="select2-purple">
                <select name="status" id="status" class="form-control select2"
                        style="width: 100%;" required>
                    @forelse($statuses as $statusKey => $status)
                        <option {{ isset($product) && $statusKey == $product->status ? 'selected'
                                : (old('status') && old('status') == $statusKey  ? 'selected' : '') }}
                                value="{{ $statusKey }}" class="text-bold">
                            {{ $status }}
                        </option>
                    @empty
                        <option selected disabled>Статусы не найдены</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group required">
            <label for="category_id" class="control-label">Категорий </label>
            <div class="select2-purple">
                <select name="category_id" id="category_id" class="form-control select2"
                        style="width: 100%;">
                    <option value="" {{ isset($product) && is_null($product->category_id) ? 'selected' : '' }}>
                        Не указано
                    </option>

                    @forelse($categories as $category)
                        <option {{ isset($product) && $category->id == $product->category_id ? 'selected'
                                : (old('category_id') && old('category_id') == $category->id  ? 'selected' : '') }}
                                value="{{ $category->id }}" class="text-bold">
                            {{ $category->titleTranslate?->ru }}
                        </option>
                    @empty
                        <option selected disabled>Категорий не найдены</option>
                    @endforelse

                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="sub_category_id" class="control-label">Подкатегорий </label>
            <div class="select2-purple">
                <select name="sub_category_id" id="sub_category_id" class="form-control select2"
                        style="width: 100%;">
                    <option value="">Не выбрать</option>
                    @forelse($subCategories as $subCategory)
                        <option {{ isset($product) && $product->sub_category_id && $subCategory->id == $product->sub_category_id ? 'selected'
                                            : (old('sub_category_id') == $subCategory->id  ? 'selected' : '') }}
                                value="{{ $subCategory->id }}" class="text-bold">
                            {{ $subCategory->titleTranslate?->ru }}
                        </option>
                    @empty
                        <option selected disabled>Подкатегорий не найдены</option>
                    @endforelse
                </select>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="product_filter_items">Фильтр </label>
            <select id="product_filter_items" class="form-control select2" name="product_filter_items[]"
                    multiple="multiple"
                    data-placeholder="Выберите сначала категорий ..." style="width: 100%;">
                @forelse ($filters as $filter)
                    <optgroup label="{{ $filter->titleTranslate?->ru }}">
                        @forelse ($filter->filterItems as $filterItem)
                            <option value="{{ $filterItem->id }}"
                                    @if (in_array($filterItem->id, $productFilterItems)) selected @endif>
                                {{ $filterItem->titleTranslate?->ru }}</option>
                        @empty
                            Фильтр значение не найдено
                        @endforelse
                    </optgroup>
                @empty
                    Фильтры не найдены
                @endforelse
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="product_feature_items" class="control-label">Характеристики товара </label>
            <select id="product_feature_items" class="select2" name="product_feature_items[]" multiple="multiple"
                    data-placeholder="Выберите характеристики товара" style="width: 100%;">
                @forelse($features as $feature)
                    <optgroup label="{{ $feature->titleTranslate?->ru }}">
                        @if(count($feature->featureItems))
                            @foreach($feature->featureItems as $featureItem)
                                <option {{ (isset($productFeatureItems) && in_array($featureItem->id, $productFeatureItems)) ? 'selected'
                                            : (old('product_feature_items') && in_array($featureItem->id, old('product_feature_items')) ? 'selected' : '') }}
                                        value="{{ $featureItem->id }}">
                                    {{ $featureItem->titleTranslate?->ru}}
                                </option>
                            @endforeach
                        @endif
                    </optgroup>
                @empty
                    <option disabled>Характеристики товара не найден</option>
                @endforelse
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="position" class="control-label">@lang('validation.attributes.position') товара </label>
            <input type="number" class="form-control @error('position') is-invalid @enderror" id="position"
                   name="position"
                   value="{{ isset($product) ? $product->position : (old('position') ?? $lastPosition) }}">
            @error('position')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="checkbox">Акция: </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_promotional" value="1"
                        {{ isset($product) ? ($product->is_promotional == 1 ? 'checked' : '') : '' }} />
                <i></i>
                <span>Показать</span>
            </label>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="checkbox">Видимость: </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_active" value="1"
                        {{ isset($product) ? ($product->is_active == 1 ? 'checked' : '') : 'checked' }} />
                <i></i>
                <span>Показать</span>
            </label>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="checkbox2">Новинки: </label>
            <br>
            <label class="checkbox-label">
                <input id="checkbox" class="checkbox cb cb1" type="checkbox" name="is_new" value="1"
                        {{ isset($product) ? ($product->is_new == 1 ? 'checked' : '') : 'checked' }} />
                <i></i>
                <span>Активный</span>
            </label>
        </div>
    </div>
</div>
