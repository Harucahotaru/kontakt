$(function () {
    $('.actionInput').change(function () {

        var inputData = new FormData;
        inputData.append('action', $(this).val());
        $( ".valueInput" ).prop( "disabled", true );

        $.ajax({
            url: '/admin/products/get-list',
            data: inputData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                $('.valueInput').empty();

                $( ".valueInput" ).prop( "disabled", false );

                $.each(JSON.parse(response), function(key, value){
                    var string = "<option value=\"" + key + "\">" + value + "</option>"
                    console.log(string);
                    $('.valueInput').prepend(string);
                });
            }
        });
    })
});