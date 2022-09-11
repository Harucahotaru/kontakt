<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Страница, к которой подключен jQuery</title>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<div class="tableHolder" style='overflow:scroll;width:400px; height:410px;'>
    <table class="table table-stripped table-bordered objTable">
        <thead>
        <tr>
            <th width="1%">#</th>
            <th width="45%">Название</th>
            <th width="20%" sort="city" style="cursor: n-resize;">Город</th>
            <th width="20%" sort="address" style="cursor: n-resize;">Улица, дом</th>
        </tr>
        </thead>
        <tbody>
        <tr style="cursor: pointer;">
            <td>1</td>
            <td key="1" phone="3">Тестовый контрагент</td>
            <td>Москва</td>
            <td>Вавилова, 2</td>
        </tr>
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $(function () {
            $(".tableHolder table tbody tr").click(function () {
                var key = $(this).find("[key]").attr("key");
                var name = $(this).find("[key]").text();
                var phone = $(this).find("[phone]").text();
            }).css("cursor", "pointer");
        });
    });
</script>
</body>
</html>