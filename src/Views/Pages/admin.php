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
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <?php $view->component('header'); ?>
    <?php $view->component('adminUpload'); ?>

    <script type="module" src="/js/admin/index.js"></script>
</body>
</html>