#!/usr/bin/env node

import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";
import { createInterface } from "readline";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Получаем аргументы командной строки
const args = process.argv.slice(2);
const defaultName = "littleweb";
const templateName = args[0] || defaultName; // Единственный аргумент - имя шаблона
const targetDir = "local-test"; // Папка всегда local-test

const headerContent = `<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <link rel="shortcut icon" type="image/x-icon" href="<?= SITE_TEMPLATE_PATH ?>/favicon.ico" />

  <? \$APPLICATION->ShowHead(); ?>
  <title><? \$APPLICATION->ShowTitle() ?></title>
</head>

<body>
  <div id="panel"><? \$APPLICATION->ShowPanel(); ?></div>
  <main class="workarea">`;

const footerContent = `<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
</main>

<footer class="footer">
  <div class="container">
  </div>
</footer>

</body>

</html>`;

const descriptionContent = `<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$arTemplate = array("NAME" => "${templateName}", "DESCRIPTION" => "${templateName} - кастомный шаблон сайта");`;

const viteManifestContent = `<?php
// /local/php_interface/classes/ViteManifest.php

class ViteManifest
{
  private $manifest = null;
  private $templateName;
  private $templatePath;
  private $manifestPath;
  private $isManifestExists = false;
  private $buildDir = '_dist';

  public function __construct($templateName = '${defaultName}')
  {
    $this->templateName = $templateName;
    $this->templatePath = '/local/templates/' . $templateName;
    $this->manifestPath = $_SERVER['DOCUMENT_ROOT'] . $this->templatePath . '/' . $this->buildDir . '/manifest.json';

    $this->isManifestExists = file_exists($this->manifestPath);

    if ($this->isManifestExists) {
      $content = file_get_contents($this->manifestPath);
      $this->manifest = json_decode($content, true);
    }
  }

  /**
   * Получить путь к глобальному CSS файлу
   */
  public function getTemplateCss()
  {
    if (!$this->isManifestExists) {
      return $this->templatePath . '/' . $this->buildDir . '/template_styles.css';
    }

    $sourceKey = 'local/templates/' . $this->templateName . '/_src/scss/template.scss';

    if (isset($this->manifest[$sourceKey])) {
      return $this->templatePath . '/' . $this->buildDir . '/' . $this->manifest[$sourceKey]['file'];
    }

    return $this->templatePath . '/' . $this->buildDir . '/template_styles.css';
  }

  /**
   * Получить путь к глобальному JS файлу
   */
  public function getTemplateJs()
  {
    if (!$this->isManifestExists) {
      return $this->templatePath . '/' . $this->buildDir . '/template_scripts.js';
    }

    $sourceKey = 'local/templates/' . $this->templateName . '/_src/js/index.js';

    if (isset($this->manifest[$sourceKey])) {
      return $this->templatePath . '/' . $this->buildDir . '/' . $this->manifest[$sourceKey]['file'];
    }

    return $this->templatePath . '/' . $this->buildDir . '/template_scripts.js';
  }

  /**
   * Получить путь к CSS файлу компонента
   */
  public function getComponentCss($componentPath)
  {
    if (!$this->isManifestExists) {
      $folderPath = str_replace('.', '/', $componentPath);
      return $this->templatePath . '/components/bitrix/' . $folderPath . '/style.css';
    }

    $sourceKey = 'local/templates/' . $this->templateName . '/components/bitrix/' . $componentPath . '/_src/scss/index.scss';

    if (isset($this->manifest[$sourceKey])) {
      return $this->templatePath . '/' . $this->buildDir . '/' . $this->manifest[$sourceKey]['file'];
    }

    $folderPath = str_replace('.', '/', $componentPath);
    return $this->templatePath . '/components/bitrix/' . $folderPath . '/style.css';
  }

  /**
   * Получить путь к JS файлу компонента
   */
  public function getComponentJs($componentPath)
  {
    if (!$this->isManifestExists) {
      $folderPath = str_replace('.', '/', $componentPath);
      return $this->templatePath . '/components/bitrix/' . $folderPath . '/script.js';
    }

    $sourceKey = 'local/templates/' . $this->templateName . '/components/bitrix/' . $componentPath . '/_src/js/index.js';

    if (isset($this->manifest[$sourceKey])) {
      return $this->templatePath . '/' . $this->buildDir . '/' . $this->manifest[$sourceKey]['file'];
    }

    $folderPath = str_replace('.', '/', $componentPath);
    return $this->templatePath . '/components/bitrix/' . $folderPath . '/script.js';
  }

  /**
   * Получить URL изображения (для использования в PHP)
   */
  public function getImageUrl($imagePath)
  {
    if ($this->isManifestExists) {
      $imageName = basename($imagePath);

      foreach ($this->manifest as $key => $value) {
        if (strpos($key, $imageName) !== false || (isset($value['src']) && strpos($value['src'], $imageName) !== false)) {
          return $this->templatePath . '/' . $this->buildDir . '/' . $value['file'];
        }
      }
    }

    // Если не нашли в манифесте или нет манифеста
    return $this->templatePath . '/' . $this->buildDir . '/images/' . basename($imagePath);
  }

  public function hasManifest()
  {
    return $this->isManifestExists;
  }

  public function debug()
  {
    echo '<pre>';
    echo "=== ОТЛАДКА VITE MANIFEST ===\n";
    echo "Шаблон: " . $this->templateName . "\n";
    echo "Путь к манифесту: " . $this->manifestPath . "\n";
    echo "Манифест загружен: " . ($this->isManifestExists ? 'ДА' : 'НЕТ') . "\n";

    if ($this->isManifestExists) {
      echo "\n--- Примеры ключей манифеста ---\n";
      $i = 0;
      foreach ($this->manifest as $key => $value) {
        $i++;
        if ($i > 5) break;
        echo "\nКЛЮЧ: " . $key . "\n";
        echo "  file: " . $value['file'] . "\n";
        if (isset($value['src'])) {
          echo "  src: " . $value['src'] . "\n";
        }
      }

      echo "\n--- Результаты методов ---\n";
      echo "getTemplateCss(): " . $this->getTemplateCss() . "\n";
      echo "getTemplateJs(): " . $this->getTemplateJs() . "\n";
      echo "getImageUrl('hero-bg.png'): " . $this->getImageUrl('hero-bg.png') . "\n";
    }
    echo '</pre>';
  }
}`;

