<?php
$page_title = "Отзывы - Интернет магазин электроники";
$site_title = "Интернет магазин электроники";

ob_start();
?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .review {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        margin: 20px 0;
    }

    h3 {
        color: #A9A9A9;
    }

    p {
        line-height: 1.6;
    }
</style>


<div class="container">
    <div class="review">
        <h3>Отличный выбор и цены</h3>
        <p>Этот интернет-магазин порадовал меня разнообразием товаров и доступными ценами. Нашел все, что нужно, и приятно удивился ценам. Рекомендую всем!</p>
    </div>
    <div class="review">
        <h3>Быстрая доставка</h3>
        <p>Заказывал товары в этом магазине и был приятно удивлен скоростью доставки. Все пришло в целости и сохранности в ожидаемые сроки. Спасибо за оперативность!</p>
    </div>
    <div class="review">
        <h3>Отличный сервис поддержки</h3>
        <p>Нужно было разобраться с возвратом товара, и сотрудники службы поддержки интернет-магазина были очень внимательны и помогли решить все вопросы быстро и профессионально. Отличный сервис!</p>
    </div>
</div>

<?php
$body_content = ob_get_clean();

$footer_content = "© " . date("Y") . " Интернет магазин электроники";

include 'base.html';
?>