
function ajaxSendCalculator(e,path)
{

    //Переносим сформированные данные в форму
        // gender_female_step_three
        // country_male_step_three
        // city_male_step_three
        // color_one_female_step_three
        // color_two_female_step_three
        // color_three_female_step_three
        var gen_female = $('.gender_female_step_three')[0];
        var city_male = $('.city_male_step_three')[0];
        var color_one = $('.color_one_female_step_three')[0];
        var color_two = $('.color_two_female_step_three')[0];
        var color_three = $('.color_three_female_step_three')[0];

        $('.form_api_gen_female').val(gen_female);
        $('.form_api_city_male').val(city_male);
        $('.form_api_color_one').val(color_one);
        $('.form_api_color_two').val(color_two);
        $('.form_api_color_three').val(color_three);


    //Отправляем форму

    data=$(e).serialize();

console.log('Отпр1');
console.log(data);

    if(data && path)
    {
        BX.ajax.post(path,data,function(data)
        {
        //Получаем ответ

console.log('Отв1');
console.log(data);

            data=JSON.parse(data);


            if(data.status=="ok" || data.status=="error")
            {
                if(data.status=="ok") {
                    $('#calculator_result').html(data.message);
                }
                if(data.status=="error")
                {
                    $('#calculator_result').html(data.message);
                }
            }
        })
    }
}