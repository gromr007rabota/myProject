<?


class CCalculateFourStepComponent extends Firecode\CalculateComponents
{

    /**
     * Массив с входными данными
     * @var array
     */
    var $massInputsRequest;




    /**
     * Главная ф-я класса
     */
    public function executeComponent()
    {

        //-----------
        //Задаем переменные
        //-----------
        $this->inicializationProperty();
        //-----------
        $this->massInputsRequest = [];
        //-----------
        //Url по которому нужно обратиться к API для текущей вкладки
        $this->urlApiRequest =  \Firecode\GlobalsIds::CONST_URL_API_REQUEST_STEP_FOUR;
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
     * Проверка входных данных
     *
     */
    public function getRequestInProperty()
    {

        if ($_REQUEST["GEN_FEMALE"] && $_REQUEST["CITY_MALE"]) {

            $masAllRequest = [];
            $masAllRequest["GEN_FEMALE"] = $_REQUEST["GEN_FEMALE"];
            $masAllRequest["CITY_MALE"] = $_REQUEST["CITY_MALE"];
            $masAllRequest["MAS_GENS"] = $_REQUEST["MAS_GENS"];

            //Массив обработанных входных данных
            $this->massInputsRequest = $masAllRequest;
        }

    }



    /**
     * Подготовка данных для запроса API
     *
     * @return json
     */
    public function predRestApiStep()
    {
        $post_data = $this->massInputsRequest;
        //Временная заглушка на отправляемые данные
        $post_data = json_encode(array());

        return $post_data;
    }


    /**
     * Обработка ответа от API
     *
     * @param $responseJson
     *
     * @return $arResult
     */
    public function restApiStepAnswer($responseJson)
    {
        $arResult = [];

        //Временная Заглушка на получение данных от сервера
        $responseJson = '{ "results": [ ] }';


        // Декодируем JSON
        $responseMass = json_decode($responseJson, true);


        //Заполняем arResult
        $arResult["resultStatus"] = 'ok';
        $arResult["rowResult"] = ["mas"];

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
        if ($_REQUEST["SUBMIT_CALCULATE_STEP_FOUR"] == 'yes') {

            if (!check_bitrix_sessid()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Ваша сессия истекла, пожалуйста, перезагрузите страницу, чтобы продолжить</p>';
            elseif (!$this->flagAccessUser()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Ваша подписка истекла, пожалуйста, продлите ее, чтобы продолжить</p>';
            else:
                $arResult["resultStatus"] = 'ok';
                $arResult["resultMessage"] = '';
                $arResult = $this->restApiStepAll();
            endif;
            $arResult["resultStepFour"] = 'yes';
        }
        return $arResult;
    }


}