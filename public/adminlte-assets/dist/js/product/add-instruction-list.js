function openAddInstructionListModal(event, key) {
    $('.instruction_language').val(key);
    $('#addInstructionListModal').modal('show');
}

$('#addInstructionListForm').submit(function (event) {
    event.preventDefault();

    let productId = $('#product_id').val();

    let formData = new FormData();
    formData.append('title', $(this).find('.title').val());
    formData.append('text', $(this).find('.text').val());
    formData.append('language', $(this).find('.instruction_language').val());

    $(".loader").addClass("loading");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: `/admin/products/${productId}/addInstructionList`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: (response) => {
            $('#addInstructionListModal').modal('hide');
            $(".loader").removeClass("loading");

            if (response && response.instructionLists.length > 0) {
                let instructionListHTML = response.instructionLists.map((item, index) => `
                            <div class="col-6 col-md-6 col-lg-3">
                                <div class="instruction-list" data-language="${response.language}" data-key="${index}">
                                    <h6 class="instruction-list-title">${item.title || ''}</h6>
                                    <p class="instruction-list-text mb-0">${item.text || ''}</p>
                                    <div class="actions">
                                        <span class="default-link edit" onclick="editInstruction(event)">Изменить</span>
                                        <span class="default-link delete" onclick="deleteInstruction(event)">Удалить</span>
                                    </div>
                                </div>
                            </div>`
                ).join('');

                $('#addInstructionListForm')[0].reset();

                $('.instruction-lists-wrapper .row-' + response.language).html(instructionListHTML);
            }
        },
        error: (err) => {
            $(".loader").removeClass("loading");
            alert(err.responseJSON.message)
        }
    });
});

$('#addInstructionListForm [type="reset"]').click(function (e) {
    e.preventDefault();
    $('#addInstructionListForm')[0].reset();

    $('#addInstructionListModal').modal('hide');
});

function deleteInstruction(e) {
    e.preventDefault();

    let productId = $('#product_id').val();
    let language = $(e.target).closest('.instruction-list').data('language');
    let key = $(e.target).closest('.instruction-list').data('key');
    $(".loader").addClass("loading");

    if (confirm("Вы уверены, что хотите удалить?")) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `/admin/products/${productId}/deleteInstructionList`,
            type: 'POST',
            data: {
                language: language,
                key: key
            },
            success: function (response) {
                $(".loader").removeClass("loading");

                if (response && response.instructionLists.length > 0) {
                    let instructionListHTML = response.instructionLists.map((item, index) => `
                                <div class="col-6 col-md-6 col-lg-3">
                                    <div class="instruction-list" data-language="${response.language}" data-key="${index}">
                                        <h6 class="instruction-list-title">${item.title || ''}</h6>
                                        <p class="instruction-list-text mb-0">${item.text || ''}</p>
                                        <div class="actions">
                                            <span class="default-link edit" onclick="editInstruction(event)">Изменить</span>
                                            <span class="default-link delete" onclick="deleteInstruction(event)">Удалить</span>
                                        </div>
                                    </div>
                                </div>`
                    ).join('');

                    $('.instruction-lists-wrapper .row-' + response.language).html(instructionListHTML);
                } else {
                    $('.instruction-lists-wrapper .row-' + response.language).html('');
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

function editInstruction(e) {
    e.preventDefault();

    let language = $(e.target).closest('.instruction-list').data('language');
    let key = $(e.target).closest('.instruction-list').data('key');
    let title = $(e.target).closest('.instruction-list').find('.instruction-list-title').text();
    let text = $(e.target).closest('.instruction-list').find('.instruction-list-text').text();

    $('#editInstructionListForm').find('.title').val(title)
    $('#editInstructionListForm').find('.text').val(text)
    $('#editInstructionListForm').find('.instruction_language').val(language)
    $('#editInstructionListForm').find('.instruction_key').val(key)

    $('#editInstructionListModal').modal('show');

    return 1;
}

$('#editInstructionListForm').submit(function (event) {
    event.preventDefault();

    let productId = $('#product_id').val();

    let formData = new FormData();
    formData.append('title', $(this).find('.title').val());
    formData.append('text', $(this).find('.text').val());
    formData.append('language', $(this).find('.instruction_language').val());
    formData.append('key', $(this).find('.instruction_key').val());

    $(".loader").addClass("loading");

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: `/admin/products/${productId}/updateInstructionList`,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: (response) => {
            $('#editInstructionListModal').modal('hide');
            $(".loader").removeClass("loading");

            if (response && response.instructionLists.length > 0) {
                let instructionListHTML = response.instructionLists.map((item, index) => `
                            <div class="col-6 col-md-6 col-lg-3">
                                <div class="instruction-list" data-language="${response.language}" data-key="${index}">
                                    <h6 class="instruction-list-title">${item.title || ''}</h6>
                                    <p class="instruction-list-text mb-0">${item.text || ''}</p>
                                    <div class="actions">
                                        <span class="default-link edit" onclick="editInstruction(event)">Изменить</span>
                                        <span class="default-link delete" onclick="deleteInstruction(event)">Удалить</span>
                                    </div>
                                </div>
                            </div>`
                ).join('');

                $('#editInstructionListForm')[0].reset();

                $('.instruction-lists-wrapper .row-' + response.language).html(instructionListHTML);
            }
        },
        error: (err) => {
            $(".loader").removeClass("loading");
            alert(err.responseJSON.message)
        }
    });
});

$('#editInstructionListForm [type="reset"]').click(function (e) {
    e.preventDefault();
    $('#editInstructionListForm')[0].reset();

    $('#editInstructionListModal').modal('hide');
});
