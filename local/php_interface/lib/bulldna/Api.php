<?php
/**
 * Created by PhpStorm.
 * User: serj
 * Date: 17.04.2019
 * Time: 21:06
 */

namespace BullDna;

use Bitrix\Main\Application;

class Api
{
    public function curl_post($func, $params){
        $url = 'http://78.47.159.234:34005/calc/interface/'.$func;
//        get_feno_chance
//Кейс 2:
//get_dogs_for_feno
//Кейс 3:
//get_feno_for_genes
//Кейс 4:
//get_parents_for_genes

        $fields = json_encode($params);

        $request_headers = [
            'Content-Type: application/json',
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);

        return $res;
    }


}