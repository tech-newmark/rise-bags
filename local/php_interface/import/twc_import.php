<?
use Bitrix\Highloadblock as HL; 
use Bitrix\Main\Entity;
class twc_import {
	public $CIBlockSection = null;
	public $CIBlockElement = null;
	
	public $prop_replaces = [
		'PROP_GENDER' => [
			'Любой' => 'Унисекс'
		],
		'PROP_MATERIAL' => [
			'нейлон' => 'Нейлон',
			'полиуретан' => 'Полиуретан',
			'полиэстер' => 'Полиэстер'
		],
		'color' => [
			'красный' => 'Красный',
			'зеленый' => 'Зеленый',
			'синий' => 'Синий',
			'розовый' => 'Розовый',
			'голубой' => 'Голубой',
			'серый' => 'Серый',
			'фиолетовый' => 'Фиолетовый',
			'оранжевый' => 'Оранжевый',
			'коричневый' => 'Коричневый',
			'черный' => 'Черный',
			'тёмно-серый' => 'Тёмно-серый',
			'тёмно-синий' => 'Тёмно-синий',
			'0' => ''
		]
	];
	
	function __construct() {
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
		ini_set('display_errors', 1);
		\Bitrix\Main\Loader::includeModule('iblock');
		\Bitrix\Main\Loader::includeModule('catalog');
		\Bitrix\Main\Loader::includeModule('highloadblock');
		
		$this->CIBlockSection = new CIBlockSection;
		$this->CIBlockElement = new CIBlockElement;
	}
	function print_r($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';
	}
	
	function getSectionMap() {
		$r = CIBlockSection::getList(
			[ 'SORT' => 'ASC' ],
			[ 'IBLOCK_ID' => 2 ],
			false,
			[ 'ID', 'EXTERNAL_ID' ]
		);
		
		$map = [];
		while ($section = $r->GetNext()) {
			$map[$section['EXTERNAL_ID']] = $section['ID'];
		}
		return $map;
	}
	
	function getItemMap() {
		$r = CIBlockElement::getList(
			[ 'SORT' => 'ASC' ],
			[ 'IBLOCK_ID' => 2 ],
			false, false,
			[ 'ID', 'EXTERNAL_ID' ]
		);
		
		$map = [];
		while ($item = $r->GetNext()) {
			$map[$item['EXTERNAL_ID']] = $item['ID'];
		}
		return $map;
	}
	
	function getVarsMap() {
		$r = CIBlockElement::getList(
			[ 'SORT' => 'ASC' ],
			[ 'IBLOCK_ID' => 3 ],
			false, false,
			[ 'ID', 'EXTERNAL_ID' ]
		);
		
		$map = [];
		while ($item = $r->GetNext()) {
			$map[$item['EXTERNAL_ID']] = $item['ID'];
		}
		return $map;
	}
	
	function getHlVars($id) {
		$hlblock = HL\HighloadBlockTable::getById($id)->fetch(); 

		$entity = HL\HighloadBlockTable::compileEntity($hlblock); 
		$entity_data_class = $entity->getDataClass(); 

		$rsData = $entity_data_class::getList(array(
			"select" => array("*"),
			"order" => array("ID" => "ASC"),
		));

		$r = [];
		while($arData = $rsData->Fetch()){
			$r[$arData['UF_NAME']] = $arData['UF_XML_ID'];
		}

		return $r;		
	}
	
	function getEnumVars($code) {
		$property_enums = CIBlockPropertyEnum::GetList([], [ "IBLOCK_ID" => 2, "CODE" => $code ]);
		$res = [];
		while($e = $property_enums->GetNext()) {	
			$res[$e["VALUE"]] = $e['ID'];
		}
		
		return $res;
	}
	
