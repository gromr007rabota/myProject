function ajaxColorLocation(e, path) {
    //Отправляем форму
    data = $(e).serialize();

console.log('ot');
console.log(data);

    if (data && path) {
        BX.ajax.post(path, data, function (data) {
            //Получаем ответ

console.log('pov');
console.log(data);

            data = JSON.parse(data);
            if (data.status == "ok" || data.status == "error") {
                if (data.status == "ok") {

                    $('[data-colors-block]').html(data.html1);

                }
                if (data.status == "error") {

                }
            }
        })
    }
}

// по завершению загрузки страницы
$(document).ready(function() {
    $('.submit_color_step_three').submit();
});
