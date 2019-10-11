
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

        genGroup['Aguti'] = ['AgoutiLeftMale','AgoutiRightMale','AgoutiLeftFemale','AgoutiRightFemale'];
        genGroup['Brown'] = ['BrownLeftMale','BrownRightMale','BrownLeftFemale','BrownRightFemale'];
        genGroup['Delute'] = ['DiluteLeftMale','DiluteRightMale','DiluteLeftFemale','DiluteRightFemale'];
        genGroup['Dominant black'] = ['Dominant blackLeftMale','Dominant blackRightMale','Dominant blackLeftFemale','Dominant blackRightFemale'];
        genGroup['MCR1'] = ['MCR1LeftMale','MCR1RightMale','MCR1LeftFemale','MCR1RightFemale'];
        genGroup['Pied'] = ['PiedLeftMale','PiedRightMale','PiedLeftFemale','PiedRightFemale'];


        function fun1(nameGroup) {
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

                        var valRadioGen = fun1(genGroupI[j]);

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
        $('.MASS_GENS').val(jsonMasGenGroups);

    //Отправляем форму

        data=$(e).serialize();

console.log('Отпр1');
console.log(data);

        if(data && path && !exit_loops)
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