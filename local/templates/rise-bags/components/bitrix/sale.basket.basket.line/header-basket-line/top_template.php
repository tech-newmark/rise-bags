<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */
$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
?>

<div class="bx-basket-block">
	<? if (!$compositeStub && $arParams['SHOW_AUTHOR'] == 'Y'): ?>
		<? if ($USER->IsAuthorized()): ?>

			<div class="bx-basket-block-section">
				<a href="?logout=yes&<?= bitrix_sessid_get() ?>">
					<div class="bx-basket-block-section-icon">
						<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
							<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-login' ?> "></use>
						</svg>
					</div>

					<span><?= GetMessage('TSB1_LOGOUT') ?></span>
				</a>
			</div>

			<? if ($arParams['SHOW_PERSONAL_LINK'] == 'Y'): ?>
				<div class="bx-basket-block-section">
					<a href="<?= $arParams['PATH_TO_PERSONAL'] ?>">
						<div class="bx-basket-block-section-icon">
							<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
								<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-user' ?> "></use>
							</svg>
						</div>
						<span><?= GetMessage('TSB1_PERSONAL') ?>
					</a></span>
				</div>
			<? endif; ?>

			<? if ($arParams['PATH_TO_PROFILE'] != ''): ?>
				<div class="bx-basket-block-section">
					<a href="<?= $arParams['PATH_TO_PROFILE'] ?>">
						<div class="bx-basket-block-section-icon">
							<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
								<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-profile' ?> "></use>
							</svg>
						</div>
						<span><?= GetMessage('TSB1_PROFILE') ?></span>
					</a>
				</div>
			<? endif; ?>

			<? else:
			$arParamsToDelete = array(
				"login",
				"login_form",
				"logout",
				"register",
				"forgot_password",
				"change_password",
				"confirm_registration",
				"confirm_code",
				"confirm_user_id",
				"logout_butt",
				"auth_service_id",
				"clear_cache",
				"backurl",
			);

			$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
			if ($arParams['AJAX'] == 'N'): ?>
				<script>
					<?= $cartId ?>.currentUrl = '<?= $currentUrl ?>';
				</script>
			<? else:
				$currentUrl = '#CURRENT_URL#';
			endif;

			$pathToAuthorize = $arParams['PATH_TO_AUTHORIZE'];
			$pathToAuthorize .= (mb_stripos($pathToAuthorize, '?') === false ? '?' : '&');
			$pathToAuthorize .= 'login=yes&backurl=' . $currentUrl;
			?>

			<div class="bx-basket-block-section bx-basket-block-section--auth">
				<a href="<?= $pathToAuthorize ?>">
					<div class="bx-basket-block-section-icon">
						<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
							<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-login' ?> "></use>
						</svg>
					</div>

					<span><?= GetMessage('TSB1_LOGIN') ?></span>
				</a>

				<? if ($arParams['SHOW_REGISTRATION'] === 'Y'):
					$pathToRegister = $arParams['PATH_TO_REGISTER'];
					$pathToRegister .= (mb_stripos($pathToRegister, '?') === false ? '?' : '&');
					$pathToRegister .= 'register=yes&backurl=' . $currentUrl;
				?>
					<a href="<?= $pathToRegister ?>">
						<div class="bx-basket-block-section-icon">
							<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
								<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-reg' ?> "></use>
							</svg>
						</div>
						<span><?= GetMessage('TSB1_REGISTER') ?></span>
					</a>
				<? endif; ?>
			</div>
		<? endif ?>
	<? endif ?>

	<div class="bx-basket-block-section">
		<a href="/">
			<div class="bx-basket-block-section-icon">
				<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
					<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-compare' ?> "></use>
				</svg>
			</div>
			<span>Сравнение</span>
		</a>
	</div>

	<div class="bx-basket-block-section">
		<a href="/">
			<div class="bx-basket-block-section-icon">
				<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
					<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-heart' ?> "></use>
				</svg>
			</div>
			<span>Избранное</span>
		</a>
	</div>


	<div class="bx-basket-block-section">
		<? if (!$arResult["DISABLE_USE_BASKET"]): ?>
			<a href="<?= $arParams['PATH_TO_BASKET'] ?>">
				<div class="bx-basket-block-section-icon">
					<svg width="24" height="20" role="img" aria-hidden="true" focusable="false">
						<use xlink:href="<?= SITE_TEMPLATE_PATH . '/_dist/sprite.svg#icon-cart' ?> "></use>
					</svg>
					<? if (!$compositeStub): ?>
						<? if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y')): ?>
							<span class="bx-basket-block-section-label"><?= $arResult['NUM_PRODUCTS'] ?></span>
						<? endif; ?>
					<? endif; ?>
				</div>
				<span><?= GetMessage('TSB1_CART') ?></span>
			</a>
		<? endif; ?>

		<? if (!$compositeStub): ?>
			<? if ($arParams['SHOW_NUM_PRODUCTS'] == 'Y' && ($arResult['NUM_PRODUCTS'] > 0 || $arParams['SHOW_EMPTY_VALUES'] == 'Y')): ?>
				<? if ($arParams['SHOW_TOTAL_PRICE'] == 'Y'): ?>
					<div class="bx-basket-tooltip">
						<small>
							<?= GetMessage('TSB1_TOTAL_PRICE') ?>
						</small>
						<strong><?= $arResult['TOTAL_PRICE'] ?></strong>
					</div>
				<? endif; ?>
			<? endif; ?>
		<? endif; ?>
	</div>
</div>