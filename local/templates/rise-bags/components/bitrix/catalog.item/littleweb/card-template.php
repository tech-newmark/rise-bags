<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array|null $price
 * @var float|int|null $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var bool $itemHasDetailUrl
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var string $discountPositionClass
 * @var string $labelPositionClass
 * @var CatalogSectionComponent $component
 */
?>

<div class="product-item">
	<? if ($itemHasDetailUrl): ?>
		<a class="product-item-image-wrapper" href="<?= $item['DETAIL_PAGE_URL'] ?>" title="<?= $imgTitle ?>" data-entity="image-wrapper">
		<? else: ?>
			<div class="product-item-image-wrapper" data-entity="image-wrapper">
			<? endif; ?>

			<div class="swiper product-item-slider">
				<div class="swiper-wrapper" id="<?= $itemIds['PICT_SLIDER'] ?>">
					<? if ($showSlider): ?>
						<? foreach ($morePhoto as $index => $slide): ?>
							<div class="swiper-slide 2" <?= ($index === 0 ? ' id="' . $itemIds['PICT'] . '"' : '') ?>>
								<img src="<?= $slide['SRC'] ?>" alt="<?= $item['NAME'] ?>">
							</div>
						<? endforeach; ?>
					<? else: ?>

						<? if (!empty($morePhoto[0]['SRC'])): ?>
							<div class="swiper-slide 1" id="<?= $itemIds['PICT'] ?>">
								<img src="<?= $item["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $item['NAME'] ?>">
							</div>
						<? endif; ?>
					<? endif; ?>
				</div>
			</div>

			<div class="swiper-pagination" aria-label="Пагинация"></div>

			<!-- готово метки(хит и тд) и скидка-->
			<? if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($price) && $price['PERCENT'] > 0): ?>
				<span class="product-label product-label--discount" id="<?= $itemIds['DSC_PERC'] ?>">
					<?= -$price['PERCENT'] ?>%
				</span>
			<? endif; ?>
			<? if ($item['LABEL'] && !empty($item['LABEL_ARRAY_VALUE'])): ?>
				<div class="product-label-container" id="<?= $itemIds['STICKER_ID'] ?>">
					<? foreach ($item['LABEL_ARRAY_VALUE'] as $code => $value): ?>
						<span class="product-label product-label--<?= strtolower($code) ?>" title="Новинка">
							<?= $value ?>
						</span>
					<? endforeach; ?>
				</div>
			<? endif; ?>

			<? if ($arParams['DISPLAY_COMPARE'] && (!$haveOffers || $arParams['PRODUCT_DISPLAY_MODE'] === 'Y')): ?>
				<label id="<?= $itemIds['COMPARE_LINK'] ?>" class="compare">
					<input type="checkbox" data-entity="compare-checkbox">
					<svg width='32' height='32' role='img' aria-hidden='true' focusable='false'>
						<use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#compare-icon'></use>
					</svg>
				</label>
			<? endif; ?>

			<!-- готово -->

			<? if ($itemHasDetailUrl): ?>
		</a>
	<? else: ?>
</div>
<? endif; ?>

<? if ($itemHasDetailUrl): ?>
	<a class="product-item-title" href="<?= $item['DETAIL_PAGE_URL'] ?>" title="<?= $productTitle ?>">
	<? endif; ?>
	<span class="product-item-title" title="<?= $productTitle ?>"><?= $productTitle ?></span>
	<? if ($itemHasDetailUrl): ?>
	</a>
<? endif; ?>

