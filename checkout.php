<?php
$servername = "mysql";
$username = "nuancce";
$password = "1";
$dbname = "database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

session_start();
if (isset($_SESSION['username'])) {
    $userId = $conn->real_escape_string($_SESSION['username']);

    // Перенос товаров из корзины в заказы
    $sql = "INSERT INTO orders (user_id, product_name, price) SELECT user_id, product_name, price FROM carts WHERE user_id = '$userId'";
    if ($conn->query($sql) === TRUE) {
        // Успешно перенесли товары в заказы, теперь очистим корзину
        $deleteCartSql = "DELETE FROM carts WHERE user_id = '$userId'";
        if ($conn->query($deleteCartSql) === TRUE) {
            echo "Заказ успешно оформлен";
        } else {
            echo "Ошибка при очистке корзины: " . $conn->error;
        }
    } else {
        echo "Ошибка при оформлении заказа: " . $conn->error;
    }

} else {
    echo "Пользователь не аутентифицирован";
}

$conn->close();
?>