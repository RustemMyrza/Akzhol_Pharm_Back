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
                    <div class="form-group required ">
                        <label for="title-{{ $key }}" class="control-label">
                            Название ({{ str($key)->upper() }})
                        </label>
                        <input class="form-control @error('title.' . $key) is-invalid @enderror"
                               name="title[{{ $key }}]" type="text"
                               id="title-{{ $key }}"
                               value="{{ isset($product) ? $product->titleTranslate?->{$key} : (old('title.'.$key) ?? '') }}">
                        @error('title.' . $key)
                        <span class="error invalid-feedback">{{ $message }} </span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label for="description-{{ $key }}" class="control-label"
                               data-toggle="collapse" href="#collapseDescription{{ $key }}" role="button"
                               aria-expanded="false" aria-controls="collapseDescription{{ $key }}">
                            @lang('validation.attributes.description') ({{ str($key)->upper() }})
                            <span class="open-icon">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </span>
                        </label>
                        <div class="collapse" id="collapseDescription{{ $key }}">
                            <textarea type="text" name="description[{{ $key }}]" id="description-{{ $key }}" cols="30"
                                      class="form-control ckeditor4 @error('description.' . $key) is-invalid @enderror"
                                      rows="15"
                            >{{ isset($product) ? $product->descriptionTranslate?->{$key} : (old('description.'.$key) ?? '') }}</textarea>
                            @error('description.' . $key)
                            <span class="error invalid-feedback">{{ $message }} </span>
                            @enderror