	function importVarProps() {
		
		$colors = $this->getHlVars(2);
		
		//$dir['COLOR_REF'] = $this->getEnumVars('COLOR_REF');
		//$this->print_r($dir); die();
		
		$vars_map = $this->getVarsMap();
		
		$f = __DIR__.'/export_items.json';
		$data = json_decode(file_get_contents($f), true);
		
		//$this->print_r($data); die();
		
		$image_props = [ 'img', 'img2', 'img3', 'img4', 'img5', 'img6' ];
		$unknown_colors = [];
		
		foreach ($data as $item) {
			$price = $item['props']['price'];
			foreach ($item['variants'] as $var) {
				$color = $var['props']['color'];
				if (!$color) continue;
				
				if (array_key_exists($color, $this->prop_replaces['color'])) $color = $this->prop_replaces['color'][$color];
				if (!array_key_exists($color, $colors)) $unknown_colors[$color]++;
				
				$this->print_r($vars_map[$var['subitem_id']]);
				$this->print_r([
					'COLOR_REF' => $colors[$color]
				]);
				
				
				CIBlockElement::SetPropertyValuesEx($vars_map[$var['subitem_id']], 3, [
					'COLOR_REF' => $colors[$color]
				]);
				
				
				
				
				/*
				if ($price) {
					CPrice::Add([
						'PRODUCT_ID' => $vars_map[$var['subitem_id']],
						'CATALOG_GROUP_ID' => 1,
						'PRICE' => $price,
						"CURRENCY" => "RUB",
					]);
				}
				*/
				
				
				/*
				
				$properties = [];
				
				foreach ($image_props as $prop) {
					if ($var['props'][$prop]) $properties['MORE_PHOTO'][] = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/tmp_images/'.$var['props'][$prop]);
				}
				
				if ($var['props']['square']) {
					$properties['COLOR_IMAGE'] = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/tmp_images/'.$var['props']['square']);
				}
				
				CIBlockElement::SetPropertyValuesEx($vars_map[$var['subitem_id']], 3, $properties);
				//$this->print_r($vars_map[$var['subitem_id']]);
				//$this->print_r($properties);
				//die();
				*/
			}
		}
		
		$this->print_r($unknown_colors);
	}
	
	function importVars() {
		$item_map = $this->getItemMap();
		//$this->print_r($item_map); die();
		
		$f = __DIR__.'/export_items.json';
		$data = json_decode(file_get_contents($f), true);
		
		foreach ($data as $item) {
			$item_id = $item_map[$item['item_id']];
			
			foreach ($item['variants'] as $var) {
				$arFields = [
					'IBLOCK_ID' => 3,
					'EXTERNAL_ID' => $var['subitem_id'],
					'NAME' => $var['title'],
					'ACTIVE' => $var['enabled'] ? 'Y' : 'N',
					'PROPERTY_VALUES' => [
						'CML2_LINK' => $item_id
					]
				];
				
				$this->print_r($arFields);
				$id = $this->CIBlockElement->Add($arFields);
				
				CCatalogProduct::Add(["ID" => $id, "QUANTITY" => 10000 ]);
				
				if (!$id) $this->print_r($this->CIBlockElement->LAST_ERROR);
				

			}
		}
	}
	
	function importItemProps() {
		$section_map = $this->getSectionMap();
		$item_map = $this->getItemMap();
		$dir = [];
		$dir['PROP_GENDER'] = $this->getEnumVars('PROP_GENDER');
		$dir['PROP_MATERIAL'] = $this->getEnumVars('PROP_MATERIAL');
		
		//$this->print_r($dir); die();
		
		
		$f = __DIR__.'/export_items.json';
		$data = json_decode(file_get_contents($f), true);

		$this->print_r($data);
		
		$props_map = [
			'new' => 'NEW',
			'popular' => 'POPULAR',
			'size' => 'PROP_SIZE',
			'material' => 'PROP_MATERIAL_FULL',
			'length' => 'PROP_LENGTH',
			'height' => 'PROP_HEIGHT',
			'width' => 'PROP_WIDTH',
			'volume' => 'PROP_VOLUME',
			'gender' => 'PROP_GENDER',
			'mat' => 'PROP_MATERIAL',
			'diagonals' => 'PROP_DIAG',
		];
		
		foreach ($data as $item) {
			$values = [];
			foreach ($props_map as $prop => $bx_prop) {
				if ($item['props'][$prop]) {
					$val = $item['props'][$prop];
					if (in_array($prop, [ 'new', 'popular' ])) $val = 'Y';
					
					if (array_key_exists($bx_prop, $dir)) {
						if (array_key_exists($val, $this->prop_replaces[$bx_prop])) $val = $this->prop_replaces[$bx_prop][$val];
						if (!array_key_exists($val, $dir[$bx_prop])) $this->print_r('Unknown '.$bx_prop.': '.$val);
						$val = $dir[$bx_prop][$val];
					}
					
					$values[$bx_prop] = $val;
				}
			}
			
			CIBlockElement::SetPropertyValuesEx($item_map[$item['item_id']], 2, $values);
			
			//$this->print_r($item['props']);
			//$this->print_r($values);
		}
		
		die('OK');
	}
	
