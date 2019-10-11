<?


class CCalculateTwoStepComponent extends Firecode\CalculateComponents
{

    /**
     * Массив Свойств Генов из входных данных
     * @var array
     */
    var $masPropertyGensRequest;


    /**
     * Главная ф-я класса
     */
    public function executeComponent()
    {
        global $APPLICATION;
        //-----------
        //Задаем переменные
        //-----------
        $this->inicializationProperty();
        //-----------
        //-----------
        //Url по которому нужно обратиться к API для текущей вкладки
        $this->urlApiRequest =  \Firecode\GlobalsIds::CONST_URL_API_REQUEST_STEP_TWO;
        //-----------
        //-----------
        //Обработка входных данных
        $this->getRequestInProperty();
        //-----------

        //Подготавливаем arResult
        $this->arResult = array_merge($this->arResult, $this->makeResult());
        //Подключаем шаблон
        $this->IncludeComponentTemplate();

    }


    /**
     * Обработка входных данных
     *
     */
    public function getRequestInProperty()
    {

        if ($_REQUEST["MASS_GENS"]) {
            $arrayAllGensRequest = json_decode($_REQUEST["MASS_GENS"], true);

            //Кладем данные в переменную
            $this->masPropertyGensRequest = $arrayAllGensRequest;
        }

    }


    /**
     * Проверяем все наборы генов выбраны
     *
     * @param $this->masPropertyGensRequest
     *
     * @return bool
     *
     */
    public function flagAllGensRequest()
    {
        $ret = false;

        $arrayAllGensRequest = $this->masPropertyGensRequest;
        if( count($arrayAllGensRequest["Aguti"] == 4) &&
            count($arrayAllGensRequest["Brown"] == 4) &&
            count($arrayAllGensRequest["Delute"] == 4) &&
            count($arrayAllGensRequest["Dominant black"] == 4) &&
            count($arrayAllGensRequest["MCR1"] == 4) &&
            count($arrayAllGensRequest["Pied"] == 4) )
            {
            $ret = true;
            }


    return $ret;
    }


    /**
     * Подготовка данных для запроса API
     *
     * @return json
     */
    public function predRestApiStep()
    {


        $post_data = [];
        $post_data["first"] = '';
        $post_data["second"] = '';
        $post_data["breed"] = "French Bulldog";

        $massGens = $this->masPropertyGensRequest;


        foreach($massGens as $okrass => $masGens){
            $post_data["first"][$okrass] = [$masGens[0],$masGens[1]];
            $post_data["second"][$okrass] = [$masGens[2],$masGens[3]];
        }


        //Временная заглушка на отправляемые данные
        //Не понятно откуда берется "breed": "French Bulldog"
            $post_data = '{
                "first": {
                    "Aguti": ["Ay","At"],
                    "Brown": ["b","b"],
                    "Delute": ["d","D"],
                    "Dominant black": ["Ky","Kbr"],
                    "MCR1": ["E","E"],
                    "Pied": ["N","S"]
                    },
                "second": {
                    "Aguti": ["Ay","At"],
                    "Brown": ["b","b"],
                    "Delute": ["D","d"],
                    "Dominant black": ["Ky","Kbr"],
                    "MCR1": ["E","E"],
                    "Pied": ["N","S"]
                    },
                "breed": "French Bulldog"
                }';

