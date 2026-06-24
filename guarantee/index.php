<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Условия гарантии и возврата товаров Rise: гарантийные сроки по ГОСТ 28631-2005, допустимая нагрузка, возврат товара надлежащего и ненадлежащего качества.");
$APPLICATION->SetPageProperty("title", "Гарантия и возврат Rise — условия обмена и возврата товаров");
$APPLICATION->SetTitle("Гарантия");
?>
<section class="section content-page">
	<div class="container">
		<div class="grid">
			<div class="content">
				<? $APPLICATION->IncludeFile(
					SITE_DIR . "include/guarantee.php",
					array(),
					array(
						"MODE" => "html",
						"NAME" => "текст",
						"TEMPLATE" => "include_area.php",
					)
				); ?>
			</div>
			<div class="content">
				<div class="content-page__img-wrapper">
					<? $APPLICATION->IncludeFile(
						SITE_DIR . "include/guarantee-img.php",
						array(),
						array(
							"MODE" => "html",
							"NAME" => "изображение",
							"TEMPLATE" => "include_area.php",
						)
					); ?>
				</div>
			</div>
		</div>
	</div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>