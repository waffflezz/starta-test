<?php
/**
 * @var \App\Kernel\View $view
 */
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Сравнение товаров</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/compare.css">
</head>
<body>
<?php $view->component('header'); ?>

<main class="compare-page">
    <h1 class="compare-title">Сравнение товаров</h1>
    <div id="compareContainer"></div>
</main>

<script type="module" src="/js/compare/index.js"></script>
</body>
</html>
