<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {die();} ?>
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

<form action="javascript:void(0);" onsubmit="ajaxSendCalculator(this,'step3.php')">
    <?= bitrix_sessid_post() ?>
    <input hidden name="SUBMIT_CALCULATE_STEP_THREE" value="yes">
    <input hidden class="submit_calculate_step_three" type="submit">

    <input hidden class="form_api_gen_female" name="GEN_FEMALE" value="">
    <input hidden class="form_api_city_male" name="CITY_MALE" value="">
    <input hidden class="form_api_color_one" name="COLOR_ONE" value="">
    <input hidden class="form_api_color_two" name="COLOR_TWO" value="">
    <input hidden class="form_api_color_three" name="COLOR_THREE" value="">

    <a class="button calculator__calculate-button" href="javascript:void(0)"
       onclick="$('.submit_calculate_step_three').submit();">
        Search for a male
    </a>
</form>


<? if ($arResult["resultStepThree"]): ?>
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
                    <h1 class="calculator__result-dogs__title">Results</h1>
                    <div class="calculator__result-dogs__header-wrap">
                        <div class="calculator__result-dogs__header-wrap__content calculator__result-dogs__header-wrap__content_v2">
                            <p class="calculator__result-dogs__header-wrap__content_v2-cell calculator__result-dogs__header-wrap__content-cell">Male</p>
                            <p class="calculator__result-dogs__header-wrap__content_v2-cell calculator__result-dogs__header-wrap__content-cell">Female</p>
                            <p class="calculator__result-dogs__header-wrap__content_v2-cell calculator__result-dogs__header-wrap__content-cell">Вероятность окраса, %</p>
                        </div>
                    </div>
                    <div class="calculator__result-dogs__body">
                        <div class="calculator__result-dogs__body__row calculator__result-dogs__body__row_v2">
                            <div class="calculator__result-dogs_v2__body__cell">
                                <div class="calculator__gender-blocks__item__body__dog-block_v2">
                                    <div class="calculator__gender-blocks__item__body__image" style="background-image: url(<?=SITE_TEMPLATE_PATH;?>/img/puppy1.png)"></div>
                                    <div class="calculator__gender-blocks__item__body__dog-block__body">
                                        <h5 class="calculator__gender-blocks__item__body__dog-block__title">Lily</h5>
                                        <div class="calculator__gender-blocks__item__body__dog-block__info">
                                            <div class="calculator__gender-blocks__item__body__dog-block__info-wrapper">
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-breed">Moscow,</p>
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-birthdate">Russian Federation</p>
                                            </div>
                                        </div>
                                        <div class="calculator__gender-blocks__item__body__dog-block__genom-wrapper">
                                            <p class="calculator__gender-blocks__item__body__dog-block__genom-wrapper__gens">AtAy b Dd KbrKy eEm N</p>
                                        </div>
                                        <svg class="calculator__gender-blocks__item__body__dog-block__info-gender male">
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-male"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="calculator__result-dogs_v2__body__cell">
                                <div class="calculator__gender-blocks__item__body__dog-block_v2">
                                    <div class="calculator__gender-blocks__item__body__image" style="background-image: url(<?=SITE_TEMPLATE_PATH;?>/img/puppy1.png)"></div>
                                    <div class="calculator__gender-blocks__item__body__dog-block__body">
                                        <h5 class="calculator__gender-blocks__item__body__dog-block__title">Lily</h5>
                                        <div class="calculator__gender-blocks__item__body__dog-block__info">
                                            <div class="calculator__gender-blocks__item__body__dog-block__info-wrapper">
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-breed">Moscow,</p>
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-birthdate">Russian Federation</p>
                                            </div>
                                        </div>
                                        <div class="calculator__gender-blocks__item__body__dog-block__genom-wrapper">
                                            <p class="calculator__gender-blocks__item__body__dog-block__genom-wrapper__gens">AtAy b Dd KbrKy eEm N</p>
                                        </div>
                                        <svg class="calculator__gender-blocks__item__body__dog-block__info-gender female">
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-female"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="calculator__result-dogs_v2__body__cell">
                                <div class="calculator__result-dogs_v2__body__cell__color-table">
                                    <div class="calculator__result-dogs_v2__body__cell__color-table__row">
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">cream</div>
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">6.25</div>
                                    </div>
                                    <div class="calculator__result-dogs_v2__body__cell__color-table__row">
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">chocolate trindle pied</div>
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">15.63</div>
                                    </div>
                                    <div class="calculator__result-dogs_v2__body__cell__color-table__row">
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">solid lilac</div>
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">9.38</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="calculator__result-dogs__body__row calculator__result-dogs__body__row_v2">
                            <div class="calculator__result-dogs_v2__body__cell">
                                <div class="calculator__gender-blocks__item__body__dog-block_v2">
                                    <div class="calculator__gender-blocks__item__body__image" style="background-image: url(<?=SITE_TEMPLATE_PATH;?>/img/puppy1.png)"></div>
                                    <div class="calculator__gender-blocks__item__body__dog-block__body">
                                        <h5 class="calculator__gender-blocks__item__body__dog-block__title">Lily</h5>
                                        <div class="calculator__gender-blocks__item__body__dog-block__info">
                                            <div class="calculator__gender-blocks__item__body__dog-block__info-wrapper">
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-breed">Moscow,</p>
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-birthdate">Russian Federation</p>
                                            </div>
                                        </div>
                                        <div class="calculator__gender-blocks__item__body__dog-block__genom-wrapper">
                                            <p class="calculator__gender-blocks__item__body__dog-block__genom-wrapper__gens">AtAy b Dd KbrKy eEm N</p>
                                        </div>
                                        <svg class="calculator__gender-blocks__item__body__dog-block__info-gender male">
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-male"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="calculator__result-dogs_v2__body__cell">
                                <div class="calculator__gender-blocks__item__body__dog-block_v2">
                                    <div class="calculator__gender-blocks__item__body__image" style="background-image: url(<?=SITE_TEMPLATE_PATH;?>/img/puppy1.png)"></div>
                                    <div class="calculator__gender-blocks__item__body__dog-block__body">
                                        <h5 class="calculator__gender-blocks__item__body__dog-block__title">Lily</h5>
                                        <div class="calculator__gender-blocks__item__body__dog-block__info">
                                            <div class="calculator__gender-blocks__item__body__dog-block__info-wrapper">
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-breed">Moscow,</p>
                                                <p class="calculator__gender-blocks__item__body__dog-block__info-wrapper__text calculator__gender-blocks__item__body__dog-block__info-wrapper__text-birthdate">Russian Federation</p>
                                            </div>
                                        </div>
                                        <div class="calculator__gender-blocks__item__body__dog-block__genom-wrapper">
                                            <p class="calculator__gender-blocks__item__body__dog-block__genom-wrapper__gens">AtAy b Dd KbrKy eEm N</p>
                                        </div>
                                        <svg class="calculator__gender-blocks__item__body__dog-block__info-gender female">
                                            <use xlink:href="<?=SITE_TEMPLATE_PATH;?>/img/symbol_sprite.svg#icon-female"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="calculator__result-dogs_v2__body__cell">
                                <div class="calculator__result-dogs_v2__body__cell__color-table">
                                    <div class="calculator__result-dogs_v2__body__cell__color-table__row">
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">cream</div>
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">6.25</div>
                                    </div>
                                    <div class="calculator__result-dogs_v2__body__cell__color-table__row">
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">chocolate trindle pied</div>
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">15.63</div>
                                    </div>
                                    <div class="calculator__result-dogs_v2__body__cell__color-table__row">
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">solid lilac</div>
                                        <div class="calculator__result-dogs_v2__body__cell__color-table__cell">9.38</div>
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

