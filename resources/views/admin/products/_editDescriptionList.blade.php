<div id="editDescriptionListModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" >Добавить</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editDescriptionListForm">
                    <div class="form-group required">
                        <label class="control-label">Заголовок </label>
                        <input type="text" class="form-control title" required maxlength="255">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Описание </label>
                        <input type="text" class="form-control text" maxlength="255">
                    </div>

                    <input type="hidden" class="form-control description_language">
                    <input type="hidden" class="form-control description_key">

                    <div class="form-group">
                        <label>@lang('validation.attributes.image_size', ['size' => 5]) </label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input"
                                   accept="image/*" onchange="loadFile3(event)">
                            <label class="custom-file-label">Выберите фото</label>
                        </div>

                        <img class="rounded product-edit-image" style="display: none" alt="">
                    </div>

                    <div class="buttons d-flex align-items-center justify-content-center">
                        <button type="reset"
                                class="btn btn-outline-danger">
                            @lang('messages.cancel')
                        </button>
                        <button type="submit" class="btn btn-primary ml-1">
                            Обновить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>