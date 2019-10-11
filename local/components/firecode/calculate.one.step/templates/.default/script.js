function ajaxSendCalculator(e, path) {

    //Переносим сформированные данные в форму
    var gen_male = $('.click_gender_male_step_one')[0];
    var gen_female = $('.click_gender_female_step_one')[0];
    var form_gen_male = $('.MASS_MALE_ID')[0];
    var form_gen_female = $('.MASS_FEMALE_ID')[0];

    $('.MASS_MALE_ID').val($(gen_male).val());
    $('.MASS_FEMALE_ID').val($(gen_female).val());

    //Отправляем форму

    data = $(e).serialize();

    if (data && path) {
        BX.ajax.post(path, data, function (data) {
            //Получаем ответ

            data = JSON.parse(data);

            if (data.status == "ok" || data.status == "error") {
                if (data.status == "ok") {
                    $('#calculator_result').html(data.message);
                }
                if (data.status == "error") {
                    $('#calculator_result').html(data.message);
                }
            }
        })
    }
}