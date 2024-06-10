$(document).ready(function () {
    $('.checkbox').change(function () {
        updateButtonLabel($(this));
    }).change();

    function updateButtonLabel(checkbox) {
        const isChecked = checkbox.is(':checked');
        const buttonLabel = isChecked ? 'Показать' : 'Не показать';

        const span = checkbox.closest('.form-group').find('span');
        span.text(buttonLabel);
    }
});

$('#category_id').change(function () {
    let categoryId = $('#category_id :selected').val();

    $.ajax({
        method: "GET",
        url: `/admin/get-filters?category_id=${categoryId}`,
        success: (response) => {
            console.log(response)
            $('#product_filter_items').html(response);
            $('#product_filter_items').select2();
        },
        error: (error) => {
            console.log(error);
        }
    })

    $.ajax({
        method: "GET",
        url: `/admin/get-subCategories?category_id=${categoryId}`,
        success: (response) => {
            $('#sub_category_id').html(response);
            $('#sub_category_id').select2();
        },
        error: (error) => {
            console.log(error);
        }
    })
})

$('.delete-image').click(function (e) {
    e.preventDefault();

    $(".loader").addClass("loading");
    const _token = $('meta[name="csrf-token"]').attr('content');
    let productId = $(this).attr('data-id')
    let typeImage = $(this).attr('data-name')
    let language = $(this).attr('data-language')

    $.ajax({
        method: "POST",
        url: `/admin/products/${productId}/deleteImage`,
        data: {
            _token: _token,
            type_image: typeImage,
            language: language,
        },
        success: (response) => {
            $(".loader").removeClass("loading");

            if (response.status === true) {
                window.location.reload();
            }
        },
        error: (response) => {
            $(".loader").removeClass("loading");

            if (response.status === false) {
                alert(response.message)
            }
        }
    })
})

$('.delete-document').click(function (e) {
    e.preventDefault();

    $(".loader").addClass("loading");
    const _token = $('meta[name="csrf-token"]').attr('content');
    let productId = $(this).attr('data-product-id')

    $.ajax({
        method: "POST",
        url: `/admin/products/${productId}/deleteDocument`,
        data: {
            _token: _token,
        },
        success: (response) => {
            $(".loader").removeClass("loading");

            if (response.status === true) {
                window.location.reload();
            }
        },
        error: (response) => {
            $(".loader").removeClass("loading");

            if (response.status === false) {
                alert(response.message)
            }
        }
    })
})