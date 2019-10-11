<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>
<?
/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @var $templateFolder
 *
 *
 */
?>
<?
CJSCore::Init(array("core", "jquery", "ajax")) ?>

<form action="javascript:void(0);" onsubmit="ajaxSendCalculator(this,'index.php')">
    <?= bitrix_sessid_post() ?>
    <input hidden name="SUBMIT_CALCULATE_STEP_ONE" value="yes">
    <input hidden class="MASS_MALE_ID" name="MASS_MALE_ID" value="">
    <input hidden class="MASS_FEMALE_ID" name="MASS_FEMALE_ID" value="">
    <input hidden class="submit_calculate_step_one" type="submit">
    <a class="button calculator__calculate-button" href="javascript:void(0)"
       onclick="$('.submit_calculate_step_one').submit();">
        Forecast offspring of my dogs
    </a>
</form>



<? if ($arResult["resultStepOne"]): ?>
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


                    <?
                    foreach ($arResult["rowResultCalcStepOne"] as $itemRow) {
                        ?>


                        <div class="calculator__result-dogs__body__wrap">
                            <div class="calculator__result-dogs__body__row">
                                <div class="calculator__result-dogs__body__cell">
                                    <div class="calculator__result-dogs__body__cell__dog-block">
                                        <div class="calculator__result-dogs__body__cell__dog-block__image"
                                             style="background-image: url(<?= $arResult["propertyDogAll"][$itemRow["male_id"]]["PREVIEW_PICTURE_PATH"] ?>)"></div>
                                        <div class="calculator__result-dogs__body__cell__dog-block__body">
                                            <h5 class="calculator__result-dogs__body__cell__dog-block__title"><?= $arResult["propertyDogAll"][$itemRow["male_id"]]["NAME"] ?></h5>
                                            <div class="calculator__result-dogs__body__cell__dog-block__info">
                                                <div class="calculator__result-dogs__body__cell__dog-block__info-wrapper">
                                                    <p class="calculator__result-dogs__body__cell__dog-block__info-wrapper__text calculator__result-dogs__body__cell__dog-block__info-wrapper__text-breed">
                                                        <?= $arResult["propertyDogAll"][$itemRow["male_id"]]["PROP_BREED"]["NAME_REAL"]["UF_NAME"] ?>
                                                    </p>
                                                    <p class="calculator__result-dogs__body__cell__dog-block__info-wrapper__text calculator__result-dogs__body__cell__dog-block__info-wrapper__text-birthdate">
                                                        <?= $birthdayResult = birthday(strtotime($arResult["propertyDogAll"][$itemRow["male_id"]]["PROP_BIRTHDAY"]["VALUE"])) ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="calculator__result-dogs__body__cell__dog-block__genom-wrapper">
                                                <p class="calculator__result-dogs__body__cell__dog-block__genom-wrapper__gens">

                                                    <?= $arResult["propertyDogAll"][$itemRow["male_id"]]["TEXT_GEN_ALL"] ?>
                                                </p>
                                                <div class="help js_help">
                                                    <svg class="icon">
                                                        <use xlink:href="<?= SITE_TEMPLATE_PATH; ?>/img/symbol_sprite_default.svg#icon-help"></use>
                                                    </svg>
                                                    <a class="help__link js_help-block" href="">
                                                        <p class="text">About genotype</p>
                                                        <svg class="arrow">
                                                            <use xlink:href="<?= SITE_TEMPLATE_PATH; ?>/img/symbol_sprite.svg#icon-arrow-right"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <svg class="calculator__result-dogs__body__cell__dog-block__info-gender male">
                                                <use xlink:href="<?= SITE_TEMPLATE_PATH; ?>/img/symbol_sprite.svg#icon-male"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="calculator__result-dogs__body__cell">
                                    <div class="calculator__result-dogs__body__cell__dog-block">
                                        <div class="calculator__result-dogs__body__cell__dog-block__image"
                                             style="background-image: url(<?= $arResult["propertyDogAll"][$itemRow["female_id"]]["PREVIEW_PICTURE_PATH"] ?>)"></div>
                                        <div class="calculator__result-dogs__body__cell__dog-block__body">
                                            <h5 class="calculator__result-dogs__body__cell__dog-block__title"><?= $arResult["propertyDogAll"][$itemRow["female_id"]]["NAME"] ?></h5>
                                            <div class="calculator__result-dogs__body__cell__dog-block__info">
                                                <div class="calculator__result-dogs__body__cell__dog-block__info-wrapper">
                                                    <p class="calculator__result-dogs__body__cell__dog-block__info-wrapper__text calculator__result-dogs__body__cell__dog-block__info-wrapper__text-breed">
                                                        <?= $arResult["propertyDogAll"][$itemRow["female_id"]]["PROP_BREED"]["NAME_REAL"]["UF_NAME"] ?>
                                                    </p>
                                                    <p class="calculator__result-dogs__body__cell__dog-block__info-wrapper__text calculator__result-dogs__body__cell__dog-block__info-wrapper__text-birthdate">
                                                        <?= $birthdayResult = birthday(strtotime($arResult["propertyDogAll"][$itemRow["female_id"]]["PROP_BIRTHDAY"]["VALUE"])) ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="calculator__result-dogs__body__cell__dog-block__genom-wrapper">
                                                <p class="calculator__result-dogs__body__cell__dog-block__genom-wrapper__gens">

                                                    <?= $arResult["propertyDogAll"][$itemRow["female_id"]]["TEXT_GEN_ALL"] ?>
                                                </p>
                                                <div class="help js_help">
                                                    <svg class="icon">
                                                        <use xlink:href="<?= SITE_TEMPLATE_PATH; ?>/img/symbol_sprite_default.svg#icon-help"></use>
                                                    </svg>
                                                    <a class="help__link js_help-block" href="">
                                                        <p class="text">About genotype</p>
                                                        <svg class="arrow">
                                                            <use xlink:href="<?= SITE_TEMPLATE_PATH; ?>/img/symbol_sprite.svg#icon-arrow-right"></use>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                            <svg class="calculator__result-dogs__body__cell__dog-block__info-gender female">
                                                <use xlink:href="<?= SITE_TEMPLATE_PATH; ?>/img/symbol_sprite.svg#icon-female"></use>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="calculator__result-dogs__body__cell">
                                    <div class="calculator__result-dogs__body__cell__colors-table">

                                        <?
                                        foreach ($itemRow["chances"] as $masPropChances) {

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

                        <?
                    }
                    ?>


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