const assetsContent = `<?php

use Bitrix\\Main\\Page\\Asset;

if (!function_exists('includeComponentAssets')) {
  /**
   * Подключает CSS и JS файлы Vite компонентов
   * 
   * @param string|array $components
   * @return bool
   */
  function includeComponentAssets($components)
  {
    global $vite;

    if (!isset($vite) || !is_object($vite)) {
      if (defined('BX_LOG')) {
        AddMessage2Log('Vite object not found in includeComponentAssets', 'vite');
      }
      return false;
    }

    $components = is_array($components) ? $components : [$components];
    $asset = Asset::getInstance();

    foreach ($components as $componentName) {
      if (empty($componentName) || !is_string($componentName)) {
        continue;
      }

      $cssPath = $vite->getComponentCss($componentName);
      $jsPath = $vite->getComponentJs($componentName);

      if ($cssPath) {
        $asset->addCss($cssPath);
      }

      if ($jsPath) {
        $asset->addJs($jsPath);
      }
    }

    return true;
  }
}

if (!function_exists('includeGlobalAssets')) {
  /**
   * Подключает глобальные ассеты Vite
   * 
   * @return bool
   */
  function includeGlobalAssets()
  {
    global $vite;

    if (!isset($vite) || !is_object($vite)) {
      return false;
    }

    $asset = Asset::getInstance();

    $cssFile = $vite->getTemplateCss();
    if ($cssFile) {
      $asset->addCss($cssFile);
    }

    $jsFile = $vite->getTemplateJs();
    if ($jsFile) {
      $asset->addJs($jsFile);
    }

    return true;
  }
}`;

const coreContent = `<?php
if (!function_exists('initBitrixCore')) {
  /**
   * Инициализирует ядро Битрикс
   * 
   * @param array|string $modules
   */
  function initBitrixCore($modules = ['popup'])
  {
    $modules = is_array($modules) ? $modules : [$modules];

    $availableModules = array_intersect($modules, ['popup', 'ajax', 'date', 'fx', 'json']);

    if (!empty($availableModules)) {
      \\CJSCore::Init($availableModules);
    }
  }
}`;

const debugContent = `<?php

if (!function_exists('debug')) {
  /**
   * Простая функция для отладки
   * 
   * @param mixed $data
   * @param bool $die
   */
  function debug($data, $die = false)
  {
    echo '<pre>' . print_r($data, true) . '</pre>';

    if ($die) {
      die('DEBUG STOP');
    }
  }
}`;

const initContent = `<?php

// use Bitrix\\Main\\Page\\Asset;
use Bitrix\\Main\\EventManager;

// Загружаем манифест
require_once $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/classes/ViteManifest.php';

// Создаём глобальный объект Vite
global $vite;
$vite = new ViteManifest('${templateName}');

// Подключаем все вспомогательные файлы
$includesPath = $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/includes/';
require_once $includesPath . 'assets.php';
require_once $includesPath . 'core.php';
require_once $includesPath . 'debug.php';

// Подключаю глобальные стили и скрипты
EventManager::getInstance()->addEventHandler(
  'main',
  'OnPageStart',
  function () {
    includeGlobalAssets();
    initBitrixCore('popup');
  }
);`;

