<?php
$servername = "mysql";
$username = "nuancce";
$password = "1";
$dbname = "database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productId = $conn->real_escape_string($_POST['product_id']);
    
    // Удаление товара из базы данных
    $sql = "DELETE FROM carts WHERE id = '$productId'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Товар успешно удален из корзины";
    } else {
        echo "Ошибка при удалении товара: " . $conn->error;
    }
}

$conn->close();
?>