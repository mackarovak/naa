<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Уничтожаем сессию
session_unset();
session_destroy();

$page_title = "Добро пожаловать - Интернет магазин электроники";
$site_title = "Добро пожаловать в Интернет магазин электроники!";
$menu_content = "<a href='main.php'>Главная</a> | <a href='contacts.php'>Контакты</a> | <a href='register.php'>Регистрация</a> | <a href='login.php'>Вход</a>";
$body_content = "
<div style='text-align:center; margin-top: 50px;'>
    <h1>Вы успешно вышли из системы!</h1>
</div>";
$footer_content = "© 2024 Интернет магазин электроники";

include 'base.html';
?>