const varsScssContent = `:root {
	--primary-font: ;
	--secondary-font: ;

	--content-width: 1680px;
	--container-offset: clamp(10px, 2vw, 60px);
	--container-width: calc(var(--content-width) + (var(--container-offset) * 2));
	--content-fluid-width: 1920px;
	--container-fluid-offset: 0;
	--container-fluid-width: calc(
		var(--content-fluid-width) + (var(--container-offset) * 2)
	);

	--black: #000000;
	--white: #ffffff;
	--primary: #2b519d;
	--secondary: #f8f8f8;
	--warning: #f5c542;
	--danger: #e63e3e;
	--success: #42c486;
	--info: #fff8db;
	--dark: #222222;
	--light: #f4f4f4;

	--scrollbar-color: var(--secondary);
	--scrollbar-width: 10px;
	--scrollbar-height: 6px;
	--scrollbar-border-radius: 0;
	--scrollbar-thumb-color: var(--primary);
	--scrollbar-thumb-border-radius: 0;

	--site-base-font-family: var(--primary-font);
	--site-base-font-weight: 400;
	--site-base-font-size: 16px;
	--site-base-line-height: 1.2;
	--site-base-letter-spacing: 0.015em;
	--site-base-text-color: var(--dark);
	--site-bg-color: var(--white);

	--main-transition: 0.25s ease;
}`;

const containerQueriesContent = `@mixin container-down($name, $width) {
  @container #{$name} (max-width: #{$width - 0.01px}) {
    @content;
  }
}

@mixin container-up($name, $width) {
  @container #{$name} (min-width: #{$width} ) {
    @content;
  }
}`;

const fontsContent = `@mixin font-face($font-family, $url, $weight, $style) {
	@font-face {
		font-family: "#{$font-family}";
		src: url("@fonts/#{$url}.woff2") format("woff2");
		font-weight: #{$weight};
		font-display: swap;
		font-style: $style;
	}
}

@include font-face("Roboto", "Roboto-Regular", 400, normal);`;

const resetContent = `@use "@scss/extends/index";

*,
*::before,
*::after {
	box-sizing: border-box;
}

html,
body {
	margin: 0;
	padding: 0;
	width: 100%;
	min-height: 100vh;
	min-height: 100dvh;
	text-size-adjust: none;
	scroll-behavior: smooth;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	text-rendering: optimizeLegibility;
	scrollbar-gutter: stable;
}

* {
	&::-webkit-scrollbar {
		background-color: transparent;
		width: var(--scrollbar-width);
		border-radius: var(--scrollbar-border-radius);
		height: var(--scrollbar-height);
	}

	&::-webkit-scrollbar-thumb {
		background-color: var(--scrollbar-thumb-color);
		border-radius: var(--scrollbar-thumb-border-radius);
	}
}

body {
	position: relative;
	display: flex;
	flex-direction: column;
	font-family: var(--site-base-font-family);
	font-weight: var(--site-base-font-weight);
	font-size: var(--site-base-font-size);
	line-height: var(--site-base-line-height);
	letter-spacing: var(--site-base-letter-spacing);
	color: var(--site-base-text-color);
	background-color: var(--site-bg-color);
	overflow-x: hidden !important;
	-webkit-font-smoothing: antialiased;
	scrollbar-gutter: stable;

	&.body-locked {
		overflow: hidden;
	}
}

footer {
	margin-top: auto;
}

button,
[data-fancybox],
input[type="submit"] {
	cursor: pointer;
}

input[type="number"] {
	appearance: none;
	-moz-appearance: textfield;

	&::-webkit-inner-spin-button,
	&::-webkit-outer-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
}

picture,
img {
	display: flex;
}

a {
	color: var(--dark);
	text-decoration: none;
	cursor: pointer;

	@extend %hover-opacity;
}

address {
	font-style: normal;
}

q {
	font-style: italic;
}

cite {
	font-weight: 500;
	font-style: normal;
}

button,
input,
label {
	cursor: pointer;
}

.visually-hidden {
	position: absolute;
	width: 1px;
	height: 1px;
	margin: -1px;
	padding: 0;
	border: 0;
	clip: rect(0 0 0 0);
	overflow: hidden;
}

ul,
ol {
	clear: both;
}`;

const typographyContent = `h1,
h2,
h3,
h4,
h5,
h6 {
	line-height: 1.2;
	margin: 0;
	margin-bottom: 0.75em;
	font-weight: 500;
}

h1,
.h1 {
	font-size: clamp(28px, 5vw, 36px);
}

h2 {
	font-size: clamp(22px, 1.8vw, 32px);
}

h3 {
	font-size: clamp(20px, 1.6vw, 28px);
}

h4 {
	font-size: clamp(18px, 1.4vw, 24px);
}

h5 {
	font-size: clamp(18px, 1.2vw, 22px);
}

h6 {
	font-size: clamp(18px, 1vw, 20px);
}

p {
	margin: 0;
	margin-bottom: 1em;
}

.title {
	font-size: clamp(24px, 3.2vw, 36px);
	font-weight: 600;
	text-transform: uppercase;
	color: var(--primary);
}`;

