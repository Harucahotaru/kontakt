$(document).ready(function ($) {
    var subCat = $('#sub-cat-2')
    var cat = $('#cat')
    var submitButton = $('#subButton')
    var openButton = $('#openButton')
    var subDiv = $('#subDiv')

    cat.change(function () {
        if (cat.val() === 'delete') {
            subDiv.addClass('hide-block');
        } else {
            submitButton.prop('disabled', true);
            subDiv.removeClass('hide-block');
        }
    })

    openButton.click(function () {
        submitButton.prop('disabled', true);
    });

    cat.change(function () {
        if (cat.val() === 'delete') {
            submitButton.prop('disabled', false);
        }
    })

    subCat.change(function () {
        submitButton.prop('disabled', false);
    })

    submitButton.on("submit", function (event, jqXHR, settings) {
        event.preventDefault(); // 1
        event.stopImmediatePropagation(); // 2
        return false;
    });

    function checkedInput(productInput) {
        var result = false
        productInput.forEach(function (input) {
            if (input.checked === true) {
                result = true
            }
        });
        return result
    }

    function getProductsIds(productInput) {
        var result = []
        productInput.forEach(function (input) {
            result.push(input.value)

        });
        return result
    }

    submitButton.on('click', function () {

        var inputData = new FormData;
        var productInput = document.getElementsByName('selection[]');
        var validError = $('.text-validation-error')
        var productsEmptyError = 'Для выполнение действия выберите товары!'

        inputData.append('action', cat.val());
        inputData.append('value', subCat.val());
        inputData.append('selection', JSON.stringify(getProductsIds(productInput)));

        if (checkedInput(productInput)) {
            validError.text('')
            $.ajax({
                url: '/admin/products/mass-change',
                data: inputData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response) {
                    $.pjax.reload({container: '#products', async: false});
                }
            });
        } else {
            validError.text(productsEmptyError)
        }
    })

    var paginationSize = new $('#pagination');

    paginationSize.on('change', function () {

        var inputData = new FormData;

        inputData.append('paginationSize', paginationSize.val());

        $.ajax({
            url: '/admin/products/change-pagination',
            data: inputData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
            }
        });
    })
});



