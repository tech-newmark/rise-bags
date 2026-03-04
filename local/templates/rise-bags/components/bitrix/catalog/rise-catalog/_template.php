<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

global $vite;

$componentName = 'bitrix/catalog/rise-catalog';
$cssPath = $vite->getComponentCss($componentName);
$jsPath = $vite->getComponentJs($componentName);

if ($cssPath) $this->addExternalCss($cssPath);
if ($jsPath) $this->addExternalJs($jsPath);

?>

<?/* debug($arResult) */ ?>