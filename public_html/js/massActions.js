$(document).ready(function ($) {
    let subCat = $('#sub-cat-2');
    let cat = $('#cat');
    let submitButton = $('#subButton');
    let openButton = $('#openButton');
    let subDiv = $('#subDiv');

    cat.change(function () {
        if (cat.val() === 'delete') {
            subDiv.addClass('hide-block');
            submitButton.prop('disabled', false);
        } else {
            submitButton.prop('disabled', true);
            subDiv.removeClass('hide-block');
        }
    })

    openButton.click(function () {
        submitButton.prop('disabled', true);
    });

    subCat.change(function () {
        if (subCat.val() === '' && cat.val() !== 'delete') {
            submitButton.prop('disabled', true);
        } else {
            submitButton.prop('disabled', false);
        }
    })

    function checkedInput(productInput) {
        let result = false;
        productInput.forEach(function (input) {
            if (input.checked === true) {
                result = true;
            }
        });
        return result;
    }

    function getProductsIds(productInput) {
        let result = [];
        productInput.forEach(function (input) {
            if (input.checked === true) {
                result.push(input.value)
            }

        });
        return result;
    }

    submitButton.on('click', function () {

        let inputData = new FormData;
        let productInput = document.getElementsByName('selection[]');
        let validError = $('.text-validation-error')
        let productsEmptyError = 'Для выполнение действия выберите товары!'

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

    let paginationSize = new $('#pagination');

    paginationSize.on('change', function () {

        let inputData = new FormData;

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