{{--                            @if(isset($product))--}}
{{--                                <label class="control-label mt-2 mb-2">--}}
{{--                                    Описание список:--}}
{{--                                </label>--}}
{{--                                <div class="description-lists-wrapper">--}}
{{--                                    <div class="row row-{{$key}}">--}}
{{--                                        @if(isset($product->description_lists[$key]))--}}
{{--                                            @foreach($product->description_lists[$key] as $keyDescriptionList => $descriptionList)--}}
{{--                                                <div class="col-6 col-md-6 col-lg-3">--}}
{{--                                                    <div class="description-list" data-language="{{$key}}"--}}
{{--                                                         data-key="{{ $keyDescriptionList }}">--}}
{{--                                                        @if($descriptionList['image'])--}}
{{--                                                            <img src="{{ $product->imagesUrl($descriptionList['image']) }}"--}}
{{--                                                                 alt="" class="description-list-image">--}}
{{--                                                        @endif--}}
{{--                                                        <h6 class="description-list-title">{{ $descriptionList['title'] }}</h6>--}}
{{--                                                        <p class="description-list-text mb-0">{{ $descriptionList['text'] }}</p>--}}
{{--                                                        <div class="actions">--}}
{{--                                                            <span class="default-link edit"--}}
{{--                                                                  onclick="editDescription(event)">Изменить</span>--}}
{{--                                                            <span class="default-link delete"--}}
{{--                                                                  onclick="deleteDescription(event)">Удалить</span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-12">--}}
{{--                                            <div class="description-list add"--}}
{{--                                                 onclick="openAddDescriptionListModal(event, '{{ $key }}')">--}}
{{--                                                <i class="fa fa-plus" aria-hidden="true"></i>--}}
{{--                                                Добавить--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                        </div>
                    </div>

                    <hr class="mt-2 mb-2">

                    <div class="form-group mb-2">
                        <label for="instruction-{{ $key }}" class="control-label"
                               data-toggle="collapse" href="#collapseInstruction{{ $key }}" role="button"
                               aria-expanded="true" aria-controls="collapseInstruction{{ $key }}">
                            Подробнее ({{ str($key)->upper() }})
                            <span class="open-icon">
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </span>
                        </label>
                        <div class="collapse show" id="collapseInstruction{{ $key }}">
                            <textarea type="text" name="instruction[{{ $key }}]" id="instruction-{{ $key }}" cols="30"
                                      class="form-control ckeditor4 @error('instruction.' . $key) is-invalid @enderror"
                                      rows="15"
                            >{{ isset($product) ? $product->instructionTranslate?->{$key} : (old('instruction.'.$key) ?? '') }}</textarea>
                            @error('instruction.' . $key)
                            <span class="error invalid-feedback">{{ $message }} </span>
                            @enderror

{{--                            @if(isset($product))--}}
{{--                                <label class="control-label mt-2 mb-2">--}}
{{--                                    Подробнее список:--}}
{{--                                </label>--}}
{{--                                <div class="instruction-lists-wrapper">--}}
{{--                                    <div class="row row-{{$key}}">--}}
{{--                                        @if(isset($product->instruction_lists[$key]))--}}
{{--                                            @foreach($product->instruction_lists[$key] as $keyInstructionList => $instructionList)--}}
{{--                                                <div class="col-6 col-md-6 col-lg-3">--}}
{{--                                                    <div class="instruction-list" data-language="{{$key}}"--}}
{{--                                                         data-key="{{ $keyInstructionList }}">--}}
{{--                                                        <h6 class="instruction-list-title">{{ $instructionList['title'] }}</h6>--}}
{{--                                                        <p class="instruction-list-text mb-0">{{ $instructionList['text'] }}</p>--}}
{{--                                                        <div class="actions">--}}
{{--                                                            <span class="default-link edit"--}}
{{--                                                                  onclick="editInstruction(event)">Изменить</span>--}}
{{--                                                            <span class="default-link delete"--}}
{{--                                                                  onclick="deleteInstruction(event)">Удалить</span>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforeach--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-12">--}}
{{--                                            <div class="instruction-list add"--}}
{{--                                                 onclick="openAddInstructionListModal(event, '{{ $key }}')">--}}
{{--                                                <i class="fa fa-plus" aria-hidden="true"></i>--}}
{{--                                                Добавить--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                        </div>
                    </div>

{{--                    <hr class="mt-2 mb-2">--}}

{{--                    <div class="form-group mb-2">--}}
{{--                        <label for="specification_table_{{ $key }}" class="control-label"--}}
{{--                               data-toggle="collapse" href="#collapseSpecificationTable{{ $key }}" role="button"--}}
{{--                               aria-expanded="false" aria-controls="collapseSpecificationTable{{ $key }}">--}}
{{--                            Технические характеристики ({{ str($key)->upper() }})--}}
{{--                            <span class="open-icon">--}}
{{--                                <i class="fa fa-angle-right" aria-hidden="true"></i>--}}
{{--                            </span>--}}
{{--                        </label>--}}
{{--                        <div class="collapse" id="collapseSpecificationTable{{ $key }}">--}}
{{--                            <textarea type="text" name="specification_table[{{ $key }}]" id="specification_table_{{ $key }}" cols="30"--}}
{{--                                      class="form-control ckeditor4 @error('specification_table.' . $key) is-invalid @enderror"--}}
{{--                                      rows="15"--}}
{{--                            >{{ isset($product) ? $product->specificationTableTranslate?->{$key} : (old('specification_table.'. $key) ?? '') }}</textarea>--}}
{{--                            @error('specification_table.' . $key)--}}
{{--                            <span class="error invalid-feedback">{{ $message }} </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <hr class="mt-2 mb-2">--}}

{{--                    <div class="form-group mb-2">--}}
{{--                        <label for="collapsible_diagram-{{ $key }}" class="control-label"--}}
{{--                               data-toggle="collapse" href="#collapseCollapsibleDiagram{{ $key }}" role="button"--}}
{{--                               aria-expanded="false" aria-controls="collapseCollapsibleDiagram{{ $key }}">--}}
{{--                            Разборная схема ({{ str($key)->upper() }})--}}
{{--                            <span class="open-icon">--}}
{{--                                <i class="fa fa-angle-right" aria-hidden="true"></i>--}}
{{--                            </span>--}}
{{--                        </label>--}}
{{--                        <div class="collapse" id="collapseCollapsibleDiagram{{ $key }}">--}}
{{--                            <div class="form-group mt-2">--}}
{{--                                <label for="collapsible_diagram_{{ $key }}" class="control-label">--}}
{{--                                    Изображение (Макс: 10 Мб)--}}
{{--                                </label>--}}
{{--                                <div class="custom-file @error('collapsible_diagram.'. $key .'.image') is-invalid @enderror">--}}
{{--                                    <input type="file" class="custom-file-input"--}}
{{--                                           id="collapsible_diagram_{{ $key }}"--}}
{{--                                           name="collapsible_diagram[{{ $key }}][image]"--}}
{{--                                           accept="image/*" onchange="loadFile3(event)">--}}
{{--                                    <label class="custom-file-label" for="collapsible_diagram_{{ $key }}">--}}
{{--                                        Выберите изображение--}}
{{--                                    </label>--}}
{{--                                </div>--}}

{{--                                @error('collapsible_diagram.' . $key . '.image')--}}
{{--                                <span class="error invalid-feedback">{{ $message }}</span>--}}
{{--                                @enderror--}}

{{--                                @if(isset($product, $product->collapsible_diagram[$key]) && !is_null($product->collapsible_diagram[$key]['image']))--}}
{{--                                    <img class="rounded product-edit-image"--}}
{{--                                         src="{{ $product->imagesUrl($product->collapsible_diagram[$key]['image']) }}"--}}
{{--                                         alt="">--}}
{{--                                    <button type="button"--}}
{{--                                            data-id="{{ $product->id }}"--}}
{{--                                            data-name="collapsible_diagram"--}}
{{--                                            data-language="{{ $key }}"--}}
{{--                                            class="btn btn-sm btn-outline-danger d-inline ml-2 delete-image">--}}
{{--                                        @lang('messages.delete')--}}
{{--                                    </button>--}}
{{--                                @else--}}
{{--                                    <img class="rounded product-edit-image" style="display: none" alt="">--}}
{{--                                @endif--}}
{{--                            </div>--}}

{{--                            <label class="control-label mt-0 mb-2">--}}
{{--                                Таблица:--}}
{{--                            </label>--}}
{{--                            <textarea type="text" name="collapsible_diagram[{{ $key }}][table]"--}}
{{--                                      id="collapsible_diagram-{{ $key }}" cols="30"--}}
{{--                                      class="form-control ckeditor4 @error('collapsible_diagram.' . $key .'.table') is-invalid @enderror"--}}
{{--                                      rows="15"--}}
{{--                            >{{ isset($product, $product->collapsible_diagram[$key]) ? $product->collapsible_diagram[$key]['table'] : (old('collapsible_diagram.'. $key . '.table') ?? '') }}</textarea>--}}
{{--                            @error('collapsible_diagram.' . $key . '.table')--}}
{{--                            <span class="error invalid-feedback">{{ $message }} </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
            @empty
                @lang('messages.translates_not_found')
            @endforelse
        </div>
    </div>

    <hr>

    <div class="form-group required ">
        <label for="youtube_link" class="control-label">
            Ссылка на видео YouTube
        </label>
        <input class="form-control @error('youtube_link') is-invalid @enderror"
                name="youtube_link" type="text"
                id="youtube_link"
                value="{{ isset($product) ? $product->youtube_link : '' }}">
        @error('youtube_link')
        <span class="error invalid-feedback">{{ $message }} </span>
        @enderror
    </div>

    <div class="col-6 col-md-6 col-lg-4">
        <div class="form-group required">
            <label for="vendor_code" class="control-label">Код товара </label>
            <input type="text" class="form-control @error('vendor_code') is-invalid @enderror" id="vendor_code"
                   name="vendor_code" required
                   value="{{ isset($product) ? $product->vendor_code : (old('vendor_code') ?? '') }}">
            @error('vendor_code')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-4">
        <div class="form-group required">
            <label for="price" class="control-label">Цена , ₸ </label>
            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                   name="price"
                   value="{{ isset($product) ? $product->price : (old('price') ?? 0) }}">
            @error('price')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    <div class="col-6 col-md-6 col-lg-4">
        <div class="form-group">
            <label for="discount" class="control-label">Скидка, (0-100%) </label>
            <input type="number" class="form-control @error('discount') is-invalid @enderror" id="discount"
                   name="discount" min="0" max="100"
                   value="{{ isset($product) ? $product->discount : (old('discount') ?? 0) }}">
            @error('discount')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror
        </div>
    </div>

    {{--    <div class="col-md-4">--}}
    {{--        <div class="form-group">--}}
    {{--            <label for="bulk_price" class="control-label">Цена оптом, ₸ </label>--}}
    {{--            <input type="number" class="form-control @error('bulk_price') is-invalid @enderror" id="bulk_price"--}}
    {{--                   name="bulk_price"--}}
    {{--                   value="{{ isset($product) ? $product->bulk_price : (old('bulk_price') ?? 0) }}">--}}
    {{--            @error('bulk_price')--}}
    {{--            <span class="error invalid-feedback"> {{ $message }} </span>--}}
    {{--            @enderror--}}
    {{--        </div>--}}
    {{--    </div>--}}

    {{--    <div class="col-md-4">--}}
    {{--        <div class="form-group">--}}
    {{--            <label for="stock_quantity" class="control-label">Количество на складе </label>--}}
    {{--            <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity"--}}
    {{--                   name="stock_quantity"--}}
    {{--                   value="{{ isset($product) ? $product->stock_quantity : (old('stock_quantity') ?? 0) }}">--}}
    {{--            @error('stock_quantity')--}}
    {{--            <span class="error invalid-feedback"> {{ $message }} </span>--}}
    {{--            @enderror--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="col-md-6">
        <div class="form-group required">
            <label for="image" class="control-label">Главная изображение (Макс: 5 Мб) </label>
            <div class="custom-file @error('image') is-invalid @enderror">
                <input type="file" name="image" class="custom-file-input" id="image"
                       accept="image/*" onchange="loadFile3(event)">
                <label class="custom-file-label" for="image">Выберите изображение</label>
            </div>

            @error('image')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror

            @if(isset($product) && $product->image_url)
                <img class="rounded product-edit-image" src="{{ $product->image_url }}" alt="">
            @else
                <img class="rounded product-edit-image" style="display: none" alt="">
            @endif
        </div>
    </div>

{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <label for="size_image" class="control-label">Основные размеры (Макс: 10 Мб) </label>--}}
{{--            <div class="custom-file @error('size_image') is-invalid @enderror">--}}
{{--                <input type="file" name="size_image" class="custom-file-input" id="size_image"--}}
{{--                       accept="image/*" onchange="loadFile3(event)">--}}
{{--                <label class="custom-file-label" for="size_image">Выберите изображение</label>--}}
{{--            </div>--}}

{{--            @error('size_image')--}}
{{--            <span class="error invalid-feedback"> {{ $message }} </span>--}}
{{--            @enderror--}}

{{--            @if(isset($product) && $product->size_image_url)--}}
{{--                <img class="rounded product-edit-image" src="{{ $product->size_image_url }}"--}}
{{--                     alt="">--}}
{{--                <button type="button"--}}
{{--                        data-id="{{ $product->id }}"--}}
{{--                        data-name="size_image"--}}
{{--                        class="btn btn-sm btn-outline-danger d-inline ml-2 delete-image">--}}
{{--                    @lang('messages.delete')--}}
{{--                </button>--}}
{{--            @else--}}
{{--                <img class="rounded product-edit-image" style="display: none" alt="">--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="col-md-6">--}}
{{--        <div class="form-group">--}}
{{--            <label for="installation_image" class="control-label">Схема установки (Макс: 10 Мб) </label>--}}
{{--            <div class="custom-file @error('installation_image') is-invalid @enderror">--}}
{{--                <input type="file" name="installation_image" class="custom-file-input" id="installation_image"--}}
{{--                       accept="image/*" onchange="loadFile3(event)">--}}
{{--                <label class="custom-file-label" for="installation_image">Выберите изображение</label>--}}
{{--            </div>--}}

{{--            @error('installation_image')--}}
{{--            <span class="error invalid-feedback"> {{ $message }} </span>--}}
{{--            @enderror--}}

{{--            @if(isset($product) && $product->installation_image_url)--}}
{{--                <img class="rounded product-edit-image" src="{{ $product->installation_image_url }}"--}}
{{--                     alt="">--}}
{{--                <button type="button"--}}
{{--                        data-id="{{ $product->id }}"--}}
{{--                        data-name="installation_image"--}}
{{--                        class="btn btn-sm btn-outline-danger d-inline ml-2 delete-image">--}}
{{--                    @lang('messages.delete')--}}
{{--                </button>--}}
{{--            @else--}}
{{--                <img class="rounded product-edit-image" style="display: none" alt="">--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}

    <div class="col-md-6">
        <div class="form-group">
            <label for="document" class="control-label">Инструкция (Макс: 20 Мб) </label>
            <div class="custom-file @error('document') is-invalid @enderror">
                <input type="file" name="document" class="custom-file-input" id="document"
                       accept=".xlsx,.xls,.doc,.docx,.ppt,.pptx,.pdf">
                <label class="custom-file-label" for="document">Выберите инструкция</label>
            </div>

            @error('document')
            <span class="error invalid-feedback"> {{ $message }} </span>
            @enderror

            @if(isset($product) && $product->document_url)
                <div class="mt-3">
                    <a class="mr-3" download href="{{ $product->document_url }}">
                        Скачать документ
                    </a>
                    <button type="button" data-product-id="{{ $product->id }}"
                            class="btn btn-sm btn-outline-danger d-inline ml-2 delete-document">
                        @lang('messages.delete')
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{--    <div class="col-md-6 d-none">--}}
    {{--        <div class="form-group">--}}
    {{--            <label for="checkbox2">Новинки: </label>--}}
    {{--            <br>--}}
    {{--            <label class="checkbox-label">--}}
    {{--                <input id="checkbox2" class="checkbox cb cb1" type="checkbox" name="is_new" value="1"--}}
    {{--                        {{ isset($product) ? ($product->is_new == 1 ? 'checked' : '') : 'checked' }} />--}}
    {{--                <i></i>--}}
    {{--                <span>Активный</span>--}}
    {{--            </label>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>
