<?


use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;

class CCalculateColorsThreeStepComponent extends \CBitrixComponent
{

    var $flagAjaxRequestThis; //Флаг при Аякс запросе
    var $idIblockFenotypicTraits; //ID инфоблока FenotypicTraits
    var $masAllFenotypicTraits; //Выборка из инфоблока FenotypicTraits


    /**
     * Главная ф-я класса
     */
    public function executeComponent()
    {

        //-----------
        //Задаем переменные
        //-----------
        $this->flagAjaxRequestThis = ''; //Флаг при Аякс запросе
        //-----------
        //-----------
        $this->idIblockFenotypicTraits = \Firecode\GlobalsIds::CONST_ID_IBLOCK_FENOTYPIC_TRAITS; //ID инфоблока FenotypicTraits
        //-----------
        //-----------


        //Формируем данные

        if ($_REQUEST["SUBMIT_COLOR_STEP_THREE"]) {

            //Собираем все окрасы из FenotypicTraits
            $this->getAllFenotypicTraits();

            //Флаг при Аякс запросе
            $this->flagAjaxRequestThis = 'yes';
            }
        //-----------
        //Подготавливаем arResult
            $this->arResult = array_merge($this->arResult, $this->makeResult());
        //Подключаем шаблон
            $this->IncludeComponentTemplate();

    }


    /**
     * Берем окрасы из инфоблока FenotypicTraits
     */
    public function getAllFenotypicTraits()
    {
        $arFields = [];
        if (Loader::includeModule('iblock')) {

            //Берем данные из БД
            $arSelect = Array();
            $arFilter = Array("IBLOCK_ID" => IntVal($this->idIblockFenotypicTraits), "ACTIVE" => "Y");

            $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $masProp = $ob->GetFields();
                $arProps = $ob->GetProperties();
                $masProp = array_merge($masProp, $arProps);
                //--------------
                //Берем путь до картинки
                $masProp["PREVIEW_PICTURE_PATH"] = \CFile::GetPath($masProp["PREVIEW_PICTURE"]);
                //--------------
                $arFields[$masProp["ID"]] = $masProp;

            }

        }
        $this->masAllFenotypicTraits = $arFields;


    }



    /**
     * Функция формирования arResult
     *
     * @return $arResult
     */
    public function makeResult()
    {
        $arResult = [];

        $arResult["MAS_ALL_FENOTYPIC_TRAITS"] = $this->masAllFenotypicTraits;

        $arResult["FLAG_AJAX_REQUEST"] = $this->flagAjaxRequestThis;
        $arResult["resultStatus"] = 'ok';

        return $arResult;
    }


}



