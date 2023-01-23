$('input').on('keypress', function (e) {
    if (e.which === 13) {
        location.href = '/catalog/search/' + this.value
    }
});
$(document).on('click', '#searchBtn', function () {
    // console.log($('#w3')[0].value)
    location.href = '/catalog/search/' + $('.tt-input')[0].value
});