	function importArticles() {
		$f = __DIR__.'/export_articles.json';
		$data = json_decode(file_get_contents($f), true);
		
		foreach ($data as $item) {
			$item['alias'] = end(explode('/', trim($item['url'], '/')));
			
			$item['content'] = str_replace('/resources/catalog/', '/tmp_images2/articles/', $item['content']);
			$arFields = [
				'IBLOCK_ID' => 11,
				'EXTERNAL_ID' => $item['item_id'],
				'NAME' => $item['title'],
				'ACTIVE' => $item['enable'] ? 'Y' : 'N',
				'CODE' => $item['alias'],
				'PREVIEW_TEXT' => $item['announce'],
				'PREVIEW_TEXT_TYPE' => 'text',
				'DETAIL_TEXT_TYPE' => 'html',
				'DETAIL_TEXT' => $item['content'],
				'DETAIL_TEXT_TYPE' => 'html',
				'IPROPERTY_TEMPLATES' => [
					"SECTION_META_TITLE" => $item['seo_title'],
					"SECTION_META_DESCRIPTION" => $item['seo_description'],
					"SECTION_PAGE_TITLE" => $item['short_title']
				]
			];
			if ($item['image']) $arFields['DETAIL_PICTURE'] = CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/tmp_images2/'.$item['image']);
			
			$this->print_r($arFields);
			
			$id = $this->CIBlockElement->Add($arFields);
			if (!$id) $this->print_r($this->CIBlockElement->LAST_ERROR);
		}
		
	}
	
	function importItems() {
		$map = $this->getSectionMap();
		
		$f = __DIR__.'/export_items.json';
		$data = json_decode(file_get_contents($f), true);
		
		foreach ($data as $item) {
			$item['alias'] = end(explode('/', trim($item['url'], '/')));
			$this->print_r($item);
			$arFields = [
				'IBLOCK_ID' => 2,
				'EXTERNAL_ID' => $item['item_id'],
				'IBLOCK_SECTION_ID' => $map[$item['allocs'][0]['sect_id']],
				'NAME' => $item['title'],
				'ACTIVE' => $item['enable'] ? 'Y' : 'N',
				'CODE' => $item['alias'],
				'DETAIL_TEXT' => $item['props']['description'],
				'DETAIL_TEXT_TYPE' => 'html',
				'IPROPERTY_TEMPLATES' => [
					"SECTION_META_TITLE" => $item['seo_title'],
					"SECTION_META_DESCRIPTION" => $item['seo_description'],
					"SECTION_PAGE_TITLE" => $item['short_title']
				]
			];
			
			foreach ($item['allocs'] as $alloc) {
				$arFields['IBLOCK_SECTION'][] = $map[$alloc['sect_id']];
			}
			
			$this->print_r($arFields);
			
			$id = $this->CIBlockElement->Add($arFields);
			if (!$id) $this->print_r($this->CIBlockElement->LAST_ERROR);

		}
		
	}
	
	
	function importSections() {
		$f = __DIR__.'/export_sections.json';
		$data = json_decode(file_get_contents($f), true);
		
		//$this->print_r($data); die();
		
		$section_map = [
			'e40fde2c' => '',
		];
		
		foreach ($data as $section) {
			
			if ($section['url'] == '/aksessuari/poyasnie_sumki/') $section['url'] = '/aksessuari/poyasnie_sumki2/';
			
			$section['alias'] = end(explode('/', trim($section['url'], '/')));
						
			$arFields = [
				"ACTIVE" => $section['enable'] ? 'Y' : 'N',
				"IBLOCK_SECTION_ID" => $section_map[$section['p_sect_id']],
				"CODE" => $section['alias'],
				"EXTERNAL_ID" => $section['sect_id'],
				"IBLOCK_ID" => 2,
				"NAME" => $section['title'],
				"SORT" => $section['ord']*10,
				"DESCRIPTION" => $section['props']['txt'],
				"DESCRIPTION_TYPE" => 'html',
				"IPROPERTY_TEMPLATES" => [
					"SECTION_META_TITLE" => $section['seo_title'],
					"SECTION_META_DESCRIPTION" => $section['seo_description'],
					"SECTION_PAGE_TITLE" => $section['short_title']
				]
			];
			
			if (array_key_exists('img', $section['props'])) {
				$img = 'https://rise-bags.ru/resources/catalog/images/'.$section['props']['img'];
				$local_img = $_SERVER['DOCUMENT_ROOT'].'/tmp_images/'.$section['props']['img'];
				//$this->print_r($img.'=>'.$local_img);
				if (!file_exists($local_img)) copy($img, $local_img);
				$arFields['PICTURE'] = CFile::MakeFileArray($local_img);
			}

			//$this->print_r($arFields);
			$id = $this->CIBlockSection->Add($arFields);
			if (!$id) $this->print_r($this->CIBlockSection->LAST_ERROR);
			
			$section_map[$section['sect_id']] = $id;
		}
		
		$this->print_r($section_map);
	}
}
?>