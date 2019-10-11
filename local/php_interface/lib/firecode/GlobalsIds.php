<?php


namespace Firecode;


class GlobalsIds
{

    /**
     * ID Свойства элементов инфоблока Собак в котором хранится привязка к Местоположению
     * @var Int
     */
    const CONST_ID_CITY_MESTOPOLOJENIE = 47;  // \Firecode\GlobalsIds::CONST_ID_CITY_MESTOPOLOJENIE;
    //-----------
    /**
     * ID Свойства элементов инфоблока Собак в котором хранится ID Страны
     * @var Int
     */
    const CONST_ID_COUNTRY_MESTOPOLOJENIE = 49;  // \Firecode\GlobalsIds::CONST_ID_CITY_MESTOPOLOJENIE;
    //-----------
    /**
     * ID инфоблока собак
     * @var Int
     */
    const CONST_ID_IBLOCK_DOGS = 5;
    //-----------
    /**
     * ID инфоблока FenotypicTraits
     * @var Int
     */
    const CONST_ID_IBLOCK_FENOTYPIC_TRAITS = 1;
    //-----------
    /**
     * ID highload блока пород
     * @var Int
     */
    const CONST_ID_HIGHLOAD_BLOCK_BREED = 1;
    //-----------
    /**
     * Массив с группами по подписке
     * @var Int
     */
    const CONST_MAS_GROUP_PODPISKA = [9, 10, 11];
    //-----------
    /**
     * URL Для обращения к API калькулятора
     * @var Int
     */
    const CONST_URL_API_REQUEST_STEP_ONE = 'http://78.47.159.234:34005/calc/interface/get_feno_chance';
    const CONST_URL_API_REQUEST_STEP_TWO = 'http://78.47.159.234:34005/calc/interface/get_dogs_for_feno';
    const CONST_URL_API_REQUEST_STEP_THREE = 'http://78.47.159.234:34005/calc/interface/get_feno_for_genes';
    const CONST_URL_API_REQUEST_STEP_FOUR = 'http://78.47.159.234:34005/calc/interface/get_parents_for_genes';
    //-----------
    /**
     * ID значения списка пола собаки
     * @var Int
     */
    const CONST_ID_PROP_SEX_MALE = 4;
    const CONST_ID_PROP_SEX_FEMALE = 5;
    //-----------
    /**
     * Массив свойств ген
     * @var Int
     */
    const CONST_MAS_GEN_PROPERTY = [
        'PROP_AGOUTIL1',
        'PROP_AGOUTIL2',
        'PROP_BROWN1',
        'PROP_BROWN2',
        'PROP_DILUTE1',
        'PROP_DILUTE2',
        'PROP_DOMINANTBLACK1',
        'PROP_DOMINANTBLACK2',
        'PROP_MCR11',
        'PROP_MCR12',
        'PROP_PIED1',
        'PROP_PIED2'];
    //-----------

}