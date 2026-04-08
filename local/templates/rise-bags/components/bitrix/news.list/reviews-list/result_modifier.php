<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$years = [];

foreach ($arResult["ITEMS"] as $arItem) {
    if (!empty($arItem['DISPLAY_ACTIVE_FROM'])) {
        debug($arItem['DISPLAY_ACTIVE_FROM']);
    }
}