const templateScssContent = `@use "@scss/base/reset";
@use "@scss/base/vars";
@use "@scss/base/fonts";
@use "@scss/base/typography";
@use "@scss/base/container-queries" as *;
@use "@scss/extends/index" as *;
@use "@scss/vendors/index" as *;

@use "@scss/layout/containers";
@use "@scss/layout/header";
@use "@scss/layout/section";

@use "@scss/components/index" as *;

@use "@scss/layout/footer";`;

const extendsIndexContent = `%hover-opacity {
	transition: opacity 0.3s ease-in-out;
	opacity: 1;

	@media (hover: hover) {
		&:hover {
			opacity: 0.6;
		}
	}

	&:focus {
		opacity: 0.6;
	}

	&:active {
		opacity: 0.4;
	}
}`;

const containersLayoutContent = `@use "@scss/base/vars";
.container {
	width: 100%;
	height: 100%;
	margin: 0 auto;
	padding: 0 var(--container-offset);
	max-width: var(--container-width);
}`;

const footerLayoutContent = `@use "@scss/base/container-queries" as *;

.footer {}`;

const headerLayoutContent = `@use "@scss/base/container-queries" as *;

.header {}`;

const sectionLayoutContent = `.section {}`;

// Базовая структура с динамическим именем шаблона
function getStructure(templateName) {
	return {
		php_interface: {
			classes: {
				"ViteManifest.php": viteManifestContent,
			},
			includes: {
				"assets.php": assetsContent,
				"core.php": coreContent,
				"debug.php": debugContent,
			},
			"init.php": initContent,
		},
		templates: {
			[templateName]: {
				_src: {
					fonts: {},
					images: {},
					js: {
						modules: {},
						"index.js": "",
					},
					scss: {
						base: {
							"_container-queries.scss": containerQueriesContent,
							"_fonts.scss": fontsContent,
							"_reset.scss": resetContent,
							"_typography.scss": typographyContent,
							"_vars.scss": varsScssContent,
						},
						components: {},
						extends: {
							"index.scss": extendsIndexContent,
						},
						layout: {
							"_containers.scss": containersLayoutContent,
							"_footer.scss": footerLayoutContent,
							"_header.scss": headerLayoutContent,
							"_section.scss": sectionLayoutContent,
						},
						vendors: {},
						"template.scss": templateScssContent,
					},
					sprite: {},
				},
				components: {
					bitrix: {}, // Только папка
				},
				"description.php": descriptionContent,
				"header.php": headerContent,
				"footer.php": footerContent,
				"README.md": "", // Пустой
			},
		},
	};
}

// Функция создания структуры
function createStructure(basePath, struct) {
	Object.entries(struct).forEach(([name, content]) => {
		const fullPath = path.join(basePath, name);

		if (typeof content === "object" && content !== null) {
			// Это папка
			if (!fs.existsSync(fullPath)) {
				fs.mkdirSync(fullPath, { recursive: true });
				console.log(`📁 Создана папка: ${fullPath}`);
			}
			// Рекурсивно создаём содержимое папки
			createStructure(fullPath, content);
		} else {
			// Это файл
			if (!fs.existsSync(fullPath)) {
				fs.writeFileSync(fullPath, content);
				console.log(`📄 Создан файл: ${fullPath}`);
			} else {
				console.log(`⚠️ Файл уже существует: ${fullPath}`);
			}
		}
	});
}

// Функция для запроса подтверждения
async function askConfirmation(question) {
	const rl = createInterface({
		input: process.stdin,
		output: process.stdout,
	});

	return new Promise((resolve) => {
		rl.question(question, (answer) => {
			rl.close();
			resolve(answer.toLowerCase() === "y" || answer.toLowerCase() === "yes");
		});
	});
}

// Точка входа
const baseDir = path.join(process.cwd(), targetDir);

console.log(`🚀 Создание структуры проекта в ${baseDir}`);
console.log(`📝 Имя шаблона: ${templateName}`);

if (fs.existsSync(baseDir)) {
	const answer = await askConfirmation(
		`⚠️ Папка ${targetDir} уже существует. Продолжить? (y/n) `,
	);

	if (answer) {
		const structure = getStructure(templateName);
		createStructure(baseDir, structure);
		console.log("✅ Структура успешно создана!");
	} else {
		console.log("❌ Операция отменена");
	}
} else {
	const structure = getStructure(templateName);
	createStructure(baseDir, structure);
	console.log("✅ Структура успешно создана!");
}
