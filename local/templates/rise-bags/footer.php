<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
</main>

<?/* $APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	".default", 
	[
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "Y",
		"WEB_FORM_ID" => "1",
		"COMPONENT_TEMPLATE" => ".default",
		"VARIABLE_ALIASES" => [
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		]
	],
	false
); */ ?>

<?/* $APPLICATION->IncludeComponent(
	"bitrix:subscribe.edit", 
	"rise", 
	[
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"ALLOW_ANONYMOUS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"SET_TITLE" => "N",
		"SHOW_AUTH_LINKS" => "N",
		"SHOW_HIDDEN" => "N",
		"COMPONENT_TEMPLATE" => "rise",
		"TITLE" => "Подпишитесь на рассылку и получите скидку 10% на товары в розницу",
		"DESCRIPTION" => "Добро пожаловать в сообщество Rise Bags! Ваш промокод на скидку 10% внутри",
		"ANSWER" => "Спасибо! Вы успешно подписались на рассылку!"
	],
	false
); */ ?>

<footer class="footer">
  <div class="container">
    <div class="grid">
      <div class="grid__item grid__item--company">
        <a href="/" class="footer__logo" aria-label="На главную страницу">
          <img src="<?= SITE_TEMPLATE_PATH ?>/_dist/images/logo.svg" alt="" width="240" height="180">
        </a>

        <div class="social">
          social-icons-row
        </div>

        <button class="main-btn">Запросить прайс</button>
        <button class="main-btn outlined">Заказать звонок</button>
      </div>

      <div class="grid__item grid__item--menu grid__item--menu-wide">
        <? $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"multilevel-menu", 
	[
		"TITLE" => "Каталог",
		"COLUMN_VIEW" => "Y",
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "bottom.left",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => [
		],
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_THEME" => "site",
		"ROOT_MENU_TYPE" => "bottom.left",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "multilevel-menu"
	],
	false
); ?>
      </div>

      <div class="grid__item grid__item--menu">
        <? $APPLICATION->IncludeComponent(
          "bitrix:menu",
          "multilevel-menu",
          [
            "TITLE" => "Информация",
            "COLUMN_VIEW" => "N",
            "ALLOW_MULTI_SELECT" => "N",
            "CHILD_MENU_TYPE" => "left",
            "DELAY" => "N",
            "MAX_LEVEL" => "4",
            "MENU_CACHE_GET_VARS" => [],
            "MENU_CACHE_TIME" => "3600",
            "MENU_CACHE_TYPE" => "N",
            "MENU_CACHE_USE_GROUPS" => "Y",
            "MENU_THEME" => "site",
            "ROOT_MENU_TYPE" => "bottom",
            "USE_EXT" => "Y",
            "COMPONENT_TEMPLATE" => "multilevel-menu"
          ],
          false
        ); ?>
      </div>

      <div class="grid__item grid__item--contacts">
        <div class="contact-block">
          <div class="contact-block__section">
            <div class="contact-block__section-header">
              <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
                <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-phone'></use>
              </svg>
              <span class="contact-block__section-header-title">
                Телефон
              </span>
            </div>
            <div class="contact-block__section-content">
              <a href="tel:+78125429154">+7 (812) 542-91-54</a>
              <a href="tel:+79633227552">+7 (963) 322-75-52</a>
            </div>
          </div>
          <div class="contact-block__section">
            <div class="contact-block__section-header">
              <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
                <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-mail'></use>
              </svg>
              <span class="contact-block__section-header-title">
                E-mail
              </span>
            </div>
            <div class="contact-block__section-content">
              <a href="ailto:support@rise-bags.ru">support@rise-bags.ru</a>
            </div>
          </div>
          <div class="contact-block__section">
            <div class="contact-block__section-header">
              <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
                <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-pin'></use>
              </svg>
              <span class="contact-block__section-header-title">
                Адрес
              </span>
            </div>
            <div class="contact-block__section-content">
              <address>
                194044, Россия, г. Санкт-Петербург, ул. наб. Обводного канала, 223–225, литер Л, пом. 9
              </address>
            </div>
          </div>
          <div class="contact-block__section">
            <div class="contact-block__section-header">
              <svg width='24' height='24' role='img' aria-hidden='true' focusable='false'>
                <use xlink:href='<?= SITE_TEMPLATE_PATH ?>/_dist/sprite.svg#icon-date'></use>
              </svg>
              <span class="contact-block__section-header-title">
                Время работы
              </span>
            </div>
            <div class="contact-block__section-content">
              <span>
                пн. - пт. с 10-00 до 18-00
              </span>
            </div>
          </div>
          <div class="contact-block__section">
            <div class="contact-block__section-content">
              <img src="<?= SITE_TEMPLATE_PATH ?>/_dist/yandex-rate.png" alt="Рейтинг организации в Яндекс" width="210" height="70">
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</footer>
<div class="underfooter-line">
  <div class="container">
    underfooter-line
  </div>
</div>
</body>

</html>