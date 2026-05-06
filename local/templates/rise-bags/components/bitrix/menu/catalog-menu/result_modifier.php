<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$sectionsById = [];
$sectionsByCode = [];
$sectionIds = [];
$sectionCodes = [];

foreach ($arResult as $item) {
  if (!empty($item["PARAMS"]["SECTION_ID"])) {
    $sectionIds[] = (int)$item["PARAMS"]["SECTION_ID"];
  }

  $linkPath = trim((string)$item["LINK"], "/");
  if ($linkPath !== "") {
    $parts = explode("/", $linkPath);
    $sectionCode = (string)end($parts);
    if ($sectionCode !== "") {
      $sectionCodes[] = $sectionCode;
    }
  }
}

$sectionIds = array_values(array_unique(array_filter($sectionIds)));
$sectionCodes = array_values(array_unique(array_filter($sectionCodes)));

if (CModule::IncludeModule("iblock")) {
  $filter = ["ACTIVE" => "Y"];

  if (!empty($arParams["IBLOCK_ID"])) {
    $filter["IBLOCK_ID"] = (int)$arParams["IBLOCK_ID"];
  } else {
    $filter["IBLOCK_ID"] = 2;
  }

  if (!empty($sectionIds) || !empty($sectionCodes)) {
    if (!empty($sectionIds)) {
      $filter["ID"] = $sectionIds;
    }
    if (!empty($sectionCodes)) {
      $filter["=CODE"] = $sectionCodes;
    }

    $rsSections = CIBlockSection::GetList(
      [],
      $filter,
      false,
      ["ID", "CODE", "PICTURE", "DETAIL_PICTURE"]
    );

    while ($section = $rsSections->Fetch()) {
      $imageId = (int)$section["PICTURE"] > 0 ? (int)$section["PICTURE"] : (int)$section["DETAIL_PICTURE"];
      $imageSrc = $imageId > 0 ? (string)CFile::GetPath($imageId) : "";

      $section["IMAGE_SRC"] = $imageSrc;
      $sectionsById[(int)$section["ID"]] = $section;
      if (!empty($section["CODE"])) {
        $sectionsByCode[(string)$section["CODE"]] = $section;
      }
    }
  }
}

$getItemImage = static function (array $item) use ($sectionsById, $sectionsByCode): string {
  if (!empty($item["PARAMS"]["IMAGE_SRC"])) {
    return (string)$item["PARAMS"]["IMAGE_SRC"];
  }
  if (!empty($item["PARAMS"]["PICTURE"])) {
    return (string)$item["PARAMS"]["PICTURE"];
  }

  if (!empty($item["PARAMS"]["SECTION_ID"])) {
    $sectionId = (int)$item["PARAMS"]["SECTION_ID"];
    if ($sectionId > 0 && !empty($sectionsById[$sectionId]["IMAGE_SRC"])) {
      return (string)$sectionsById[$sectionId]["IMAGE_SRC"];
    }
  }

  $linkPath = trim((string)$item["LINK"], "/");
  if ($linkPath !== "") {
    $parts = explode("/", $linkPath);
    $sectionCode = (string)end($parts);
    if ($sectionCode !== "" && !empty($sectionsByCode[$sectionCode]["IMAGE_SRC"])) {
      return (string)$sectionsByCode[$sectionCode]["IMAGE_SRC"];
    }
  }

  return "";
};

$groupedMenu = [];
$currentParentIndex = -1;

foreach ($arResult as $item) {
  $depthLevel = (int)$item["DEPTH_LEVEL"];
  $item["IMAGE_SRC"] = $getItemImage($item);

  if ($depthLevel === 2) {
    $groupedMenu[] = [
      "PARENT" => $item,
      "CHILD" => [],
    ];
    $currentParentIndex = count($groupedMenu) - 1;
    continue;
  }

  if ($depthLevel === 3 && $currentParentIndex >= 0) {
    $groupedMenu[$currentParentIndex]["CHILD"][] = $item;
  }
}

$arResult = $groupedMenu;
