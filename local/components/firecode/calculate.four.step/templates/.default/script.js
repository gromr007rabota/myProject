
function ajaxSendCalculator(e,path)
{


    //Переносим сформированные данные в форму

        var genGroup = {};
        genGroup['Aguti'] = {};
        genGroup['Brown'] = {};
        genGroup['Delute'] = {};
        genGroup['Dominant black'] = {};
        genGroup['MCR1'] = {};
        genGroup['Pied'] = {};

        genGroup['Aguti'] = ['AgoutiLeftMale','AgoutiRightMale'];
        genGroup['Brown'] = ['BrownLeftMale','BrownRightMale'];
        genGroup['Delute'] = ['DiluteLeftMale','DiluteRightMale'];
        genGroup['Dominant black'] = ['Dominant blackLeftMale','Dominant blackRightMale'];
        genGroup['MCR1'] = ['MCR1LeftMale','MCR1RightMale'];
        genGroup['Pied'] = ['PiedLeftMale','PiedRightMale'];

        function fun4(nameGroup) {
            var rad=document.getElementsByName(nameGroup);
            for (var i=0;i<rad.length; i++) {
                if (rad[i].checked) {
                    return($(rad[i]).val());
                }
            }
            return '';
        }

        var exit_loops = false;
        for (var i in genGroup) {
            if (genGroup.hasOwnProperty(i)) {

                var genGroupI = genGroup[i];

                for (var j in genGroupI) {
                    if (genGroupI.hasOwnProperty(j)) {

                        var valRadioGen = fun4(genGroupI[j]);

                        if(!valRadioGen)
                        {
                            alert('Заполните все группы генов');
                            exit_loops = true;
                            break;
                        }
                        else
                        {
                            genGroup[i][j] = valRadioGen;
                        }

                    }
                }
                if (exit_loops)
                {break;}
            }
        }

        var jsonMasGenGroups = JSON.stringify(genGroup);
        $('.form_api_mas_gens').val(jsonMasGenGroups);

    //Переносим ID собаки и Город

        var gen_female = $('.gender_female_step_three')[0];
        var city_male = $('.city_male_step_three')[0];

        $('.form_api_gen_female').val(gen_female);
        $('.form_api_city_male').val(city_male);


//Отправляем форму

    data=$(e).serialize();

console.log('Отправляем');
console.log(data);

    if(data && path && !exit_loops)
    {
        BX.ajax.post(path,data,function(data)
        {
        //Получаем ответ

console.log('Принимаем');
console.log(data);

            data=JSON.parse(data);

            // console.log(data.status);
            // console.log(data.message);

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