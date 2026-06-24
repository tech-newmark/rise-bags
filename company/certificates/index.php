<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Сертификаты компании Rise: документы, подтверждающие развитие производства сумок, рюкзаков и аксессуаров, статус предприятия и ответственное отношение к качеству продукции.");
$APPLICATION->SetPageProperty("title", "Сертификаты Rise — документы и подтверждение качества компании");
$APPLICATION->SetTitle("Сертификаты");
?>
<section class="section">
	<div class="container">
		<div class="content">
			<? $APPLICATION->IncludeFile(
				SITE_DIR . "include/company/certificates.php",
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