<?
if (!empty($arParams['PRODUCT_BLOCKS_ORDER'])) {
	foreach ($arParams['PRODUCT_BLOCKS_ORDER'] as $blockName) {
		switch ($blockName) {
			case 'price': ?>
				<!-- готово -->
				<div class="product-item-price-container" data-entity="price-block">
					<? if ($arParams['SHOW_OLD_PRICE'] === 'Y' && !empty($price)): ?>
						<span class="product-item-price product-item-price--old" id="<?= $itemIds['PRICE_OLD'] ?>"
							<?= ($price['RATIO_PRICE'] >= $price['RATIO_BASE_PRICE'] ? 'style="display: none;"' : '') ?>>
							<?= $price['PRINT_RATIO_BASE_PRICE'] ?>
						</span>
					<? endif; ?>
					<span class="product-item-price product-item-price--current" id="<?= $itemIds['PRICE'] ?>">
						<? if (!empty($price)): ?>
							<?
							if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers):
								echo Loc::getMessage(
									'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
									array(
										'#PRICE#' => $price['PRINT_RATIO_PRICE'],
										'#VALUE#' => $measureRatio,
										'#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
									)
								);
							else:
								echo $price['PRINT_RATIO_PRICE'];
							endif;
							?>
						<? endif; ?>
					</span>
				</div>
				<!-- готово -->

				<?
				break;

			case 'quantityLimit':
				if ($arParams['SHOW_MAX_QUANTITY'] !== 'N') {
					if ($haveOffers) {
						if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y') {
				?>
							quantityLimit CASE
							<div class="product-item-info-container product-item-hidden" id="<?= $itemIds['QUANTITY_LIMIT'] ?>"
								style="display: none;" data-entity="quantity-limit-block">
								<div class="product-item-info-container-title">
									<?= $arParams['MESS_SHOW_MAX_QUANTITY'] ?>:
									<span class="product-item-quantity" data-entity="quantity-limit-value"></span>
								</div>
							</div>
						<?
						}
					} else {
						if (
							$measureRatio
							&& (float)$actualItem['CATALOG_QUANTITY'] > 0
							&& $actualItem['CATALOG_QUANTITY_TRACE'] === 'Y'
							&& $actualItem['CATALOG_CAN_BUY_ZERO'] === 'N'
						) {
						?>
							<div class="product-item-info-container product-item-hidden" id="<?= $itemIds['QUANTITY_LIMIT'] ?>">
								<div class="product-item-info-container-title">
									<?= $arParams['MESS_SHOW_MAX_QUANTITY'] ?>:
									<span class="product-item-quantity">
										<?
										if ($arParams['SHOW_MAX_QUANTITY'] === 'M') {
											if ((float)$actualItem['CATALOG_QUANTITY'] / $measureRatio >= $arParams['RELATIVE_QUANTITY_FACTOR']) {
												echo $arParams['MESS_RELATIVE_QUANTITY_MANY'];
											} else {
												echo $arParams['MESS_RELATIVE_QUANTITY_FEW'];
											}
										} else {
											echo $actualItem['CATALOG_QUANTITY'] . ' ' . $actualItem['ITEM_MEASURE']['TITLE'];
										}
										?>
									</span>
								</div>
							</div>
					<?
						}
					}
				}

				break;

			case 'quantity':
				// готово
				$showQuantityBlock = (
					!$haveOffers && $actualItem['CAN_BUY'] && $arParams['USE_PRODUCT_QUANTITY'] && $arParams['PRODUCT_DISPLAY_MODE'] === 'Y'
				) || (
					$haveOffers && $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $arParams['USE_PRODUCT_QUANTITY']
				);

				if ($showQuantityBlock):
					?>
					<div class="counter-block">
						<div class="counter" data-entity="quantity-block">
							<button type="button" class="counter-btn counter-btn--dec" id="<?= $itemIds['QUANTITY_DOWN'] ?>">
								<svg width="24" height="24" role="img" aria-hidden="true" focusable="false">
									<use xlink:href="/local/templates/rise-bags/_dist/sprite.svg#icon-minus"></use>
								</svg>
							</button>
							<input type="number" value="1" disabled="disabled" data-value="1" id="<?= $itemIds['QUANTITY'] ?>" type="number"
								name="<?= $arParams['PRODUCT_QUANTITY_VARIABLE'] ?>"
								value="<?= $measureRatio ?>">
							<button type="button" class="counter-btn counter-btn--inc" id="<?= $itemIds['QUANTITY_UP'] ?>">
								<svg width="24" height="24" role="img" aria-hidden="true" focusable="false">
									<use xlink:href="/local/templates/rise-bags/_dist/sprite.svg#icon-plus"></use>
								</svg>
							</button>
						</div>
						<span class="product-item-amount-description-container">
							<small id="<?= $itemIds['QUANTITY_MEASURE'] ?>">
								<?= $actualItem['ITEM_MEASURE']['TITLE'] ?>
							</small>
							<small id="<?= $itemIds['PRICE_TOTAL'] ?>"></small>
						</span>
					</div>
				<? endif;

				break;

			case 'buttons':
				?>
				<!-- готово -->
				<div class="product-item-info-container" data-entity="buttons-block">
					<? if (!$haveOffers): ?>
						<? if ($actualItem['CAN_BUY']): ?>


							<? if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y'): // расширенный режим показа карточки товара 
							?>
								<div class="product-item-button-container" id="<?= $itemIds['BASKET_ACTIONS'] ?>">
									<button type="button" class="1 main-btn outlined" id="<?= $itemIds['BUY_LINK'] ?>">
										<?= ($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET']) ?>
									</button>
								</div>
							<? else: ?>

								<div class="product-item-button-container">
									<a class="main-btn outlined" href="<?= $item['DETAIL_PAGE_URL'] ?>">
										<?= $arParams['MESS_BTN_DETAIL'] ?>
									</a>
								</div>
							<? endif; ?>
						<? else: ?>
							<div class="product-item-button-container">
								<?
								if ($showSubscribe):
									$APPLICATION->IncludeComponent(
										'bitrix:catalog.product.subscribe',
										'',
										array(
											'PRODUCT_ID' => $actualItem['ID'],
											'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
											'BUTTON_CLASS' => 'btn btn-default ' . $buttonSizeClass,
											'DEFAULT_DISPLAY' => true,
											'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
										),
										$component,
										array('HIDE_ICONS' => 'Y')
									);
								endif;
								?>
								<span class="text" id="<?= $itemIds['NOT_AVAILABLE_MESS'] ?>">
									<?= $arParams['MESS_NOT_AVAILABLE'] ?>
								</span>
							</div>
						<? endif; ?>
					<? else: ?>
						<? if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y'): // расширенный режим показа карточки товара 
						?>
							<? if ($showSubscribe) {
								// Разобраться !!!
								$APPLICATION->IncludeComponent(
									'bitrix:catalog.product.subscribe',
									'',
									array(
										'PRODUCT_ID' => $item['ID'],
										'BUTTON_ID' => $itemIds['SUBSCRIBE_LINK'],
										'BUTTON_CLASS' => 'btn btn-default ' . $buttonSizeClass,
										'DEFAULT_DISPLAY' => !$actualItem['CAN_BUY'],
										'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
									),
									$component,
									array('HIDE_ICONS' => 'Y')
								);
							}
							?>

							<div class="product-item-button-container" <? if ($actualItem['CAN_BUY']): ?> id="<?= $itemIds['BASKET_ACTIONS'] ?>" <? endif; ?>>
								<? if ($actualItem['CAN_BUY']): ?>
									<button type="button" class="main-btn outlined" id="<?= $itemIds['BUY_LINK'] ?>">
										<?= ($arParams['ADD_TO_BASKET_ACTION'] === 'BUY' ? $arParams['MESS_BTN_BUY'] : $arParams['MESS_BTN_ADD_TO_BASKET']) ?>
									</button>
								<? else: ?>
									<span class="text" id="<?= $itemIds['NOT_AVAILABLE_MESS'] ?>">
										<?= $arParams['MESS_NOT_AVAILABLE'] ?>
									</span>
								<? endif; ?>
							</div>
						<? else: ?>
							<div class="product-item-button-container">
								<a class="main-btn outlined" href="<?= $item['DETAIL_PAGE_URL'] ?>">
									<?= $arParams['MESS_BTN_DETAIL'] ?>
								</a>
							</div>
						<? endif; ?>
					<? endif; ?>
				</div>
				<!-- готово -->
				<?
				break;

			case 'props':
				if (!$haveOffers):
					if (!empty($item['DISPLAY_PROPERTIES'])):
				?>
						<!-- готово -->
						<div class="product-item-info-container" data-entity="props-block">
							<ul class="prop-list">
								<? foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty): ?>
									<li class="prop-list-item">
										<span class="prop-list-item-name"><?= $displayProperty['NAME'] ?></span>
										<span class="prop-list-item-value">
											<?= (is_array($displayProperty['DISPLAY_VALUE'])
												? implode(' / ', $displayProperty['DISPLAY_VALUE'])
												: $displayProperty['DISPLAY_VALUE']) ?>
										</span>
									</li>
								<? endforeach; ?>
							</ul>
						</div>
						<!-- готово -->
					<?
					endif;

					if ($arParams['ADD_PROPERTIES_TO_BASKET'] === 'Y' && !empty($item['PRODUCT_PROPERTIES'])):
					?>
						<div id="<?= $itemIds['BASKET_PROP_DIV'] ?>" style="display: none;">
							<?
							if (!empty($item['PRODUCT_PROPERTIES_FILL'])):
								foreach ($item['PRODUCT_PROPERTIES_FILL'] as $propID => $propInfo):
							?>
									<input type="hidden" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propID ?>]"
										value="<?= htmlspecialcharsbx($propInfo['ID']) ?>">
								<?
									unset($item['PRODUCT_PROPERTIES'][$propID]);
								endforeach;
							endif;

							if (!empty($item['PRODUCT_PROPERTIES'])): ?>
								<table>
									<?
									foreach ($item['PRODUCT_PROPERTIES'] as $propID => $propInfo):
									?>
										<tr>
											<td><?= $item['PROPERTIES'][$propID]['NAME'] ?></td>
											<td>
												<?
												if (
													$item['PROPERTIES'][$propID]['PROPERTY_TYPE'] === 'L'
													&& $item['PROPERTIES'][$propID]['LIST_TYPE'] === 'C'
												):
													foreach ($propInfo['VALUES'] as $valueID => $value):
												?>
														<label>
															<? $checked = $valueID === $propInfo['SELECTED'] ? 'checked' : ''; ?>
															<input type="radio" name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propID ?>]"
																value="<?= $valueID ?>" <?= $checked ?>>
															<?= $value ?>
														</label>
														<br />
													<?
													endforeach;
												else:
													?>
													<select name="<?= $arParams['PRODUCT_PROPS_VARIABLE'] ?>[<?= $propID ?>]">
														<?
														foreach ($propInfo['VALUES'] as $valueID => $value):
															$selected = $valueID === $propInfo['SELECTED'] ? 'selected' : '';
														?>
															<option value="<?= $valueID ?>" <?= $selected ?>>
																<?= $value ?>
															</option>
														<?
														endforeach;
														?>
													</select>
												<?
												endif;
												?>
											</td>
										</tr>
									<?
									endforeach;
									?>
								</table>
							<?
							endif;
							?>
						</div>
					<?
					endif;
				else:
					$showProductProps = !empty($item['DISPLAY_PROPERTIES']);
					$showOfferProps = $arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $item['OFFERS_PROPS_DISPLAY'];

					if ($showProductProps || $showOfferProps):
					?>
						<!-- готово -->
						<div class="product-item-info-container" data-entity="props-block">
							<div class="prop-list">
								<? if ($showProductProps): ?>
									<? foreach ($item['DISPLAY_PROPERTIES'] as $code => $displayProperty): ?>
										<div class="prop-list-item">
											<span class="prop-list-item-name"><?= $displayProperty['NAME'] ?></span>
											<span class="prop-list-item-value">
												<?= (is_array($displayProperty['DISPLAY_VALUE'])
													? implode(' / ', $displayProperty['DISPLAY_VALUE'])
													: $displayProperty['DISPLAY_VALUE']) ?>
											</span>
										</div>
									<? endforeach; ?>
								<? endif; ?>
							</div>
							<? if ($showOfferProps && $item['JS_OFFERS']): ?>
								<div class="prop-list prop-list--scu" id="<?= $itemIds['DISPLAY_PROP_DIV'] ?>"></div>
							<? endif; ?>
						</div>
						<!-- готово -->
					<?
					endif;
				endif;

				break;

			case 'sku':
				if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP'])): ?>
					<!-- готово -->
					<div id="<?= $itemIds['PROP_DIV'] ?>">
						<?
						foreach ($arParams['SKU_PROPS'] as $skuProperty):
							$propertyId = $skuProperty['ID'];
							$skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
							if (!isset($item['SKU_TREE_VALUES'][$propertyId]))
								continue;
						?>

							<div class="scu-prop-block" data-entity="sku-block">
								<div class="scu-prop-container" data-entity="sku-line-block">
									<span class="scu-prop-name"><?= $skuProperty['NAME'] ?></span>
									<ul class="scu-prop-list">

										<? foreach ($skuProperty['VALUES'] as $value):
											if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']]))
												continue;

											$value['NAME'] = htmlspecialcharsbx($value['NAME']);

											if ($skuProperty['SHOW_MODE'] === 'PICT'):
										?>
												<li class="scu-prop-list-item" title="<?= $value['NAME'] ?>" data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>" data-onevalue="<?= $value['ID'] ?>">
													<button type="button" class="scu-prop-list-item-value">
														<img src="<?= $value['PICT']['SRC'] ?>" alt="<?= $value['NAME'] ?>" width="40" height="40">
													</button>
												</li>
											<? else: ?>
												<li title="<?= $value['NAME'] ?>" data-treevalue="<?= $propertyId ?>_<?= $value['ID'] ?>" data-onevalue="<?= $value['ID'] ?>">
													<button type="button" class="scu-prop-list-item-value">
														<span><?= $value['NAME'] ?></span>
													</button>
												</li>
										<? endif;
										endforeach;
										?>
									</ul>
								</div>
							</div>

						<? endforeach; ?>
					</div>
					<!-- готово -->

					<? foreach ($arParams['SKU_PROPS'] as $skuProperty): ?>
						<? if (!isset($item['OFFERS_PROP'][$skuProperty['CODE']]))
							continue;

						$skuProps[] = array(
							'ID' => $skuProperty['ID'],
							'SHOW_MODE' => $skuProperty['SHOW_MODE'],
							'VALUES' => $skuProperty['VALUES'],
							'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
						); ?>
					<? endforeach;
					unset($skuProperty, $value); ?>

					<? if ($item['OFFERS_PROPS_DISPLAY']): ?>
<? foreach ($item['JS_OFFERS'] as $keyOffer => $jsOffer):
							$strProps = '';

							if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
								foreach ($jsOffer['DISPLAY_PROPERTIES'] as $displayProperty) {
									$strProps .= '<div class="prop-list-item"><span class="prop-list-item-name">' . $displayProperty['NAME'] . '</span><span class="prop-list-item-value">'
										. (is_array($displayProperty['VALUE'])
											? implode(' / ', $displayProperty['VALUE'])
											: $displayProperty['VALUE'])
										. '</span></div>';
								}
							}

							$item['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
						endforeach;
						unset($jsOffer, $strProps);
					endif;
				endif;

				break;
		}
	}
}
?>
</div>