$('body').on('change', '.number_count', function () {
    let form = $(this).closest("form");
    console.log(form);
    form.submit();
})