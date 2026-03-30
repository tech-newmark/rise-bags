<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>

<section class="linked-articles">
	<div class="linked-articles__header">
		<h2><?= $arParams["TITLE_IN_LINKED_ARTICLES"] ? $arParams["TITLE_IN_LINKED_ARTICLES"] : 'Рекомендуем' ?></h2>
		<? if ($arParams["DESC_IN_LINKED_ARTICLES"]) : ?>
			<span><?= $arParams["DESC_IN_LINKED_ARTICLES"] ?></span>
		<? endif; ?>
		<a class="main-btn" href="<?= $arResult['LIST_PAGE_URL'] ?>"><span><?= $arParams["BUTTON_NAME_IN_LINKED_ARTICLES"] ? $arParams["BUTTON_NAME_IN_LINKED_ARTICLES"] : 'Смотреть все' ?></span></a>
	</div>
	<div class="linked-articles__list">
		<? foreach ($arResult["ITEMS"] as $arItem): ?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="linked-articles__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
				<? $APPLICATION->IncludeComponent(
					"bitrix:news.detail",
					"article-card",
					array(
						"ACTIVE_DATE_FORMAT" => "j F Y",
						"ADD_ELEMENT_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"BROWSER_TITLE" => "-",
						"CACHE_GROUPS" => "Y",
						"CACHE_TIME" => "36000000",
						"CACHE_TYPE" => "A",
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"DISPLAY_TOP_PAGER" => "N",
						"ELEMENT_CODE" => "",
						"ELEMENT_ID" => $arItem["ID"],
						"FIELD_CODE" => array("NAME", "PREVIEW_TEXT", "PREVIEW_PICTURE", "DETAIL_TEXT", "DETAIL_PICTURE", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", ""),
						"IBLOCK_ID" => "",
						"IBLOCK_TYPE" => "site_content",
						"IBLOCK_URL" => "",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"MESSAGE_404" => "",
						"META_DESCRIPTION" => "-",
						"META_KEYWORDS" => "-",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_TEMPLATE" => ".default",
						"PAGER_TITLE" => "Страница",
						"PROPERTY_CODE" => array("", ""),
						"SET_BROWSER_TITLE" => "N",
						"SET_CANONICAL_URL" => "N",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"SHOW_404" => "N",
						"STRICT_SECTION_CHECK" => "N",
						"USE_PERMISSIONS" => "N",
						"USE_SHARE" => "N",
						"DETAIL_PAGE_URL" => $arItem['DETAIL_PAGE_URL'],
						"SHOW_DATE_ACTIVE_FROM" => $arParams["SHOW_DATE_ACTIVE_FROM"],
						"SHOW_DATE_ACTIVE_TO" => $arParams["SHOW_DATE_ACTIVE_TO"],
					),
					$component,
					array("HIDE_ICONS" => "Y")
				); ?>
			</div>
		<? endforeach; ?>
	</div>
</section>