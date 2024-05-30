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

    $deleteAllProductsSql = "DELETE FROM carts WHERE user_id = '$userId'";
    if ($conn->query($deleteAllProductsSql) === TRUE) {
        echo "Все товары из корзины успешно удалены";
    } else {
        echo "Ошибка при удалении всех товаров из корзины: " . $conn->error;
    }
} else {
    echo "Пользователь не аутентифицирован";
}

$conn->close();
?>