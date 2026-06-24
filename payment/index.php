<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Условия оплаты заказов Rise: оплата через сайт для розничных покупателей, безналичный расчет для оптовых клиентов, выставление счета и подтверждение заказа.");
$APPLICATION->SetPageProperty("title", "Оплата заказов Rise — онлайн-оплата и безналичный расчет");
$APPLICATION->SetTitle("Оплата");
?>
<section class="section content-page">
	<div class="container">
		<div class="grid">
			<div class="content">
				<? $APPLICATION->IncludeFile(
					SITE_DIR . "include/payment.php",
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
						SITE_DIR . "include/payment-img.php",
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