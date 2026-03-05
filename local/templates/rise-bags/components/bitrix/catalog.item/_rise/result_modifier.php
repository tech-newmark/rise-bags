<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

if (!empty($arResult["ITEM"]["PROPERTIES"]["HIT"]["VALUE"])) {
  $labelBlockTemplate = '';

  foreach ($arResult["ITEM"]["PROPERTIES"]["HIT"]["VALUE_XML_ID"] as $label) {

    switch ($label) {
      case 'HIT':
        $labelTemplate = '<span class="product-label product-label--hit">Хит</span>';
        $labelBlockTemplate .= $labelTemplate;
        break;
      case 'RECOMMEND':
        $labelTemplate = '<span class="product-label product-label--recommend">Рекомендуем</span>';
        $labelBlockTemplate .= $labelTemplate;
        break;
      case 'NEW':
        $labelTemplate = '<span class="product-label product-label--new">Новинка</span>';
        $labelBlockTemplate .= $labelTemplate;
        break;
      case 'STOCK':
        $labelTemplate = '<span class="product-label product-label--stock">Акция</span>';
        $labelBlockTemplate .= $labelTemplate;
        break;

      default:
        break;
    }
  }

  $arResult["ITEM"]["NM_LABELS"] = $labelBlockTemplate;
}
