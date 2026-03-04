<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);


if ($arResult["ITEMS"]): ?>
  <section class="section">
    <div class="container">
      <div class="tizzers-container">
        <div class="tizzers">
          <? foreach ($arResult["ITEMS"] as $arItem):
            $iconPath = CFile::GetPath($arItem["PROPERTIES"]["ICON"]["VALUE"]);
          ?>
            <div class="tizzers__item">
              <div class="tizzers__item-content-wrapper">
                <span class="tizzers__item-title"><?= $arItem["NAME"] ?></span>
                <p class="tizzers__item-text"><?= $arItem["PREVIEW_TEXT"] ?></p>
              </div>
              <? if ($iconPath): ?>
                <img src="<?= $iconPath ?>" alt="Иконка" width="60" height="60">
              <? endif; ?>
            </div>
          <? endforeach; ?>
        </div>
      </div>
    </div>
  </section>
<? endif; ?>