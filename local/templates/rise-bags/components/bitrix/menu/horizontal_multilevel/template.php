<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<? if (!empty($arResult)): ?>
	<ul class="horizontal-multilevel-menu" id="horizontal-multilevel-menu">

		<?
		$previousLevel = 0;
		foreach ($arResult as $arItem): ?>

			<? if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel): ?>
				<?= str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"])); ?>
			<? endif ?>

			<? if ($arItem["IS_PARENT"]): ?>

				<? if ($arItem["DEPTH_LEVEL"] == 1): ?>
					<li class="dropdown-menu">
						<a href="<?= $arItem["LINK"] ?>" class="<? if ($arItem["SELECTED"]): ?>root-item-selected<? else: ?>root-item<? endif ?>"><?= $arItem["TEXT"] ?>
							<svg width="18" height="18" viewBox="0 0 18 18" role="img" aria-hidden="true" focusable="false">
								<use xlink:href="<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#arrow-sm"></use>
							</svg>
						</a>
						<ul>
						<? else: ?>
							<li<? if ($arItem["SELECTED"]): ?> class="item-selected" <? endif ?>><a href="<?= $arItem["LINK"] ?>" class="parent"><?= $arItem["TEXT"] ?></a>
								<ul>
								<? endif ?>

							<? else: ?>

								<? if ($arItem["PERMISSION"] > "D"): ?>

									<? if ($arItem["DEPTH_LEVEL"] == 1): ?>
										<li><a href="<?= $arItem["LINK"] ?>" class="<? if ($arItem["SELECTED"]): ?>root-item-selected<? else: ?>root-item<? endif ?>"><?= $arItem["TEXT"] ?></a></li>
									<? else: ?>
										<li<? if ($arItem["SELECTED"]): ?> class="item-selected" <? endif ?>><a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a>
					</li>
				<? endif ?>

			<? else: ?>

				<? if ($arItem["DEPTH_LEVEL"] == 1): ?>
					<li><a href="" class="<? if ($arItem["SELECTED"]): ?>root-item-selected<? else: ?>root-item<? endif ?>" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><?= $arItem["TEXT"] ?></a></li>
				<? else: ?>
					<li><a href="" class="denied" title="<?= GetMessage("MENU_ITEM_ACCESS_DENIED") ?>"><?= $arItem["TEXT"] ?></a></li>
				<? endif ?>

			<? endif ?>

		<? endif ?>

		<? $previousLevel = $arItem["DEPTH_LEVEL"]; ?>

	<? endforeach ?>

	<? if ($previousLevel > 1): //close last item tags
	?>
		<?= str_repeat("</ul></li>", ($previousLevel - 1)); ?>
	<? endif ?>

	</ul>
	<div class="menu-clear-left"></div>
<? endif ?>