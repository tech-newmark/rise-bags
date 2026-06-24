<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Информация для потребителей Rise: основные права покупателей, обязанности изготовителя, гарантийные сроки и перечень документов для работы с компанией.");
$APPLICATION->SetPageProperty("title", "Потребителю — права, документы и информация о товарах Rise");
$APPLICATION->SetTitle("Информация потребителю");
?>
<section class="section">
	<div class="container">
		<div class="content">
			<? $APPLICATION->IncludeFile(
				SITE_DIR . "include/company/customers-info.php",
				array(),
				array(
					"MODE" => "html",
					"NAME" => "текст",
					"TEMPLATE" => "include_area.php",
				)
			); ?>
		</div>
	</div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>