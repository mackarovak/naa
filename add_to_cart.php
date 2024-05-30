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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка аутентификации пользователя
    if (isset($_SESSION["username"])) {
        $userId = $_SESSION["username"];
        $name = $conn->real_escape_string($_POST["name"]);
        $price = floatval($_POST["price"]); // Преобразование в число

        // Подготовленный запрос для безопасности
        $stmt = $conn->prepare("INSERT INTO carts (user_id, product_name, price) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $userId, $name, $price);

        if ($stmt->execute()) {
            echo "Товар успешно добавлен в корзину";
        } else {
            echo "Ошибка при добавлении товара в корзину";
        }
        $stmt->close();
    } else {
        echo "Ошибка аутентификации пользователя";
    }
}
$conn->close();
?>