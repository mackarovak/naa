
<?php

$page_title = "Сертификаты";
$site_title = "Интернет магазин электроники";
$menu_content = "<a href='main.php' class='button'>Услуги</a> | <a href='ser.html' class='button'>Сертификат</a> | <a href='register.php' class='button'>Регистрация</a> | <a href='login.php' class='button'>Вход</a> | <a href='otzyv.php' class='button'>Отзывы</a> | <a href='contacts.php' class='button'>Контакты</a>";

$body_content = "
<div class='container'>
    <div class='product'>
        <img src='14.jpeg' alt='Сертификат 2'>
        <p class='price'>Цена: $100</p>
        <p class='price'>Цена: $1000</p>
        <p class='price'>Цена: $5000</p>
        <p class='price'>Цена: $10000</p>

    </div>
</div>
";

$footer_content = "© 2024 Интернет магазин электроники";

include 'base.html';
?>

<style>
    .price {
        font-weight: bold;
        color: #B0C4DE; 
    }
</style>