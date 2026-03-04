<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

use Bitrix\Main\Localization\Loc;

includeComponentAssets('main.profile/rise');
?>

<section class="section profile">
	<div class="container">
		<h2 class="title"><?= $APPLICATION->GetTitle() ?></h2>

		<div class="grid">
			<div class="grid__item">
				<div class="personal-sidebar">
					<? if ($arParams["PATH_TO_ACCOUNT"]): ?>
						<a href="<?= $arParams["PATH_TO_ACCOUNT"] ?>" class="main-btn outlined">
							<span>Личный счет</span>
						</a>
					<? endif; ?>
					<? if ($arParams["PATH_TO_ORDERS"]): ?>
						<a href="<?= $arParams["PATH_TO_ORDERS"] ?>" class="main-btn outlined">
							<span>Текущие заказы</span>
						</a>
					<? endif; ?>
					<? if ($arParams["PATH_TO_SUBSCRIBE"]): ?>
						<a href="<?= $arParams["PATH_TO_SUBSCRIBE"] ?>" class="main-btn outlined">
							<span>Избранные товары</span>
						</a>
					<? endif; ?>

					<a href="/personal/cart/" class="main-btn outlined">
						<span>Корзина</span>
					</a>

					<a href="/contacts/" class="main-btn outlined">
						<span>Контакты</span>
					</a>
				</div>
			</div>
			<div class="grid__item">
				<form method="post" name="form1" action="<?= POST_FORM_ACTION_URI ?>" enctype="multipart/form-data" role="form">
					<?= $arResult["BX_SESSION_CHECK"] ?>
					<input type="hidden" name="lang" value="<?= LANG ?>" />
					<input type="hidden" name="ID" value="<?= $arResult["ID"] ?>" />
					<input type="hidden" name="LOGIN" value="<?= $arResult["arUser"]["LOGIN"] ?>" />

					<div class="profile__main" id="user_div_reg">
						<div class="profile__info alert alert-warning">
							<? if ($arResult["ID"] > 0): ?>
								<? if ($arResult["arUser"]["TIMESTAMP_X"] <> ''): ?>
									<small><?= Loc::getMessage('LAST_UPDATE') . ' ' . $arResult["arUser"]["TIMESTAMP_X"] ?></small>
								<? endif; ?>

								<? if ($arResult["arUser"]["LAST_LOGIN"] <> ''): ?>
									<small><?= Loc::getMessage('LAST_LOGIN') . ' ' . $arResult["arUser"]["LAST_LOGIN"] ?></small>
								<? endif; ?>
							<? endif; ?>
						</div>

						<? if (($arResult['DATA_SAVED'] ?? 'N') === 'Y'): ?>
							<div class="alert alert-success">
								<small><?= Loc::getMessage('PROFILE_DATA_SAVED') ?></small>
							</div>
						<? endif; ?>

						<? if (!in_array(LANGUAGE_ID, array('ru', 'ua'))): ?>
							<div class="main-input-wrapper">
								<label for="main-profile-title"><?= Loc::getMessage('MAIN_PROFILE_TITLE') ?></label>
								<input class="main-input" type="text" name="TITLE" maxlength="50" id="main-profile-title" value="<?= $arResult["arUser"]["TITLE"] ?>" />
							</div>
						<? endif; ?>

						<div class="main-input-wrapper">
							<label for="main-profile-name"><?= Loc::getMessage('NAME') ?></label>
							<input class="main-input" type="text" name="NAME" maxlength="50" id="main-profile-name" value="<?= $arResult["arUser"]["NAME"] ?>" />
						</div>

						<div class="main-input-wrapper">
							<label for="main-profile-last-name"><?= Loc::getMessage('LAST_NAME') ?></label>
							<input class="main-input" type="text" name="LAST_NAME" maxlength="50" id="main-profile-last-name" value="<?= $arResult["arUser"]["LAST_NAME"] ?>" />
						</div>

						<div class="main-input-wrapper">
							<label for="main-profile-second-name"><?= Loc::getMessage('SECOND_NAME') ?></label>
							<input class="main-input" type="text" name="SECOND_NAME" maxlength="50" id="main-profile-second-name" value="<?= $arResult["arUser"]["SECOND_NAME"] ?>" />
						</div>

						<div class="main-input-wrapper">
							<label for="main-profile-email"><?= Loc::getMessage('EMAIL') ?></label>
							<input class="main-input" type="text" name="EMAIL" maxlength="50" id="main-profile-email" value="<?= $arResult["arUser"]["EMAIL"] ?>" />
						</div>

						<? if ($arResult['CAN_EDIT_PASSWORD']): ?>
							<div class="profile__pswd-block">

								<? if ($arResult["strProfileError"]): ?>
									<div class="alert alert-danger"><small><?= $arResult["strProfileError"] ?></small></div>
								<? endif; ?>

								<div class="main-input-wrapper">
									<label for="main-profile-password"><?= Loc::getMessage('NEW_PASSWORD_REQ') ?></label>
									<input class="main-input" type="password" name="NEW_PASSWORD" maxlength="50" id="main-profile-password" value="" autocomplete="off" />
								</div>

								<div class="main-input-wrapper">
									<label for="main-profile-password-confirm">
										<?= Loc::getMessage('NEW_PASSWORD_CONFIRM') ?>
									</label>
									<input class="main-input" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" id="main-profile-password-confirm" autocomplete="off" />
								</div>
								<small>*<?= $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"]; ?></small>
							</div>

						<? endif; ?>
					</div>

					<div class="profile__footer">
						<input type="submit" name="save" class="main-btn" value="<?= (($arResult["ID"] > 0) ? Loc::getMessage("MAIN_SAVE") : Loc::getMessage("MAIN_ADD")) ?>">
						<input type="submit" class="main-btn outlined" name="reset" value="<? echo GetMessage("MAIN_RESET") ?>">
					</div>
				</form>
			</div>
		</div>
	</div>
</section>