<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Реквизиты");
?>
<section class="section production">
	<div class="container">
		<div class="content">
			<? $APPLICATION->IncludeFile(
				SITE_DIR . "include/company/details.php.php",
				array(),
				array(
					"MODE" => "php",
					"NAME" => "текст о компании",
					"TEMPLATE" => "include_area.php",
				)
			); ?>
		</div>
	</div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>