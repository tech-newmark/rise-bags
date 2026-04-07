<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
/* <?debug($arItem) ?>*/
?>
<? if ($arResult["ITEMS"]): ?>
	<section class="section reviews">
		<div class="container">
			<div class="reviews__header">
				<h1><?= $arResult['NAME'] ?></h1>
				<? if ($arResult['DESCRIPTION']): ?>
					<p><?= $arResult['DESCRIPTION'] ?></p>
				<? endif; ?>
			</div>
			<div class="reviews__list">
				<? foreach ($arResult["ITEMS"] as $index => $arItem): ?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<div class="reviews__list-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
						<? $APPLICATION->IncludeComponent(
							"custom:cards",
							"review-card",
							array(
								"TEMPLATE_DATA" => $arItem,
							),
							$component,
							array("HIDE_ICONS" => $index > 0 ?? "Y")
						); ?>
					</div>
				<? endforeach; ?>
				<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
					<?= $arResult["NAV_STRING"] ?>
				<? endif; ?>
			</div>
		</div>
	</section>

	<div class="modal-overlay">
		<div class="modal main-modal review-modal" id="review-modal">
			<div class="modal-wrapper">
				<button class="modal-closer" type="button" aria-label="Закрыть">
					<svg width="14" height="14">
						<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite.svg#icon-close"></use>
					</svg>
				</button>
				<div class="modal-content"><span class="modal-text"></span></div>
			</div>
		</div>
	</div>
<? endif; ?>