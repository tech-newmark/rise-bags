<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}
?>

<div class="item" data-product-id="<?= $arResult["ITEM"]["ID"] ?>">
	<div class="item__section item__section--top" data-entity="image-wrapper">
		<a href="<?= $arResult["ITEM"]["DETAIL_PAGE_URL"] ?>">
			<div class="swiper product-item-slider" data-1clickbuy-img-container>
				<div class="swiper-wrapper" data-entity="pict-slider"></div>
				<div class="swiper-pagination product-item-slider-pagination"></div>
			</div>
		</a>

		<div class="item__action">
			<button class="item__action-btn item__action-btn--quickview"
				type="button"
				aria-label="Быстрый просмотр"
				data-quickview-id="<?= $arResult["ITEM"]["ID"] ?>"
				data-quickview-offer-id="<?= $arResult["ITEM"]["ID"] ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M12.0023 15.577C13.1355 15.577 14.0979 15.1804 14.8896 14.3872C15.6812 13.5941 16.0771 12.6309 16.0771 11.4978C16.0771 10.3646 15.6805 9.40217 14.8873 8.6105C14.0942 7.81883 13.131 7.423 11.9978 7.423C10.8647 7.423 9.90224 7.81958 9.11058 8.61275C8.31891 9.40592 7.92307 10.3691 7.92307 11.5023C7.92307 12.6354 8.31966 13.5978 9.11282 14.3895C9.90599 15.1812 10.8692 15.577 12.0023 15.577ZM12.0001 14.2C11.2501 14.2 10.6126 13.9375 10.0876 13.4125C9.56257 12.8875 9.30007 12.25 9.30007 11.5C9.30007 10.75 9.56257 10.1125 10.0876 9.5875C10.6126 9.0625 11.2501 8.8 12.0001 8.8C12.7501 8.8 13.3876 9.0625 13.9126 9.5875C14.4376 10.1125 14.7001 10.75 14.7001 11.5C14.7001 12.25 14.4376 12.8875 13.9126 13.4125C13.3876 13.9375 12.7501 14.2 12.0001 14.2ZM12.0013 18.5C9.70182 18.5 7.60657 17.8657 5.71557 16.597C3.82457 15.3285 2.43224 13.6295 1.53857 11.5C2.43224 9.3705 3.82407 7.6715 5.71407 6.403C7.60424 5.13433 9.69916 4.5 11.9988 4.5C14.2983 4.5 16.3936 5.13433 18.2846 6.403C20.1756 7.6715 21.5679 9.3705 22.4616 11.5C21.5679 13.6295 20.1761 15.3285 18.2861 16.597C16.3959 17.8657 14.301 18.5 12.0013 18.5ZM12.0001 17C13.8834 17 15.6126 16.5042 17.1876 15.5125C18.7626 14.5208 19.9667 13.1833 20.8001 11.5C19.9667 9.81667 18.7626 8.47917 17.1876 7.4875C15.6126 6.49583 13.8834 6 12.0001 6C10.1167 6 8.38757 6.49583 6.81257 7.4875C5.23757 8.47917 4.03341 9.81667 3.20007 11.5C4.03341 13.1833 5.23757 14.5208 6.81257 15.5125C8.38757 16.5042 10.1167 17 12.0001 17Z" fill="#669900"></path>
				</svg>
			</button>
			<button class="item__action-btn item__action-btn--oneclickbuy"
				data-1clickbuy-id="<?= $arResult["ITEM"]["ID"] ?>"
				type="button" aria-label="Купить в один клик">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M1.5 17.6923L1.875 16.1923H6.86525L6.4905 17.6923H1.5ZM3.5 13.8077L3.875 12.3077H9.86525L9.4905 13.8077H3.5ZM18.5558 20.0095L19.0558 15.9905L19.7713 10.0865L20.0308 8.0155L18.5558 20.0095ZM6.27875 21.5C5.84425 21.5 5.47125 21.3554 5.15975 21.0663C4.84808 20.7773 4.69225 20.4218 4.69225 20H18.248C18.3378 20 18.4148 19.9712 18.4788 19.9135C18.5429 19.8558 18.5814 19.7821 18.5943 19.6923L19.9828 8.3615C19.9956 8.27183 19.9699 8.19175 19.9058 8.12125C19.8416 8.05075 19.7647 8.0155 19.675 8.0155H17.0308L16.7365 10.3423C16.7097 10.5551 16.6151 10.7231 16.4528 10.8462C16.2906 10.9692 16.1032 11.0205 15.8905 11C15.684 10.9795 15.5193 10.8907 15.3963 10.7337C15.2731 10.5766 15.225 10.3948 15.252 10.1885L15.5155 8.0155H11.0308L10.7365 10.327C10.7097 10.5398 10.6151 10.7103 10.4528 10.8385C10.2906 10.9667 10.1032 11.0205 9.8905 11C9.684 10.9795 9.51667 10.8882 9.3885 10.726C9.26033 10.5638 9.20967 10.3795 9.2365 10.173L9.5 8.0155H6.0865C6.14683 7.55767 6.34267 7.19067 6.674 6.9145C7.0055 6.63817 7.393 6.5 7.8365 6.5H9.68275L9.7115 6.25C9.84483 5.0705 10.2532 4.15067 10.9365 3.4905C11.6198 2.83017 12.5513 2.5 13.7308 2.5C14.7526 2.5 15.5953 2.883 16.2588 3.649C16.9221 4.415 17.2263 5.31408 17.1713 6.34625L17.152 6.5H19.7213C20.2443 6.51033 20.6801 6.71167 21.0288 7.104C21.3776 7.49617 21.5167 7.95383 21.446 8.477L20.0328 19.8615C19.9724 20.3358 19.7643 20.7275 19.4085 21.0365C19.0528 21.3455 18.6378 21.5 18.1635 21.5H6.27875ZM11.1828 6.5H15.6673L15.6865 6.34625C15.7288 5.71292 15.5382 5.1635 15.1145 4.698C14.6907 4.23267 14.1653 4 13.5385 4C12.8525 4 12.3131 4.19842 11.9203 4.59525C11.5273 4.99208 11.291 5.54367 11.2115 6.25L11.1828 6.5Z" fill="#669900"></path>
				</svg>
			</button>
		</div>

		<? if (!empty($arResult["ITEM"]["PROPERTIES"]["HIT"]["VALUE"])): ?>
			<div class="item__labels">
				<?= $arResult["ITEM"]["NM_LABELS"] ?>
			</div>
		<? endif; ?>

		<a class="item__title" href="<?= $arResult["ITEM"]["DETAIL_PAGE_URL"] ?>">
			<?= $arResult["ITEM"]["NAME"] ?>
		</a>
	</div>

	<div class="item__section item__section--bottom" id="<?= $itemIds['BASKET_ACTIONS'] ?>">
		<? if (!empty($price)): ?>
			<div class="item__section-field item__price" data-entity="price-block">
				<? if ($arParams['SHOW_OLD_PRICE'] === 'Y' && $price['RATIO_BASE_PRICE'] > $price['RATIO_PRICE']): ?>
					<div class="item__price-label">
						<span>-<?= $price["PERCENT"] ?>%</span>
						<span><?= $price["PRINT_DISCOUNT"] ?> Экономия</span>
					</div>
				<? endif; ?>

				<div class="item__price-values">
					<small>Цена:</small>

					<span class="item__price-value item__price-value--current" id="<?= $itemIds['PRICE'] ?>" data-1clickbuy-price-container>
						<? if ($arParams['PRODUCT_DISPLAY_MODE'] === 'N' && $haveOffers) {
							echo Loc::getMessage(
								'CT_BCI_TPL_MESS_PRICE_SIMPLE_MODE',
								array(
									'#PRICE#' => $price['PRINT_RATIO_PRICE'],
									'#VALUE#' => $measureRatio,
									'#UNIT#' => $minOffer['ITEM_MEASURE']['TITLE']
								)
							);
						} else {
							echo $price['PRINT_RATIO_PRICE'];
						} ?>
					</span>
					<? if ($arParams['SHOW_OLD_PRICE'] === 'Y' && $price['RATIO_BASE_PRICE'] > $price['RATIO_PRICE']): ?>
						<span class="item__price-value item__price-value--old" id="<?= $itemIds['PRICE_OLD'] ?>">
							<?= $price['PRINT_RATIO_BASE_PRICE'] ?>
						</span>
					<? endif; ?>

				</div>
			</div>
		<? endif; ?>
		<!-- QUANTITY_LIMIT -->
		<? if ($arParams['SHOW_MAX_QUANTITY'] !== 'N'): ?>
			<small id="<?= $itemIds['QUANTITY_LIMIT'] ?>" class="item__quantity-limit">
				В наличии:
				<span data-entity="quantity-limit-value"></span>
			</small>
		<? endif; ?>
		<!-- QUANTITY_LIMIT -->

		<div class="item__section-field">
			<? if ($arParams['PRODUCT_DISPLAY_MODE'] === 'Y' && $haveOffers && !empty($item['OFFERS_PROP'])): ?>
				<? foreach ($arParams['SKU_PROPS'] as $skuProperty):
					$propertyId = $skuProperty['ID'];
					$skuProperty['NAME'] = htmlspecialcharsbx($skuProperty['NAME']);
					if (!isset($item['SKU_TREE_VALUES'][$propertyId]))
						continue;
				?>
					<div class="item__sku" data-entity="sku-block" id="<?= $itemIds['PROP_DIV'] ?>">
						<div data-entity="sku-line-block" data-1clickbuy-size-container>
							<select name="sku_prop_<?= $propertyId ?>" class="custom-select" data-property-id="<?= $propertyId ?>">
								<? foreach ($skuProperty['VALUES'] as $value): ?>
									<? if (!isset($item['SKU_TREE_VALUES'][$propertyId][$value['ID']])) continue; ?>
									<option value="<?= $value['ID'] ?>">
										<?= htmlspecialcharsbx($value['NAME']) ?>
									</option>
								<? endforeach; ?>
							</select>
						</div>
					</div>

				<? endforeach; ?>

				<? foreach ($arParams['SKU_PROPS'] as $skuProperty) {
					if (!isset($item['OFFERS_PROP'][$skuProperty['CODE']]))
						continue;

					$skuProps[] = array(
						'ID' => $skuProperty['ID'],
						'SHOW_MODE' => $skuProperty['SHOW_MODE'],
						'VALUES' => $skuProperty['VALUES'],
						'VALUES_COUNT' => $skuProperty['VALUES_COUNT']
					);
				}

				unset($skuProperty, $value);

				if ($item['OFFERS_PROPS_DISPLAY']) {
					foreach ($item['JS_OFFERS'] as $keyOffer => $jsOffer) {
						$strProps = '';

						if (!empty($jsOffer['DISPLAY_PROPERTIES'])) {
							foreach ($jsOffer['DISPLAY_PROPERTIES'] as $displayProperty) {
								$strProps .= '<dt>' . $displayProperty['NAME'] . '</dt><dd>'
									. (is_array($displayProperty['VALUE'])
										? implode(' / ', $displayProperty['VALUE'])
										: $displayProperty['VALUE'])
									. '</dd>';
							}
						}

						$item['JS_OFFERS'][$keyOffer]['DISPLAY_PROPERTIES'] = $strProps;
					}
					unset($jsOffer, $strProps);
				} ?>
			<? endif; ?>

			<button class="main-btn add-to-cart-btn" aria-label="Добавить товар в корзину" id="<?= $itemIds['BUY_LINK'] ?>">
				В корзину
			</button>
		</div>


	</div>
</div>