<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {    die();} ?>
<?
/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var $templateFolder
 *
 */
?>
<?
CJSCore::Init(array("core", "jquery", "ajax")) ?>

<form action="javascript:void(0);" onsubmit="ajaxSendCalculator(this,'step2.php');">
    <?= bitrix_sessid_post() ?>
    <input hidden name="SUBMIT_CALCULATE_STEP_TWO" value="yes">
    <input hidden class="MASS_GENS" name="MASS_GENS" value="">
    <input hidden class="submit_calculate_step_two" type="submit">
    <a class="button calculator__calculate-button" href="javascript:void(0)"
       onclick="$('.submit_calculate_step_two').submit();">
        Offspring of my dogs
    </a>
</form>


<? if ($arResult["resultStepTwo"]): ?>
    <div id="calculator_result">
        <? if ($arResult["resultStatus"] == 'error'): ?>
            <?
            $APPLICATION->RestartBuffer();
            echo '{"status":"' . $arResult["resultStatus"] . '","message":"' . $arResult["resultMessage"] . '"}';
            die();
            ?>

        <? else: ?>

            <? ob_start(); ?>


            <div class="calculator__result-dogs">
                <h1 class="calculator__result-dogs__title">Offspring of my dogs</h1>
                <div class="calculator__result-dogs__header-wrap">
                    <div class="calculator__result-dogs__header-wrap__content">
                        <p class="calculator__result-dogs__header-wrap__content-cell">Male</p>
                        <p class="calculator__result-dogs__header-wrap__content-cell">Female</p>
                        <p class="calculator__result-dogs__header-wrap__content-cell">Вероятность окраса, %</p>
                    </div>
                </div>
                <div class="calculator__result-dogs__body">


                        <div class="calculator__result-dogs__body__wrap">
                            <div class="calculator__result-dogs__body__row">
                                <div class="calculator__result-dogs__body__cell">
                                    <div class="calculator__result-dogs__body__cell__dog-block">
                                        <div class="calculator__result-dogs__body__cell__dog-block__image" style="background: linear-gradient(0deg, #DAE6F2, #DAE6F2), #C2DAF2;">
                                            <svg class="calculator__result-dogs__body__cell__dog-block__image-icon">
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-male"></use>
                                            </svg>
                                        </div>
                                        <div class="calculator__result-dogs__body__cell__dog-block__body">
                                            <div class="calculator__result-dogs__body__cell__dog-block__genom-wrapper">
                                                <p class="calculator__result-dogs__body__cell__dog-block__genom-wrapper__gens">
                                                    <?=$arResult["rowResultStepTwoGenocodeMale"]?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="calculator__result-dogs__body__cell">
                                    <div class="calculator__result-dogs__body__cell__dog-block">
                                        <div class="calculator__result-dogs__body__cell__dog-block__image" style="background: linear-gradient(0deg, #F2DAE2, #F2DAE2), #F2C2D2;">
                                            <svg class="calculator__result-dogs__body__cell__dog-block__image-icon">
                                                <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-female"></use>
                                            </svg>
                                        </div>
                                        <div class="calculator__result-dogs__body__cell__dog-block__body">
                                            <div class="calculator__result-dogs__body__cell__dog-block__genom-wrapper">
                                                <p class="calculator__result-dogs__body__cell__dog-block__genom-wrapper__gens">
                                                    <?=$arResult["rowResultStepTwoGenocodeFemale"]?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="calculator__result-dogs__body__cell">
                                    <div class="calculator__result-dogs__body__cell__colors-table">


                                        <?
                                        foreach ($arResult["rowResultStepTwoChances"]["chances"] as $masPropChances) {

                                            ?>

                                            <div class="calculator__result-dogs__body__cell__colors-table__row">
                                                <p class="calculator__result-dogs__body__cell__colors-table__cell"><?= $masPropChances["name"] ?></p>
                                                <p class="calculator__result-dogs__body__cell__colors-table__cell-value"><?= $masPropChances["chance"] ?></p>
                                                <div class="calculator__result-dogs__body__cell__colors-table__cell__popup-image"
                                                     style="background-image:url(<?= SITE_TEMPLATE_PATH; ?>/img/puppy2.png)"></div>
                                            </div>

                                            <?
                                        }
                                        ?>


                                    </div>
                                </div>
                            </div>
                        </div>





                </div>
            </div>




            <?
            $resMessage = trim(ob_get_contents());
            ob_end_clean();
            $resMessageJson = json_encode($resMessage);
            ?>

            <?
            $APPLICATION->RestartBuffer();
            echo '{"status":"' . $arResult["resultStatus"] . '","message":' . $resMessageJson . '}';
            die();
            ?>


        <? endif ?>





    </div>
<? else: ?>
    <div id="calculator_result"></div>
<? endif ?>



