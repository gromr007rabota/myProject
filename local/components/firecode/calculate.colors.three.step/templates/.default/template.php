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

<form action="javascript:void(0);" onsubmit="ajaxColorLocation(this,'step3.php')" style=display:none;">
    <?= bitrix_sessid_post() ?>
    <input hidden name="SUBMIT_COLOR_STEP_THREE" value="yes">
    <input hidden class="submit_color_step_three" type="submit">
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


                <?foreach($arResult["MAS_ALL_FENOTYPIC_TRAITS"] as $masProps):?>
                    <div class="calculator__color-blocks__checkbox-block " style="background:<?=$masProps["PROP_COLOR"]["VALUE"]?>">
                        <input class="calculator__color-blocks__checkbox-block__input" id="color_<?=$masProps["ID"]?>" type="checkbox" value="<?=$masProps["ID"]?>"/>
                        <label class="calculator__color-blocks__checkbox-block__text" for="color_<?=$masProps["ID"]?>"><?=$masProps["NAME"]?></label>
                        <span style="display:none;" class="picture"><?=$masProps["PREVIEW_PICTURE_PATH"]?></span>
                    </div>

                <?endforeach;?>


        <?
        $resMessage = trim(ob_get_contents());
        ob_end_clean();
        $resMessageJson = json_encode($resMessage);
        ?>


        <?
        $APPLICATION->RestartBuffer();
        echo '{"status":"' . $arResult["resultStatus"] . '","html1":' . $resMessageJson . '}';
        die();
        ?>
    <? endif ?>

<? else: ?>


        <article class="calculator__color-blocks">
            <h3 class="calculator__color-blocks__title">Colors</h3>

            <div class="calculator__color-blocks__wrap" data-colors-block >

            </div>

            <div class="calculator__color-blocks__choose-colors">
                <div class="calculator__color-blocks__choose-colors__item-wrap">
                    <p class="calculator__color-blocks__choose-colors__item calculator__color-blocks__choose-colors__color_first">Drag and drop <span class="dark"> color 1 </span> here</p>

                    <input hidden="" class="color_one_female_step_three" value="1">
                </div>
                <div class="calculator__color-blocks__choose-colors__item-wrap">
                    <p class="calculator__color-blocks__choose-colors__item calculator__color-blocks__choose-colors__color_second">Drag and drop <span class="dark"> color 2 </span> here</p>

                    <input hidden="" class="color_two_female_step_three" value="39">
                </div>
                <div class="calculator__color-blocks__choose-colors__item-wrap">
                    <p class="calculator__color-blocks__choose-colors__item calculator__color-blocks__choose-colors__color_third">Drag and drop <span class="dark"> color 3 </span> here</p>

                    <input hidden="" class="color_three_female_step_three" value="40">
                </div>
            </div>
        </article>

<? endif ?>