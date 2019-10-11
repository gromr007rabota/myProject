function ajaxSendLocation(e, path) {
    //Отправляем форму
    data = $(e).serialize();
    if (data && path) {
        BX.ajax.post(path, data, function (data) {
            //Получаем ответ
            data = JSON.parse(data);
            if (data.status == "ok" || data.status == "error") {
                if (data.status == "ok") {
                    $(data.html1).appendTo($('[data-country-container]'));
                    $(data.html2).appendTo($('[data-city-container]'));
                }
                if (data.status == "error") {

                }
            }
        })
    }
}

// по завершению загрузки страницы
$(document).ready(function() {
    $('.submit_locate_step_three').submit();
});
