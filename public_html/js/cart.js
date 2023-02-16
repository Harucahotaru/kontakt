$('body').on('change', '.number_count', function () {
    let form = $(this).closest("form");
    console.log(form);
    form.submit();
})
$( document ).ready(function() {
    var cartModalButtonOpen = $('#cartModalButton')
    var cartModalButtonClose = $('#cartModalButtonClose')
    var cartModal = new bootstrap.Modal(document.getElementById('cartFormModal'))

    cartModalButtonOpen.on('click', function () {
        cartModal.show();
    })

    cartModalButtonClose.on('click', function () {
        cartModal.hide();
    })
});