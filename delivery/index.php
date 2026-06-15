<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("О компании");
?>
<section class="section company">
	<div class="container">
		<? $APPLICATION->IncludeFile(
			SITE_DIR . "include/delivery/index.php",
			array(),
			array(
				"MODE" => "php",
				"NAME" => "текст",
				"TEMPLATE" => "include_area.php",
			)
		); ?>
	</div>
</section> <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>