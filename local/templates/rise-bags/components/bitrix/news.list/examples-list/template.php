<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

// includeComponentAssets('news.list/examples-list');
?>


<section class="section examples-list">
	<div class="container">
		<div class="articles__header">
			<h1><?= $arResult["NAME"] ?></h1>
			<? if ($arResult["DESCRIPTION"]): ?>
				<div><?= $arResult["DESCRIPTION"] ?></div>
			<? endif; ?>
		</div>

		<? if ($arResult["ITEMS"]): ?>
			<h2>Примеры наших работ</h2>
			<div class="swiper examples-slider">
				<div class="swiper-wrapper">
					<? foreach ($arResult["ITEMS"] as $arItem):
						$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
						$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
						<div class="swiper-slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
							<img data-fancybox="gallery-slider" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= (($arItem["PREVIEW_PICTURE"]["DESCRIPTION"]) ? ($arItem["PREVIEW_PICTURE"]["DESCRIPTION"]) : $arItem["NAME"]) ?>" width="<?= $arItem["PREVIEW_PICTURE"]["WIDTH"] ?>?>" height="<?= $arItem["PREVIEW_PICTURE"]["HEIGHT"] ?>">
						</div>
					<? endforeach; ?>
				</div>
				<div class="swiper-button-prev">
					<svg width="16" height="16" viewBox="0 0 16 16" role="img" aria-hidden="true" focusable="false">
						<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-arrow"></use>
					</svg>
				</div>
				<div class="swiper-button-next"><svg width="16" height="16" viewBox="0 0 16 16" role="img" aria-hidden="true" focusable="false">
						<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-arrow"></use>
					</svg>
				</div>
				<div class="swiper-pagination"></div>
			</div>
		<? endif; ?>

	</div>


</section>