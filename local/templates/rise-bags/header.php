<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_TEMPLATE_PATH ?>/favicon.ico" />

  <? $APPLICATION->ShowHead(); ?>
  <title><? $APPLICATION->ShowTitle() ?></title>

  <?
  includeGlobalAssets();
  initBitrixCore('popup');

  $curPage = $APPLICATION->GetCurPage();
  ?>

</head>

<body>
  <div id="panel"><? $APPLICATION->ShowPanel(); ?></div>

  <?
  $APPLICATION->IncludeComponent(
    "bitrix:eshop.banner",
    "",
    array()
  ); ?>

  <header class="header">
    <div class="container">
      <div class="header__top">
        <a href="/" class="header__logo" aria-label="На главную страницу">
          <img src="<?= SITE_TEMPLATE_PATH ?>/_dist/images/logo-colored.svg" alt="" width="167" height="100">
        </a>

        <div class="header__top-row">
          <? $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "simple-row",
            [
              "ROOT_MENU_TYPE" => "top.simple",
              "MENU_CACHE_TYPE" => "A",
              "MENU_CACHE_TIME" => "36000000",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_THEME" => "site",
              "CACHE_SELECTED_ITEMS" => "N",
              "MENU_CACHE_GET_VARS" => [],
              "MAX_LEVEL" => "1",
              "CHILD_MENU_TYPE" => "",
              "USE_EXT" => "N",
              "DELAY" => "N",
              "ALLOW_MULTI_SELECT" => "N",
              "COMPONENT_TEMPLATE" => "simple-row"
            ],
            false
          ); ?>

          <div class="contact-block">
            <div class="contact-block__section">
              <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
                <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-phone'></use>
              </svg>

              <a href="tel:+78125429154">+7 (812) 542-91-54</a>
              <a href="tel:+79633227552">+7 (963) 322-75-52</a>
            </div>

            <div class="contact-block__section">
              <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
                <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-mail'></use>
              </svg>
              <a href="mailto:support@rise-bags.ru">support@rise-bags.ru</a>
            </div>
          </div>

          <button class="main-btn outlined" data-form-id="1">Стать партнером</button>
        </div>

        <div class="header__top-row">

          <?
          $APPLICATION->IncludeComponent(
            "bitrix:menu",
            "catalog-menu",
            [
              "ROOT_MENU_TYPE" => "left",
              "MENU_CACHE_TYPE" => "N",
              "MENU_CACHE_TIME" => "36000000",
              "MENU_CACHE_USE_GROUPS" => "Y",
              "MENU_CACHE_GET_VARS" => [],
              "MAX_LEVEL" => "3",
              "CHILD_MENU_TYPE" => "left",
              "USE_EXT" => "Y",
              "ALLOW_MULTI_SELECT" => "N",
              "COMPONENT_TEMPLATE" => "catalog-menu",
              "DELAY" => "N"
            ],
            false
          );
          ?>

          <?php
          if ($curPage != SITE_DIR . "index.php"):
            if (\Bitrix\Main\ModuleManager::isModuleInstalled('search')):
          ?>
              <? $APPLICATION->IncludeComponent(
                "bitrix:search.title",
                "search-title",
                [
                  "NUM_CATEGORIES" => "1",
                  "TOP_COUNT" => "5",
                  "CHECK_DATES" => "N",
                  "SHOW_OTHERS" => "N",
                  "PAGE" => SITE_DIR . "catalog/",
                  "CATEGORY_0_TITLE" => GetMessage("SEARCH_GOODS"),
                  "CATEGORY_0" => [
                    0 => "iblock_catalog",
                  ],
                  "CATEGORY_0_iblock_catalog" => [
                    0 => "all",
                  ],
                  "CATEGORY_OTHERS_TITLE" => GetMessage("SEARCH_OTHER"),
                  "SHOW_INPUT" => "Y",
                  "INPUT_ID" => "title-search-input",
                  "CONTAINER_ID" => "search",
                  "PRICE_CODE" => [
                    0 => "BASE",
                  ],
                  "SHOW_PREVIEW" => "Y",
                  "PREVIEW_WIDTH" => "75",
                  "PREVIEW_HEIGHT" => "75",
                  "CONVERT_CURRENCY" => "Y",
                  "COMPONENT_TEMPLATE" => "search-title",
                  "ORDER" => "date",
                  "USE_LANGUAGE_GUESS" => "Y"
                ],
                false
              ); ?>
          <?php
            endif;
          endif;
          ?>

          <!-- <div class="btn-group">
          </div> -->
          <? $APPLICATION->IncludeComponent(
	"bitrix:sale.basket.basket.line", 
	"header-basket-line", 
	[
		"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
		"PATH_TO_PERSONAL" => SITE_DIR."personal/",
		"SHOW_PERSONAL_LINK" => "N",
		"SHOW_NUM_PRODUCTS" => "Y",
		"SHOW_TOTAL_PRICE" => "N",
		"SHOW_PRODUCTS" => "N",
		"POSITION_FIXED" => "N",
		"SHOW_AUTHOR" => "Y",
		"PATH_TO_REGISTER" => SITE_DIR."login/",
		"PATH_TO_PROFILE" => SITE_DIR."personal/private/",
		"COMPONENT_TEMPLATE" => "header-basket-line",
		"PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
		"SHOW_EMPTY_VALUES" => "N",
		"PATH_TO_AUTHORIZE" => SITE_DIR."auth/",
		"SHOW_REGISTRATION" => "N",
		"SHOW_DELAY" => "Y",
		"SHOW_NOTAVAIL" => "Y",
		"SHOW_IMAGE" => "Y",
		"SHOW_PRICE" => "Y",
		"SHOW_SUMMARY" => "Y",
		"POSITION_HORIZONTAL" => "right",
		"POSITION_VERTICAL" => "vcenter",
		"HIDE_ON_BASKET_PAGES" => "N",
		"MAX_IMAGE_SIZE" => "80"
	],
	false
); ?>

          <button class="search-title-opener" aria-label="Открыть поиск">
            <svg width="24" height="24" viewBox="0 0 24 24" role="img" aria-hidden="true" focusable="false">
              <use xlink:href="<?= SITE_TEMPLATE_PATH  . '/_dist/sprite.svg#icon-search' ?>"></use>
            </svg>
          </button>
          <button class="main-btn callback-btn" data-form-id="1">Заказать звонок</button>

          <button class="menu-opener">
            <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
              <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-burger'></use>
            </svg>
          </button>
        </div>
      </div>
    </div>
    <div class="header__bottom">
      <div class="container">
        <? $APPLICATION->IncludeComponent(
          "bitrix:menu",
          "horizontal_multilevel",
          [
            "ROOT_MENU_TYPE" => "top",
            "MENU_CACHE_TYPE" => "A",
            "MENU_CACHE_TIME" => "36000000",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_THEME" => "site",
            "CACHE_SELECTED_ITEMS" => "N",
            "MENU_CACHE_GET_VARS" => [],
            "MAX_LEVEL" => "2",
            "CHILD_MENU_TYPE" => "top",
            "USE_EXT" => "Y",
            "DELAY" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "COMPONENT_TEMPLATE" => "horizontal_multilevel"
          ],
          false
        ); ?>
      </div>
    </div>
    </div>
  </header>

  <main id="workarea" class="workarea">
    <?

    if ($curPage != '/' && !defined("ERROR_404")) {
      $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "lw-breadcrumb",
        [
          "PATH" => "",
          "SITE_ID" => "s1",
          "START_FROM" => "0",
          "COMPONENT_TEMPLATE" => "lw-breadcrumb"
        ],
        false
      );
    }
    ?>