function openAddDescriptionListModal(event, key) {
    $('.description_language').val(key);
    $('#addDescriptionListModal').modal('show');
}

$('#addDescriptionListForm').submit(function (event) {
    event.preventDefault();

    let productId = $('#product_id').val();

    let formData = new FormData();
    formData.append('title', $(this).find('.title').val());
    formData.append('text', $(this).find('.text').val());
    formData.append('language', $(this).find('.description_language').val());

    let imageFile = $(this).find("input[name='image']").prop('files')[0];
    if (imageFile) {
        formData.append('image', $(this).find("input[name='image']").prop('files')[0]);
    }
    $(".loader").addClass("loading");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: `/admin/products/${productId}/addDescriptionList`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: (response) => {
            $('#addDescriptionListModal').modal('hide');
            $(".loader").removeClass("loading");

            if (response && response.descriptionLists.length > 0) {
                let descriptionListHTML = response.descriptionLists.map((item, index) => `
                            <div class="col-6 col-md-6 col-lg-3">
                                <div class="description-list" data-language="${response.language}" data-key="${index}">
                                    ${item.image ? `<img src="${item.image}" alt="" class="description-list-image">` : ''}
                                    <h6 class="description-list-title">${item.title || ''}</h6>
                                    <p class="description-list-text mb-0">${item.text || ''}</p>
                                    <div class="actions">
                                        <span class="default-link edit" onclick="editDescription(event)">Изменить</span>
                                        <span class="default-link delete" onclick="deleteDescription(event)">Удалить</span>
                                    </div>
                                </div>
                            </div>`
                ).join('');

                $(this).find('img').css('display', 'none')
                $('#addDescriptionListForm')[0].reset();

                $('.description-lists-wrapper .row-' + response.language).html(descriptionListHTML);
            }
        },
        error: (err) => {
            $(".loader").removeClass("loading");
            alert(err.responseJSON.message)
        }
    });
});

$('#addDescriptionListForm [type="reset"]').click(function (e) {
    e.preventDefault();
    $(this).find('img').css('display', 'none')
    $('#addDescriptionListForm')[0].reset();

    $('#addDescriptionListModal').modal('hide');
});

function deleteDescription(e) {
    e.preventDefault();

    let productId = $('#product_id').val();
    let language = $(e.target).closest('.description-list').data('language');
    let key = $(e.target).closest('.description-list').data('key');
    $(".loader").addClass("loading");

    if (confirm("Вы уверены, что хотите удалить?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/products/${productId}/deleteDescriptionList`,
            type: 'POST',
            data: {
                language: language,
                key: key
            },
            success: function (response) {
                $(".loader").removeClass("loading");

                if (response && response.descriptionLists.length > 0) {
                    let descriptionListHTML = response.descriptionLists.map((item, index) => `
                                <div class="col-6 col-md-6 col-lg-3">
                                    <div class="description-list" data-language="${response.language}" data-key="${index}">
                                        ${item.image ? `<img src="${item.image}" alt="" class="description-list-image">` : ''}
                                        <h6 class="description-list-title">${item.title || ''}</h6>
                                        <p class="description-list-text mb-0">${item.text || ''}</p>
                                        <div class="actions">
                                            <span class="default-link edit" onclick="editDescription(event)">Изменить</span>
                                            <span class="default-link delete" onclick="deleteDescription(event)">Удалить</span>
                                        </div>
                                    </div>
                                </div>`
                    ).join('');

                    $('.description-lists-wrapper .row-' + response.language).html(descriptionListHTML);
                } else {
                    $('.description-lists-wrapper .row-' + response.language).html('');
                }
            },
            error: function (err) {
                $(".loader").removeClass("loading");
                alert(err.responseJSON.message)
            }
        });

        return 1;
    }

    return 0;
}

function editDescription(e) {
    e.preventDefault();

    let language = $(e.target).closest('.description-list').data('language');
    let key = $(e.target).closest('.description-list').data('key');
    let title = $(e.target).closest('.description-list').find('.description-list-title').text();
    let text = $(e.target).closest('.description-list').find('.description-list-text').text();
    let image = $(e.target).closest('.description-list').find('img');

    $('#editDescriptionListForm').find('.title').val(title)
    $('#editDescriptionListForm').find('.text').val(text)
    $('#editDescriptionListForm').find('.description_language').val(language)
    $('#editDescriptionListForm').find('.description_key').val(key)

    if (image.length > 0) {
        $('#editDescriptionListForm').find('img').attr('src', image.attr('src'))
        $('#editDescriptionListForm').find('img').css('display', 'block')
    }

    $('#editDescriptionListModal').modal('show');

    return 1;
}

$('#editDescriptionListForm').submit(function (event) {
    event.preventDefault();

    let productId = $('#product_id').val();

    let formData = new FormData();
    formData.append('title', $(this).find('.title').val());
    formData.append('text', $(this).find('.text').val());
    formData.append('language', $(this).find('.description_language').val());
    formData.append('key', $(this).find('.description_key').val());

    let imageFile = $(this).find("input[name='image']").prop('files')[0];
    if (imageFile) {
        formData.append('image', $(this).find("input[name='image']").prop('files')[0]);
    }
    $(".loader").addClass("loading");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: `/admin/products/${productId}/updateDescriptionList`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: (response) => {
            $('#editDescriptionListModal').modal('hide');
            $(".loader").removeClass("loading");

            if (response && response.descriptionLists.length > 0) {
                let descriptionListHTML = response.descriptionLists.map((item, index) => `
                            <div class="col-6 col-md-6 col-lg-3">
                                <div class="description-list" data-language="${response.language}" data-key="${index}">
                                    ${item.image ? `<img src="${item.image}" alt="" class="description-list-image">` : ''}
                                    <h6 class="description-list-title">${item.title || ''}</h6>
                                    <p class="description-list-text mb-0">${item.text || ''}</p>
                                    <div class="actions">
                                        <span class="default-link edit" onclick="editDescription(event)">Изменить</span>
                                        <span class="default-link delete" onclick="deleteDescription(event)">Удалить</span>
                                    </div>
                                </div>
                            </div>`
                ).join('');

                $(this).find('img').css('display', 'none')
                $('#editDescriptionListForm')[0].reset();

                $('.description-lists-wrapper .row-' + response.language).html(descriptionListHTML);
            }
        },
        error: (err) => {
            $(".loader").removeClass("loading");
            alert(err.responseJSON.message)
        }
    });
});

$('#editDescriptionListForm [type="reset"]').click(function (e) {
    e.preventDefault();
    $(this).find('img').css('display', 'none')
    $('#editDescriptionListForm')[0].reset();

    $('#editDescriptionListModal').modal('hide');
});
