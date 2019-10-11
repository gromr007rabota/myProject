<?php
/**
 * Created by PhpStorm.
 * User: serj
 * Date: 17.04.2019
 * Time: 21:06
 */

namespace Firecode;

use \Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL;


class CalculateComponents extends \CBitrixComponent
{

    /**
     * Массив свойств ген
     * @var array
     */
    var $masGenProperty;


    /**
     * ID инфоблока собак
     * @var array
     */
    var $idIblockDogs;


    /**
     * ID инфоблока FenotypicTraits
     * @var array
     */
    var $idIblockFenotypicTraits;


    /**
     * ID highload блока пород
     * @var array
     */
    var $idHighloadBlockBreed;


    /**
     * Все значения пород из Highload блока
     * @var array
     */
    var $allPropHighlBreed;


    /**
     * Массив с группами по подписке
     * @var array
     */
    var $allGroupPodpiska;


    /**
     * Массив ID собак для расчета из запроса
     * @var array
     */
    var $masIdDogsRequest;


    /**
     * Массив Свойств собак из BD
     * @var array
     */
    var $masPropertyDogsBD;


    /**
     * Урл для обращения к API
     * @var str
     */
    var $urlApiRequest;



    /**
     * Главная ф-я класса
     */
    public function executeComponent()
    {

    }


    /**
     * Задаем общие переменные
     */
    public function inicializationProperty()
    {
        //-----------
        $this->idIblockDogs = \Firecode\GlobalsIds::CONST_ID_IBLOCK_DOGS; // ID инфоблока собак
        //-----------
        $this->idIblockFenotypicTraits = \Firecode\GlobalsIds::CONST_ID_IBLOCK_FENOTYPIC_TRAITS; //ID инфоблока FenotypicTraits
        //-----------
        $this->idHighloadBlockBreed = \Firecode\GlobalsIds::CONST_ID_HIGHLOAD_BLOCK_BREED; // ID highload блока пород
        //-----------
        $this->allGroupPodpiska = \Firecode\GlobalsIds::CONST_MAS_GROUP_PODPISKA; //Массив с группами по подписке
        //-----------
        $this->masGenProperty = \Firecode\GlobalsIds::CONST_MAS_GEN_PROPERTY; // Массив свойств ген
        //-----------

    }


