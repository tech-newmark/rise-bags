<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

/* <?debug($arItem) ?>*/
?>


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
					<? if ($arItem["PROPERTIES"]["RATING"]["VALUE"]): ?>
						<div>
							<? for ($i = 0; $i <= $arItem["PROPERTIES"]["RATING"]["VALUE"]; $i++) : ?>
								<svg width="20" height="20" viewBox="0 0 20 20" role="img" aria-hidden="true" focusable="false">
									<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/assets/sprite.svg#icon-cross"></use>
								</svg>
							<? endfor; ?>
						</div>
					<? endif; ?>
					<div>
						<? if ($arItem["PREVIEW_TEXT"]): ?>
							<div><?= $arItem["PREVIEW_TEXT"] ?></div>
						<? endif; ?>
						<button type="button">Читать полностью</button>
					</div>
					<div class="">
						<? if ($arItem["PREVIEW_IMAGE"]["SRC"]): ?>
							<img src="<?= $arItem["PREVIEW_IMAGE"] ?>" alt="<?= $arItem["NAME"] ?>">
						<? endif; ?>
						<span><?= $arItem["NAME"] ?></span>
						<? if ($arItem["PROPERTIES"]["JOB_TITLE"]["VALUE"]): ?>
							<span><?= $arItem["PROPERTIES"]["JOB_TITLE"]["VALUE"] ?></span>
						<? endif; ?>
						<? if ($arItem["PROPERTIES"]["COMPANY"]["VALUE"]): ?>
							<span><?= $arItem["PROPERTIES"]["COMPANY"]["VALUE"] ?></span>
						<? endif; ?>
					</div>
				</div>
			<? endforeach; ?>
			<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
				<?= $arResult["NAV_STRING"] ?>
			<? endif; ?>
		</div>
	</div>
</section>