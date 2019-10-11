<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {die();} ?>
<?
/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var $templateFolder
 *
 */
?>
<?CJSCore::Init(array("core", "jquery", "ajax")) ?>


<form action="javascript:void(0);" onsubmit="ajaxSendLocation(this,'step3.php')" style="display:none;">
    <?= bitrix_sessid_post() ?>
    <input hidden name="SUBMIT_LOCATE_STEP_THREE" value="yes">
    <input hidden class="submit_locate_step_three" type="submit">
</form>

<?if($arResult["FLAG_AJAX_REQUEST"] == 'yes'):?>

    <? if ($arResult["resultStatus"] == 'error'): ?>
        <?
        $APPLICATION->RestartBuffer();
        echo '{"status":"' . $arResult["resultStatus"] . '","message":"' . $arResult["resultMessage"] . '"}';
        die();
        ?>
    <? else: ?>

        <? ob_start(); ?>
            <?foreach($arResult["MAS_COUNTRY_CITY_TREE"] as $masPropCountr):?>
                <li class="item js_item" data-country id="countryRequest_<?=$masPropCountr["ID"]?>" data-id-city="<?=rawurlencode(json_encode($masPropCountr["CITY"]));?>" >
                    <?=$masPropCountr["NAME"]?>
                </li>
            <?endforeach;?>
        <?
        $resMessage = trim(ob_get_contents());
        ob_end_clean();
        $resMessageOneJson = json_encode($resMessage);
        ?>


        <? ob_start(); ?>
            <?foreach($arResult["MAS_PROPERTY_ALL_CITY"] as $masPropCity):?>
                <li class="item js_item" data-city id="cityRequest_<?=$masPropCity["ID"]?>"  >
                    <?=$masPropCity["NAME_RU"]?>
                </li>
            <?endforeach;?>
        <?
        $resMessage = trim(ob_get_contents());
        ob_end_clean();
        $resMessageTwoJson = json_encode($resMessage);
        ?>


        <?
        $APPLICATION->RestartBuffer();
        echo '{"status":"' . $arResult["resultStatus"] . '","html1":' . $resMessageOneJson . ',"html2":' . $resMessageTwoJson . '}';
        die();
        ?>
    <? endif ?>

<? else: ?>

        <div class="calculator__gender-blocks__item">
            <div class="calculator__gender-blocks__item__header male">
                <svg class="calculator__gender-blocks__item__icon">
                    <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-male"></use>
                </svg>
                <h4 class="calculator__gender-blocks__item__title">Males location</h4>
            </div>
            <div class="calculator__gender-blocks__item__body_location">
                <div class="dropbox js_box">
                    <p class="label js_show-list js_label">Country</p>
                    <ul class="list js_drop-list" data-country-container>
                        <li class="item js_item" data-country="" data-id-city="<?=rawurlencode(json_encode([]));?>">Any country</li>
                        <?foreach($arResult["MAS_COUNTRY_CITY_TREE"] as $masPropCountr):?>
                            <li class="item js_item" data-country id="countryRequest_<?=$masPropCountr["ID"]?>" data-id-city="<?=rawurlencode(json_encode($masPropCountr["CITY"]));?>" >
                                <?=$masPropCountr["NAME"]?>
                            </li>
                        <?endforeach;?>
                    </ul>
                    <svg class="icon js_show-list">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-down-arrow"></use>
                    </svg>
                    <input hidden="" class="country_male_step_three" value="237">
                </div>
                <div class="dropbox js_box">
                    <p class="label js_show-list js_label">City</p>
                    <ul class="list js_drop-list" data-city-container>
                        <li class="item js_item" data-city >Any city</li>
                        <?foreach($arResult["MAS_PROPERTY_ALL_CITY"] as $masPropCity):?>
                            <li class="item js_item" data-city id="cityRequest_<?=$masPropCity["ID"]?>"  >
                                <?=$masPropCity["NAME_RU"]?>
                            </li>
                        <?endforeach;?>
                    </ul>
                    <svg class="icon js_show-list">
                        <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-down-arrow"></use>
                    </svg>
                    <input hidden="" class="city_male_step_three" value="34345">
                </div>
            </div>
        </div>

<? endif ?>