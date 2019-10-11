<? if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true) die(); ?>
<?
use Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Diag\Debug;

?>
<?php

    //============================================
    //============================================
    // Количество лет, месяцев и дней, прошедших со дня рождения
    function birthday($secBirthday)
    {
        // Сегодняшняя дата
        $secNow = time();
        // Подсчитываем количество месяцев, лет
        for($time = $secBirthday, $month = 0;
            $time < $secNow;
            $time = $time + date('t', $time) * 86400, $month++){
            $rtime = $time;
        }
        $month = $month - 1;
        // Количество лет
        $year = intval($month / 12);
        // Количество месяцев
        $month = $month % 12;
        // Количество дней
        $day = intval(($secNow - $rtime) / 86400);
        $result = '';
        if($year > 0)
            $result .= declination($year, "y", "y", "y")." ";
        if($month > 0)
            $result .= declination($month, "m", "m", "m")." ";
        return $result;
    }

    //============================================
    // Склонение числа $num // $one="статья";// $ed="статьи";// $mn="статей";
    function declination($num, $one, $ed, $mn, $notnumber = false)
    {

        if($num === "") print "";
        if(($num == "0") or (($num >= "5") and ($num <= "20")) or preg_match("|[056789]$|",$num))
            if(!$notnumber)
                return "$num $mn";
            else
                return $mn;
        if(preg_match("|[1]$|",$num))
            if(!$notnumber)
                return "$num $one";
            else
                return $one;
        if(preg_match("|[234]$|",$num))
            if(!$notnumber)
                return "$num $ed";
            else
                return $ed;
    }







