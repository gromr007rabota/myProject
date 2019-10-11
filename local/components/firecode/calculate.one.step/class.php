<?

class CCalculateOneStepComponent extends Firecode\CalculateComponents
{


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
        //-----------
        //Url по которому нужно обратиться к API для текущей вкладки
        $this->urlApiRequest = \Firecode\GlobalsIds::CONST_URL_API_REQUEST_STEP_ONE;
        //-----------
        // Все значения пород из Highload блока
        $this->allPropHighlBreed = \Firecode\CalculateComponents::getMasHighloadElements($this->idHighloadBlockBreed);
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


        if ($_REQUEST["MASS_MALE_ID"] && $_REQUEST["MASS_FEMALE_ID"]) {
            $arrayAllDogsRequest = array_merge(json_decode($_REQUEST["MASS_MALE_ID"], true), json_decode($_REQUEST["MASS_FEMALE_ID"], true));
            //Проверка на дубли
            $arrayAllDogsRequest = array_values(array_flip(array_flip($arrayAllDogsRequest)));
            $this->masIdDogsRequest = $arrayAllDogsRequest;
            //Берем данные с БД
            $this->masPropertyDogsBD = $this->getAllRequestDogs($this->masIdDogsRequest);
        }

    }


    /**
     * Проверяем наличие собак обоих полов
     *
     * @param $massDogs
     *
     * @return bool
     */
    public function flagMaleAndFemale($massDogs)
    {
        $result = false;

        $arFields = $this->masPropertyDogsBD;

        $masOriginPropSex = [];
        foreach ($massDogs as $idDog)
            if ($arFields[$idDog]) {
                $masOriginPropSex[$arFields[$idDog]["PROP_SEX"]["VALUE"]] = 'yes';
            }
        if ($masOriginPropSex["Male"] && $masOriginPropSex["Femail"]) {
            $result = true;
        }

        return $result;
    }


    /**
     * Проверяем наличие собак авторизированного пользователя
     *
     * @param $massDogs
     *
     * @return array|bool
     *
     * @global $USER
     */
    public function flagMyDogs($massDogs)
    {
        global $USER;
        $flagMyDogs = false;
        $udUserLogin = $USER->GetID();
        if ($udUserLogin) {
            $order = array('sort' => 'asc');
            $tmp = 'sort';
            $filter = array("ID" => $udUserLogin);
            $rsUsers = CUser::GetList($order, $tmp, $filter, array("SELECT" => array('UF_MY_DOGS_M')));
            $arUser = $rsUsers->Fetch();

            foreach ($massDogs as $idDog)
                if ($arUser["UF_MY_DOGS_M"]) {
                    if (in_array($idDog, $arUser["UF_MY_DOGS_M"])) {
                        $flagMyDogs = true;
                    }
                }
        }

        return $flagMyDogs;
    }



    /**
     * Подготовка данных для запроса API
     *
     * @return json
     */
    public function predRestApiStep()
    {

        $post_data = $this->masIdDogsRequest;
        //Временная заглушка на отправляемые данные
        $post_data = json_encode(array("males" => ["68"], "females" => ["58"], "breed" => "1"));

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
        $responseJson = '{ "results": [ 
                    { 
                        "pair": { "male": 3, "female": 4, "raiting": 0, "missing allels": { "Aguti": 1, "Delute": 1, "Brown": 2, "Dominant black": 4, "Pied": 4, "MCR1": 4 } }, 
                        "chances": [ { "id": 94, "name": "blue trindle", "chance": 0.2109375 }, { "id": 97, "name": "lilac trindle", "chance": 0.0703125 }, { "id": 96, "name": "black trindle", "chance": 0.0703125 }, { "id": 85, "name": "blue tan", "chance": 0.0703125 }, { "id": 100, "name": "blue cream", "chance": 0.0625 }, { "id": 64, "name": "blue", "chance": 0.046875 }, { "id": 107, "name": "solid blue", "chance": 0.03125 }, { "id": 81, "name": "blue pied", "chance": 0.0234375 }, { "id": 95, "name": "chocolate trindle", "chance": 0.0234375 }, { "id": 93, "name": "lilac tan", "chance": 0.0234375 }, { "id": 84, "name": "black tan", "chance": 0.0234375 }, { "id": 101, "name": "lilac cream", "chance": 0.020833333333333332 }, { "id": 98, "name": "cream", "chance": 0.020833333333333332 }, { "id": 60, "name": "brindle", "chance": 0.015625 }, { "id": 83, "name": "blue fawn", "chance": 0.015625 }, { "id": 87, "name": "lilac", "chance": 0.015625 }, { "id": 111, "name": "solid lilac", "chance": 0.010416666666666666 }, { "id": 106, "name": "blue pied solid", "chance": 0.010416666666666666 }, { "id": 108, "name": "solid black", "chance": 0.010416666666666666 }, { "id": 86, "name": "chocolate tan", "chance": 0.0078125 }, { "id": 99, "name": "chocolate cream", "chance": 0.006944444444444444 }, { "id": 62, "name": "brindle pied", "chance": 0.005208333333333333 }, { "id": 89, "name": "lilac pied", "chance": 0.005208333333333333 }, { "id": 88, "name": "lilac fawn", "chance": 0.005208333333333333 }, { "id": 79, "name": "chocolate", "chance": 0.005208333333333333 }, { "id": 92, "name": "blue fawn pied", "chance": 0.005208333333333333 }, { "id": 59, "name": "fawn", "chance": 0.005208333333333333 }, { "id": 110, "name": "solid chocolate", "chance": 0.003472222222222222 }, { "id": 80, "name": "chocolate pied", "chance": 0.0026041666666666665 }, { "id": 90, "name": "lilac fawn pied", "chance": 0.001736111111111111 }, { "id": 82, "name": "chocolate fawn", "chance": 0.001736111111111111 }, { "id": 63, "name": "fawn pied", "chance": 0.001736111111111111 }, { "id": 105, "name": "chocolate pied solid", "chance": 0.0011574074074074073 }, { "id": 91, "name": "chocolate fawn pied", "chance": 0.0005787037037037038 } ] 
                        }, 
                    {   "pair": { "male": 34, "female": 31, "raiting": 0, "missing allels": { "Aguti": 1, "Delute": 1, "Brown": 2, "Dominant black": 4, "Pied": 4, "MCR1": 4 } }, "chances": [ { "id": 94, "name": "blue trindle", "chance": 0.99999 }, { "id": 97, "name": "lilac trindle", "chance": 0.0703125 }, { "id": 96, "name": "black trindle", "chance": 0.0703125 }, { "id": 85, "name": "blue tan", "chance": 0.0703125 }, { "id": 100, "name": "blue cream", "chance": 0.0625 }, { "id": 64, "name": "blue", "chance": 0.046875 }, { "id": 107, "name": "solid blue", "chance": 0.03125 }, { "id": 81, "name": "blue pied", "chance": 0.0234375 }, { "id": 95, "name": "chocolate trindle", "chance": 0.0234375 }, { "id": 93, "name": "lilac tan", "chance": 0.0234375 }, { "id": 84, "name": "black tan", "chance": 0.0234375 }, { "id": 101, "name": "lilac cream", "chance": 0.020833333333333332 }, { "id": 98, "name": "cream", "chance": 0.020833333333333332 }, { "id": 60, "name": "brindle", "chance": 0.015625 }, { "id": 83, "name": "blue fawn", "chance": 0.015625 }, { "id": 87, "name": "lilac", "chance": 0.015625 }, { "id": 111, "name": "solid lilac", "chance": 0.010416666666666666 }, { "id": 106, "name": "blue pied solid", "chance": 0.010416666666666666 }, { "id": 108, "name": "solid black", "chance": 0.010416666666666666 }, { "id": 86, "name": "chocolate tan", "chance": 0.0078125 }, { "id": 99, "name": "chocolate cream", "chance": 0.006944444444444444 }, { "id": 62, "name": "brindle pied", "chance": 0.005208333333333333 }, { "id": 89, "name": "lilac pied", "chance": 0.005208333333333333 }, { "id": 88, "name": "lilac fawn", "chance": 0.005208333333333333 }, { "id": 79, "name": "chocolate", "chance": 0.005208333333333333 }, { "id": 92, "name": "blue fawn pied", "chance": 0.005208333333333333 }, { "id": 59, "name": "fawn", "chance": 0.005208333333333333 }, { "id": 110, "name": "solid chocolate", "chance": 0.003472222222222222 }, { "id": 80, "name": "chocolate pied", "chance": 0.0026041666666666665 }, { "id": 90, "name": "lilac fawn pied", "chance": 0.001736111111111111 }, { "id": 82, "name": "chocolate fawn", "chance": 0.001736111111111111 }, { "id": 63, "name": "fawn pied", "chance": 0.001736111111111111 }, { "id": 105, "name": "chocolate pied solid", "chance": 0.0011574074074074073 }, { "id": 91, "name": "chocolate fawn pied", "chance": 0.0005787037037037038 } ] } 
                    ] }';


        // Декодируем JSON
        $responseMass = json_decode($responseJson, true); // второй параметр переводит данные в массив, а не объект

        //Выбираем ID собак
        $massAlldogs = [];
        $masItemsCalculateStepOne = [];
        $masChanses = [];
        foreach ($responseMass["results"] as $ind => $prop) {
            if ($prop["pair"]["male"])
                $massAlldogs[$prop["pair"]["male"]] = 'yes';
            if ($prop["pair"]["female"])
                $massAlldogs[$prop["pair"]["female"]] = 'yes';

            $masItemsCalculateStepOne[$ind]["male_id"] = $prop["pair"]["male"];
            $masItemsCalculateStepOne[$ind]["female_id"] = $prop["pair"]["female"];

            //Обработка процентов округляем до двух символов
            foreach ($prop["chances"] as $indCh => $masChance)
                {
                $prop["chances"][$indCh]["chance"] = round($masChance["chance"], 2);
                $masChanses[] = $masChance["ID"];
                }

            $masItemsCalculateStepOne[$ind]["chances"] = $prop["chances"];
        }

        $arFields = $this->masPropertyDogsBD;

        //Заполняем arResult
        $arResult["resultStatus"] = 'ok';
        $arResult["propertyDogAll"] = $arFields;
        $arResult["rowResultCalcStepOne"] = $masItemsCalculateStepOne;
        $arResult["masChanses"] = $masChanses;

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
        if ($_REQUEST["SUBMIT_CALCULATE_STEP_ONE"] == 'yes') {

            if (!check_bitrix_sessid()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Ваша сессия истекла, пожалуйста, перезагрузите страницу, чтобы продолжить</p>';
            elseif (!$this->flagAccessUser()):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Ваша подписка истекла, пожалуйста, продлите ее, чтобы продолжить</p>';
            elseif (!$this->flagMaleAndFemale($this->masIdDogsRequest)):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Должны быть выбраны собаки обоих полов</p>';
            elseif (!$this->flagMyDogs($this->masIdDogsRequest)):
                $arResult["resultStatus"] = 'error';
                $arResult["resultMessage"] = '<p>Должна быть выбрана Ваша собака</p>';
            else:
                //$arResult["resultStatus"] = 'ok';
                $arResult = $this->restApiStepAll($this->masIdDogsRequest);
            endif;
            $arResult["resultStepOne"] = 'yes';
        }
        return $arResult;
    }


}



