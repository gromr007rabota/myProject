<?

class CCalculateLocationThreeStepComponent extends \CBitrixComponent
{

    var $idIblockDogs; // ID инфоблока собак
    var $idHighloadBlockBreed; // ID highload блока пород
    var $allGroupPodpiska;//Массив с группами по подписке
    var $propertyPropSexMaleId;// ID значения списка пола собаки
    var $propertyPropSexFemaleId;// ID значения списка пола собаки
    var $masIdDogsUser; //Массив ID собак пользователя
    var $masIDBreedsDogs; //Массив ID Пород собак пользователя
    var $masPropertyAllCity; //Массив свойств отобранных городов
    var $masIDMestopolojenieDogs; //Массив ID местоположений нужных для фильтра собак
    var $masIDCountryDogs; //Массив ID Стран нужных для фильтра собак
    var $masCountryCityTree; //Дерево Стран с городами выбранных по условиям
    var $flagAjaxRequestThis; //Флаг при Аякс запросе


    /**
     * Главная ф-я класса
     */
    public function executeComponent()
    {

        //-----------
        //Задаем переменные
        //-----------

        //-----------
        $this->idIblockDogs = \Firecode\GlobalsIds::CONST_ID_IBLOCK_DOGS; // ID инфоблока собак
        //-----------
        $this->idHighloadBlockBreed = \Firecode\GlobalsIds::CONST_ID_HIGHLOAD_BLOCK_BREED; // ID highload блока пород
        //-----------
        $this->allGroupPodpiska = \Firecode\GlobalsIds::CONST_MAS_GROUP_PODPISKA; //Массив с группами по подписке
        //-----------
        $this->propertyPropSexMaleId = \Firecode\GlobalsIds::CONST_ID_PROP_SEX_MALE; // ID значения списка пола собаки
        //-----------
        $this->propertyPropSexFemaleId = \Firecode\GlobalsIds::CONST_ID_PROP_SEX_FEMALE; // ID значения списка пола собаки
        //-----------


        $this->masIdDogsUser = []; //Массив ID собак пользователя
        //-----------
        $this->masIDBreedsDogs = []; //Массив ID Пород собак пользователя
        //-----------
        $this->masIDMestopolojenieDogs = []; //Массив ID местоположений нужных для фильтра собак
        //-----------
        $this->masCountryCityTree = []; //Дерево Стран с городами выбранных по условиям
        //-----------
        $this->masIDCountryDogs = []; //Массив ID Стран нужных для фильтра собак
        //-----------
        $this->masPropertyAllCity = []; //Массив свойств отобранных городов
        //-----------
        $this->flagAjaxRequestThis = ''; //Флаг при Аякс запросе
        //-----------
        //-----------
        //Формируем данные

        if ($_REQUEST["SUBMIT_LOCATE_STEP_THREE"]) {

            //массив собак пользователя
            $this->funcDogsUser();
            //Породы собак из БД пользователя женского пола
            $this->getPropertyFemaleDogsUser();
            //ID местоположений, всек Активных собак, Мужского пола, Кроме собак пользователя, У которых порода совпадает с породой любой из собак пользователя, Заполнено местоположение
            $this->getIdMestopolojenieDogs();
            //Города по ID местоположений
            $masPropertyMestopolojeniya = \Firecode\CalculateComponents::getCountryCity($this->masIDMestopolojenieDogs);
            $this->masPropertyAllCity = $masPropertyMestopolojeniya[0];
            $this->masCountryCityTree = $masPropertyMestopolojeniya[1];
            $this->masIDCountryDogs = $masPropertyMestopolojeniya[2];

            //Cвойства для Стран
            $masPropertyCountry = \Firecode\CalculateComponents::getCountryProperty($this->masIDCountryDogs,$this->masCountryCityTree);
            $this->masCountryCityTree = $masPropertyCountry[1];


            $this->flagAjaxRequestThis = 'yes';
            }
        //-----------
        //Подготавливаем arResult
            $this->arResult = array_merge($this->arResult, $this->makeResult());

        //Подключаем шаблон
            $this->IncludeComponentTemplate();

    }


    /**
     * Функция формирует массив собак пользователя
     *
     *
     */
    public function funcDogsUser()
    {
        global $USER;
        $udUserLogin = $USER->GetID();
        if ($udUserLogin) {
            $order = array('sort' => 'asc');
            $tmp = 'sort';
            $filter = array("ID" => $udUserLogin);
            $rsUsers = \CUser::GetList($order, $tmp, $filter, array("SELECT" => array('UF_*')));
            $arUser = $rsUsers->Fetch();
        }
        $this->masIdDogsUser = $arUser["UF_MY_DOGS_M"];

    }



    /**
     * Функция Породы собак из БД пользователя женского пола
     *
     *
     */
    public function getPropertyFemaleDogsUser()
    {
        $masIDBreeds = [];
        $arSelect=Array("PROPERTY_PROP_BREED");
        $arFilter=Array("IBLOCK_ID"=>$this->idIblockDogs, "ACTIVE"=>"Y", "ID" => $this->masIdDogsUser, "PROPERTY_PROP_SEX" => $this->propertyPropSexFemaleId);
        $res=\CIBlockElement::GetList(Array(),$arFilter,false,Array("nPageSize"=>500),$arSelect);
        while($ob=$res->GetNextElement()){
            $arFields=$ob->GetFields();
            $masIDBreeds[$arFields["PROPERTY_PROP_BREED_VALUE"]] = 'yes';
        }
        $this->masIDBreedsDogs = array_keys($masIDBreeds);

    }



    /**
    * Функция Выбирает из базы ID местоположений
    * всек
    * Активных собак
    * Мужского пола,
    * Кроме собак пользователя,
    * У которых порода совпадает с породой любой из собак пользователя
    * Заполнено местоположение
    */
    public function getIdMestopolojenieDogs()
    {
        $masDogsMestopolojenie = [];
        $arSelect=Array("PROPERTY_CITY_MESTOPOLOJENIE");
        $arFilter=Array(
            "IBLOCK_ID"=>$this->idIblockDogs,
            "ACTIVE"=>"Y",
            "!ID" => $this->masIdDogsUser,
            "PROPERTY_PROP_BREED" => $this->masIDBreedsDogs,
            "PROPERTY_PROP_SEX" => $this->propertyPropSexMaleId,
            "!PROPERTY_CITY_MESTOPOLOJENIE" => false
        );
        $res=\CIBlockElement::GetList(Array(),$arFilter,false,Array("nPageSize"=>500),$arSelect);
        while($ob=$res->GetNextElement()){
            $arFields=$ob->GetFields();
            $masDogsMestopolojenie[$arFields["PROPERTY_CITY_MESTOPOLOJENIE_VALUE"]] = 'yes';
        }
        $this->masIDMestopolojenieDogs = array_keys($masDogsMestopolojenie);

    }



    /**
     * Функция формирования arResult
     *
     * @return $arResult
     */
    public function makeResult()
    {
        $arResult = [];

        $arResult["MAS_PROPERTY_ALL_CITY"] = $this->masPropertyAllCity;
        $arResult["MAS_COUNTRY_CITY_TREE"] = $this->masCountryCityTree;

        $arResult["FLAG_AJAX_REQUEST"] = $this->flagAjaxRequestThis;
        $arResult["resultStatus"] = 'ok';

        return $arResult;
    }


}