        return $post_data;

    }


    /**
     * Обработка ответа от API
     *
     * @return $arResult
     */
    public function restApiStepAnswer($responseJson)
    {

        $arResult = [];

        //Временная Заглушка на получение данных от сервера
        $responseJson = '{ "results": { "chances": [ { "id": 79, "name": "chocolate", "chance": 0.31640625 }, { "id": 82, "name": "chocolate fawn", "chance": 0.10546875 }, { "id": 80, "name": "chocolate pied", "chance": 0.10546875 }, { "id": 87, "name": "lilac", "chance": 0.10546875 }, { "id": 95, "name": "chocolate trindle", "chance": 0.10546875 }, { "id": 91, "name": "chocolate fawn pied", "chance": 0.03515625 }, { "id": 88, "name": "lilac fawn", "chance": 0.03515625 }, { "id": 89, "name": "lilac pied", "chance": 0.03515625 }, { "id": 86, "name": "chocolate tan", "chance": 0.03515625 }, 
                    { "id": 97, "name": "lilac trindle", "chance": 0.03515625 }, { "id": 90, "name": "lilac fawn pied", "chance": 0.01171875 }, { "id": 93, "name": "lilac tan", "chance": 0.01171875 }, { "id": 64, "name": "blue", "chance": 0 }, { "id": 83, "name": "blue fawn", "chance": 0 }, { "id": 81, "name": "blue pied", "chance": 0 }, { "id": 92, "name": "blue fawn pied", "chance": 0 }, { "id": 105, "name": "chocolate pied solid", "chance": 0 }, { "id": 106, "name": "blue pied solid", "chance": 0 }, { "id": 107, "name": "solid blue", "chance": 0 }, { "id": 108, "name": "solid black", "chance": 0 }, 
                    { "id": 110, "name": "solid chocolate", "chance": 0 }, { "id": 111, "name": "solid lilac", "chance": 0 }, { "id": 84, "name": "black tan", "chance": 0 }, 
                    { "id": 85, "name": "blue tan", "chance": 0 }, { "id": 59, "name": "fawn", "chance": 0 }, { "id": 60, "name": "brindle", "chance": 0 }, { "id": 96, "name": "black trindle", "chance": 0 }, { "id": 94, "name": "blue trindle", "chance": 0 }, { "id": 62, "name": "brindle pied", "chance": 0 }, { "id": 63, "name": "fawn pied", "chance": 0 }, { "id": 98, "name": "cream", "chance": 0 }, { "id": 99, "name": "chocolate cream", "chance": 0 }, { "id": 100, "name": "blue cream", "chance": 0 }, { "id": 101, "name": "lilac cream", "chance": 0 } ] } }  
                    ';

        // Декодируем JSON
            $responseMass = json_decode($responseJson, true); // второй параметр переводит данные в массив, а не объект

        //Выбираем результаты
            $masItemsCalculateStepTwo = [];
            $chancesDogs = $responseMass["results"]["chances"];

        //Обработка процентов округляем до двух символов
            foreach ($chancesDogs as $indCh => $masChance)
                $chancesDogs[$indCh]["chance"] = round($masChance["chance"], 2);
            $masItemsCalculateStepTwo["chances"] = $chancesDogs;

        //Помещаем входные данные в ответ
            $massInputs = $this->masPropertyGensRequest;
            $rowResultStepTwoGenocodeMale = '';
            $rowResultStepTwoGenocodeFemale = '';
            foreach($massInputs as $masGens){
                $rowResultStepTwoGenocodeMale .= $masGens[0].$masGens[1].' ';
                $rowResultStepTwoGenocodeFemale .= $masGens[2].$masGens[3].' ';
            }

        //Заполняем arResult
            $arResult["resultStatus"] = 'ok';
            $arResult["rowResultStepTwoChances"] = $masItemsCalculateStepTwo;
            $arResult["rowResultStepTwoGenocodeMale"] = $rowResultStepTwoGenocodeMale;
            $arResult["rowResultStepTwoGenocodeFemale"] = $rowResultStepTwoGenocodeFemale;

        return $arResult;


    }


    /**
     * Функция формирования arResult и результатов ответа на запрос
     *
     * @return $arResult
     */
    public function makeResult()
    {

        $arResult = [];
        if ($_REQUEST["SUBMIT_CALCULATE_STEP_TWO"] == 'yes') {

            if (!check_bitrix_sessid()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Ваша сессия истекла, пожалуйста, перезагрузите страницу, чтобы продолжить</p>';
            elseif (!$this->flagAccessUser()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Ваша подписка истекла, пожалуйста, продлите ее, чтобы продолжить</p>';
            elseif (!$this->flagAllGensRequest()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Заполните все наборы генов</p>';
            else:
                //$arResult["resultStatus"] = 'ok';
                $arResult = $this->restApiStepAll($this->masPropertyGensRequest);
            endif;
            $arResult["resultStepTwo"] = 'yes';
        }
        return $arResult;


    }


}