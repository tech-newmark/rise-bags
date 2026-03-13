<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

// Функция для удаления детальной картинки из массива
function removeDetailPicture($photos, $detailId)
{
  if (empty($photos) || empty($detailId)) return $photos;

  foreach ($photos as $key => $photo) {
    if ($photo['ID'] == $detailId) {
      unset($photos[$key]);
    }
  }

  return array_values($photos); // Переиндексация
}

// Функция для получения фото ТОВАРА (для режима PRODUCT_DISPLAY_MODE = 'N')
function getProductPhotos($item, $propCode)
{
  $slider = [];

  // Добавляем превью товара
  if (!empty($item['PREVIEW_PICTURE'])) {
    $slider[] = $item['PREVIEW_PICTURE'];
  }

  // Добавляем доп. фото товара из свойства MORE_PHOTO
  if (!empty($propCode) && !empty($item['PROPERTIES'][$propCode]['VALUE'])) {
    foreach ($item['PROPERTIES'][$propCode]['VALUE'] as $photoId) {
      $photo = CFile::GetFileArray($photoId);
      if ($photo) {
        $slider[] = $photo;
      }
    }
  }

  return $slider;
}

// Функция для получения фото ТП (для режима PRODUCT_DISPLAY_MODE = 'Y')
function getOfferPhotos($offer, $propCode)
{
  $slider = [];

  // Добавляем превью ТП
  if (!empty($offer['PREVIEW_PICTURE'])) {
    $slider[] = $offer['PREVIEW_PICTURE'];
  }

  // Добавляем доп. фото ТП из свойства
  if (!empty($propCode) && !empty($offer['PROPERTIES'][$propCode]['VALUE'])) {
    foreach ($offer['PROPERTIES'][$propCode]['VALUE'] as $photoId) {
      $photo = CFile::GetFileArray($photoId);
      if ($photo) {
        $slider[] = $photo;
      }
    }
  }

  return $slider;
}

// debug($arParams['PRODUCT_DISPLAY_MODE']);
// debug($arParams['OFFER_ADD_PICT_PROP']);
// debug($arParams['ADD_PICT_PROP']);

foreach ($arResult['ITEMS'] as &$item) {

  // Обрабатываем товары с ТП
  if (!empty($item['OFFERS'])) {

    // Определяем режим отображения
    $isSimpleMode = ($arParams['PRODUCT_DISPLAY_MODE'] === 'N');

    foreach ($item['OFFERS'] as &$offer) {
      $slider = [];

      if ($isSimpleMode) {
        // РЕЖИМ "ПРОСТОЙ" - берем фото из ТОВАРА
        $slider = getProductPhotos($item, $arParams['ADD_PICT_PROP']);
      } else {
        // РЕЖИМ "РАСШИРЕННЫЙ" - берем фото из ТП
        $slider = getOfferPhotos($offer, $arParams['OFFER_ADD_PICT_PROP']);

        // Удаляем детальную картинку ТП
        if (!empty($offer['DETAIL_PICTURE']['ID'])) {
          $slider = removeDetailPicture($slider, $offer['DETAIL_PICTURE']['ID']);
        }
      }

      // Заменяем MORE_PHOTO в JS_OFFERS
      if (!empty($item['JS_OFFERS'])) {
        foreach ($item['JS_OFFERS'] as &$jsOffer) {
          if ($jsOffer['ID'] == $offer['ID']) {
            $jsOffer['MORE_PHOTO'] = $slider;
            $jsOffer['MORE_PHOTO_COUNT'] = count($slider);
            break;
          }
        }
      }
    }

    // Формируем MORE_PHOTO для отображения в карточке (выбранное ТП)
    $selectedOffer = isset($item['OFFERS'][$item['OFFERS_SELECTED']])
      ? $item['OFFERS'][$item['OFFERS_SELECTED']]
      : reset($item['OFFERS']);

    if ($isSimpleMode) {
      // В простом режиме показываем фото товара
      $item['MORE_PHOTO'] = getProductPhotos($item, $arParams['ADD_PICT_PROP']);
    } else {
      // В расширенном режиме показываем фото выбранного ТП
      $item['MORE_PHOTO'] = getOfferPhotos($selectedOffer, $arParams['OFFER_ADD_PICT_PROP']);

      // Удаляем детальную картинку выбранного ТП
      if (!empty($selectedOffer['DETAIL_PICTURE']['ID'])) {
        $item['MORE_PHOTO'] = removeDetailPicture($item['MORE_PHOTO'], $selectedOffer['DETAIL_PICTURE']['ID']);
      }
    }

    $item['MORE_PHOTO_COUNT'] = count($item['MORE_PHOTO']);
    $item['SHOW_SLIDER'] = $item['MORE_PHOTO_COUNT'] > 1;
  }

  // Обрабатываем ОБЫЧНЫЙ ТОВАР (без ТП)
  if (empty($item['OFFERS'])) {
    $slider = [];

    // Добавляем превью товара
    if (!empty($item['PREVIEW_PICTURE'])) {
      $slider[] = $item['PREVIEW_PICTURE'];
    }

    // Добавляем доп. фото товара
    $propCode = $arParams['ADD_PICT_PROP'];
    if (!empty($propCode) && !empty($item['PROPERTIES'][$propCode]['VALUE'])) {
      foreach ($item['PROPERTIES'][$propCode]['VALUE'] as $photoId) {
        $photo = CFile::GetFileArray($photoId);
        if ($photo) {
          $slider[] = $photo;
        }
      }
    }

    // Удаляем детальную картинку товара
    if (!empty($item['DETAIL_PICTURE']['ID'])) {
      $slider = removeDetailPicture($slider, $item['DETAIL_PICTURE']['ID']);
    }

    $item['MORE_PHOTO'] = $slider;
    $item['MORE_PHOTO_COUNT'] = count($slider);
    $item['SHOW_SLIDER'] = count($slider) > 1;
  }
}
unset($item);
