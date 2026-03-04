<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$aMenuLinks = array(
	array(
		"Как купить",
		"about/howto/",
		array(),
		array(),
		""
	),
	array(
		"Доставка",
		"about/delivery/",
		array(),
		array(),
		""
	),
	array(
		"О магазине",
		"about/",
		array(),
		array(),
		""
	),
	array(
		"Гарантия",
		"about/guaranty/",
		array(),
		array(),
		""
	),
	array(
		"Контакты",
		"about/contacts/",
		array(),
		array(),
		""
	),
	array(
		"Мой кабинет",
		"personal/",
		array(),
		array(),
		"\$USER->IsAuthorized()"
	),
);