    /**
     * Проверяем доступ пользователя по подписке
     *
     * @return bool
     */
    public function flagAccessUser()
    {
        if (\CUser::GetID()) {
            $res = \CUser::GetUserGroupList(\CUser::GetID());
            while ($arGroup = $res->Fetch()) {
                if (in_array($arGroup["GROUP_ID"], $this->allGroupPodpiska)) {
                    if ($arGroup["DATE_ACTIVE_TO"]) {
                        $timeBase = strtotime($arGroup["DATE_ACTIVE_TO"]);
                        $timeClient = strtotime(gmdate("M d Y h:i:s A") . ' UTC') + \CTimeZone::GetOffset();
                        if (($timeBase - $timeClient) > 0) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }


    /**
     * Обработка входных данных
     *
     */
    public function getRequestInProperty()
    {

    }


    /**
     * Берем данные по собакам  из БД
     *
     * @param $massDogs
     *
     * @return array
     */
    public function getAllRequestDogs($massDogs)
    {
        Loader::includeModule('iblock');

        //Берем данные по собакам из БД
        $arSelect = Array();
        $arFilter = Array("IBLOCK_ID" => IntVal($this->idIblockDogs), "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "ID" => $massDogs);
        $arFields = [];
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while ($ob = $res->GetNextElement()) {
            $masProp = $ob->GetFields();
            $arProps = $ob->GetProperties();
            $masProp = array_merge($masProp, $arProps);
            //--------------
            //Берем данные по генам
            $textgenAll = '';
            foreach ($arProps as $pid => $arProperty) {
                if (in_array($pid, $this->masGenProperty)) {
                    if (is_array($arProperty["VALUE"])) {
                    } else {
                        $textgenAll .= $arProperty["VALUE"] . ' ';
                    }
                }
            }
            $masProp["TEXT_GEN_ALL"] = $textgenAll;
            //--------------
            //Берем путь до картинки
            $masProp["PREVIEW_PICTURE_PATH"] = \CFile::GetPath($masProp["PREVIEW_PICTURE"]);
            //--------------
            //Берем данные из Highload блока
            $masProp["PROP_BREED"]["NAME_REAL"] = $this->allPropHighlBreed[$masProp["PROP_BREED"]["VALUE"]];
            //--------------
            $arFields[$masProp["ID"]] = $masProp;

        }


        return $arFields;
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

    }


    /**
     * Проверяем наличие собак авторизированного пользователя
     *
     * @param $massDogs
     *
     * @return array|bool
     */
    public function flagMyDogs($massDogs)
    {


    }


    /**
     * Запрос API
     *
     * @param $post_data
     *
     * @return json
     */
    public function restApiCalculateStepAll($post_data, $urlCurl)
    {

        // Отправляем CURL-запрос
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlCurl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        if ($output === FALSE)
            $responseJson = "cURL Error: " . curl_error($ch);
        else
            $responseJson = $output;
        curl_close($ch);

        return $responseJson;
    }


    /**
     * Подготовка данных для запроса API
     *
     * @param $massDogs
     *
     * @return json
     */
    public function predRestApiStep($massDogs)
    {


    }


    /**
     * Взаимодействие с API
     *
     * @param $massDogs
     *
     * @return $arResult
     */
    public function restApiStepAll()
    {
        $arResult = [];

        //Готовим данные для API
        $predResponseJson = $this->predRestApiStep();

        //Обращаемся к API
        $responseJson = $this->restApiCalculateStepAll($predResponseJson, $this->urlApiRequest);

        //Обработка данных от сервера
        $arResult = $this->restApiStepAnswer($responseJson);


        return $arResult;
    }


    /**
     * Обработка ответа от API
     *
     * @param $massDogs
     *
     * @return $arResult
     */
    public function restApiStepAnswer($responseJson,$massInputs)
    {

    }


    /**
     * Функция формирования arResult и результатов ответа на запрос
     *
     * @return $arResult
     */
    public function makeResult()
    {

    }



    /**
    * Функция Выбирает из базы Свойства по ID местоположений
    */
    public static function getCountryCity($masIDMestopolojenie)
    {

        if (\CModule::IncludeModule('sale')) {
            $masCountryCity = [];
            $masPropertyAllCity = [];
            $masIDCountry = [];
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE'), //, 'TYPE_CODE' => 'CITY',
                'filter' => array(
                        '=NAME.LANGUAGE_ID' => LANGUAGE_ID,
                        'ID' => $masIDMestopolojenie
                    )
            ));
            while ($item = $res->fetch()) {
                $masIDCountry[$item["COUNTRY_ID"]] = 'yes';
                $masPropertyAllCity[$item["ID"]] = $item;
                //массив стран с вложенными городами
                $masC = $masCountryCity[$item["COUNTRY_ID"]];
                if (!$masC) {
                    $masCountryCity[$item["COUNTRY_ID"]]["ID"] = $item["COUNTRY_ID"];
                    $masCountryCity[$item["COUNTRY_ID"]]["NAME"] = '';
                    $masCountryCity[$item["COUNTRY_ID"]]["CITY"] = [$item["CITY_ID"]];
                } else {
                    $masCountryCity[$item["COUNTRY_ID"]]["CITY"][] = $item["CITY_ID"];
                }

            }
            $masIDCountryKeys = array_keys($masIDCountry);
            return [$masPropertyAllCity,$masCountryCity,$masIDCountryKeys];
        }
    }



    /**
    * Функция Выбирает из базы свойства для Стран
    */
    public static function getCountryProperty($masIDCountry,$masCountryCity = [])
    {
        if (\CModule::IncludeModule('sale')) {

            $masPropertyCountry = [];
            $res = \Bitrix\Sale\Location\LocationTable::getList(array(
                'select' => array('*', 'NAME_RU' => 'NAME.NAME', 'TYPE_CODE' => 'TYPE.CODE'),
                'filter' => array('=NAME.LANGUAGE_ID' => LANGUAGE_ID, 'TYPE_CODE' => 'COUNTRY', 'ID' => $masIDCountry )
            ));
            while($item = $res->fetch())
            {
                $masPropertyCountry[$item["ID"]] = $item;
                $masCountryCity[$item["ID"]]["NAME"] = $item["NAME_RU"];
            }

            return [$masPropertyCountry,$masCountryCity];

        }
    }



    /**
     * Берем масив элементов из highload блока
     */
    public static function getMasHighloadElements($idHighloadBlock, $masElements = [])
    {


        if (Loader::includeModule('highloadblock') && $idHighloadBlock) {

            $hlblock = HL\HighloadBlockTable::getById($idHighloadBlock)->fetch(); // id highload блока
            $entity = HL\HighloadBlockTable::compileEntity($hlblock);
            $entityClass = $entity->getDataClass();
            $masParamsAll = [];
            //===========
            $arFilter = array();
            if(!empty($masElements)) {
                $arFilter = array("ID" => $masElements);
            }
            //===========
            $rsData = $entityClass::getList(array(
                'select' => array('*'),
                'filter' => $arFilter
            ));
            while ($el = $rsData->fetch()) {
                $masParamsAll[$el['ID']] = $el;
            }

            return $masParamsAll;
        }

    }



}
