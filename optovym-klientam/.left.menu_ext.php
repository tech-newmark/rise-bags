<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

global $APPLICATION;

$aMenuLinksExt = $APPLICATION->IncludeComponent(
  "custom:menu.sections.elements",
  "",
  array(
    "CACHE_TIME" => "36000000",
    "CACHE_TYPE" => "A",
    "DEPTH_LEVEL" => "3",
    "IBLOCK_ID" => "13",
    "IBLOCK_TYPE" => "site_content",
    "IS_SEF" => "Y",
    "SEF_BASE_URL" => "/optovym-klientam/",
  ),
  false
);

$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
