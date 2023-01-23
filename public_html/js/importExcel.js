$(document).on('change', 'input[type="file"]', function () {
    var $input = $(".file-input");
    var fd = new FormData;

    fd.append('excel', $input.prop('files')[0]);

    $.ajax({
        url: '/admin/import-excel/render-preview-excel',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            $('.excel-preview').html(data);
        }
    });
});
