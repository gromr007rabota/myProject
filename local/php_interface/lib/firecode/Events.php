<?php
/**
 */

namespace Firecode;

use \Bitrix\Main\Loader;
use \Bitrix\Main\Diag\Debug;
use \Firecode\GlobalsIds;
use \Firecode\CalculateComponents;


class Events
{

    //Для логирования
        //Debug::writeToFile($idCityMestopolojenie, "RRRR3", "/local/var/log/onIBlockElement.log");


    // создаем обработчик события "OnStartIBlockElementUpdate"
    function startIBlockUpdateCountryMestopolojenie(&$arParams)
        {
        if ($arParams)
            {
                $idCityMestopolojenie = GlobalsIds::CONST_ID_CITY_MESTOPOLOJENIE;
                $idCountryMestopolojenie = GlobalsIds::CONST_ID_COUNTRY_MESTOPOLOJENIE;


                foreach($arParams["PROPERTY_VALUES"][$idCityMestopolojenie] as $idUnknown => $masProperty) {
                    if($masProperty["VALUE"]) {

                        $masDrr = CalculateComponents::getCountryCity([$masProperty["VALUE"]]);

                        $idCountry = '';
                        if($masDrr[2][0])
                            {
                            $idCountry = $masDrr[2][0];
                            }

                        foreach($arParams["PROPERTY_VALUES"][$idCountryMestopolojenie] as $idUnknownCountry => $masPropertyCountry) {
                            $arParams["PROPERTY_VALUES"][$idCountryMestopolojenie][$idUnknownCountry]["VALUE"] = $idCountry;
                            break;
                        }


                    }
                    break;
                }

            }
        }



}

