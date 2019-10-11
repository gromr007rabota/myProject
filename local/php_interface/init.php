<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//=================================================
    if(file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/functions.php")){
        include($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/functions.php');
    }

//=================================================

    \Bitrix\Main\Loader::registerAutoLoadClasses(
        null,
        array(
            'BullDna\Api' => '/local/php_interface/lib/bulldna/Api.php',
            'Firecode\GlobalsIds' => '/local/php_interface/lib/firecode/GlobalsIds.php',
            'Firecode\CalculateComponents' => '/local/php_interface/lib/firecode/CalculateComponents.php',
            'Firecode\Events' => '/local/php_interface/lib/firecode/Events.php',
        )
    );


//=================================================

    AddEventHandler("main", "OnBeforeProlog", "CheckTarifPermissions", 50);

    function CheckTarifPermissions()
    {
        global $USER;
        $arGroups = [];$trial = '';
        $res = CUser::GetUserGroupList($USER->GetID());
        while ($arGroup = $res->Fetch()){
            if (($arGroup['GROUP_ID'] == 10) || ($arGroup['GROUP_ID'] == 11) || ($arGroup['GROUP_ID'] == 9)){
                $rsGroup = CGroup::GetByID($arGroup['GROUP_ID']);
                $arG = $rsGroup->Fetch();
                $from = new DateTime($arGroup['DATE_ACTIVE_FROM']);
                $to = new DateTime($arGroup['DATE_ACTIVE_TO']);
                $today = new DateTime();
                $total_days = $from->diff($to);
                $remaining_days = $today->diff($to);
                if ($remaining_days->format('%R') == "+") {
                    $trial = ($arG['ID'] == 9) ? true : false;
                    $diff_total = intval($total_days->days);
                    $diff_remaining = intval($remaining_days->days);
                    $arGroups = array('NAME' => $arG['NAME'], 'TOTAL_DAYS' => $diff_total, 'REMAINING_DAYS' => $diff_remaining);
                }
            }
        }
        $_SESSION['groups'] = $arGroups;
        $_SESSION['trial'] = $trial;
        $_SESSION['dogs'] = 0;
        if (CModule::IncludeModule("iblock")){
            $arSelect = Array("ID");
            $arFilter = Array("IBLOCK_ID" => 5, "CREATED_BY" => $USER->GetID());
            $_SESSION['dogs'] = CIBlockElement::GetList($arSelect, $arFilter, [], Array("nPageSize" => 50), $arSelect);
        }
    }

//=================================================
// регистрируем обработчик для Добавления ID страны при выборе местоположения при изменении элемента Инфоблока
    AddEventHandler("iblock", "OnStartIBlockElementUpdate", Array("Firecode\Events", "startIBlockUpdateCountryMestopolojenie"));


