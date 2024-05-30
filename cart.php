<?php
$servername = "mysql";
$username = "nuancce";
$password = "1";
$dbname = "database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

$sqlCreateOrdersTable = "CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    product_name VARCHAR(255),
    price DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sqlCreateOrdersTable);


$sqlCreatedeletesTable = "CREATE TABLE IF NOT EXISTS deletes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(50),
    product_name VARCHAR(255),
    price DECIMAL(10, 2),
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sqlCreatedeletesTable);

session_start();
if (isset($_SESSION['username'])) {
    $userId = $conn->real_escape_string($_SESSION['username']);
    $sql = "SELECT * FROM carts WHERE user_id = '$userId'";
    $result = $conn->query($sql);

    include 'base.html';
    ?>

    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Корзина</title>
        <style>
            /* Ваш стиль CSS здесь */
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Корзина</h1>
            <?php
            $totalPrice = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $totalPrice += $row["price"];
                    echo "<div class='product' id='product" . $row["id"] . "'>";
                    echo "<p>Название: " . htmlspecialchars($row["product_name"]) . "</p>";
                    echo "<p>Цена: " . $row["price"] . "</p>";
                    echo "<button onclick='deleteProduct(" . $row["id"] . ")'>Удалить</button>";
                    echo "</div>";
                }
            } else {
                echo "Корзина пуста";
            }
            echo "<p>Общая стоимость: <span id='totalPrice'>" . $totalPrice . "</span></p>";
            ?>
            <button onclick='checkout()'>Оформить заказ</button>
        </div>
    </body>
    </html>
    <script>
        function deleteProduct(productId) {
            var elem = document.getElementById("product" + productId);
            elem.remove();
            var price = parseInt(elem.querySelector('p:nth-child(2)').textContent.split(':')[1].trim());
            var totalPriceElem = document.getElementById('totalPrice');
            var totalPrice = parseInt(totalPriceElem.textContent);
            totalPrice -= price;
            totalPriceElem.textContent = totalPrice;
            
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_product.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("product_id=" + productId);
        }

        function deleteAllProducts() {
    var container = document.querySelector('.container');
    container.innerHTML = "<p>Корзина пуста</p>";
    document.getElementById('totalPrice').textContent = '0';
    
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "delete_all_products.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == XMLHttpRequest.DONE) {
            if (xhr.status == 200) {
                console.log("Все товары успешно удалены из корзины");
            } else {
                console.error("Ошибка при удалении товаров из корзины");
            }
        }
    };
    xhr.send();
}

        function checkout() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "checkout.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send();
        }
    </script>
    <?php

} else {
    include 'base.html';
    echo "Пользователь не аутентифицирован";
}

$conn->close();
?>