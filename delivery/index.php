<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Доставка и оплата");
?>
<section class="section">
	<div class="container">
		<? $APPLICATION->IncludeFile(
			SITE_DIR . "include/delivery.php",
			array(),
			array(
				"MODE" => "php",
				"NAME" => "текст",
				"TEMPLATE" => "include_area.php",
			)
		); ?>
	</div>
</section> <? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>