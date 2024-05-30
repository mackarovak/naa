<?php
session_start();

$servername = "mysql";
$username = "nuancce";
$password = "1";
$dbname = "database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_password'])) {
    $newPassword = $_POST['new_password'];
    $username = $_SESSION['username'];

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password='$hashedPassword' WHERE username='$username'";
    if ($conn->query($sql) === TRUE) {
        $message = "Пароль успешно изменен!";
    } else {
        $message = "Ошибка при изменении пароля: " . $conn->error;
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

// Запрос для получения заказов пользователя
$userId = $_SESSION['username'];
$ordersSql = "SELECT * FROM orders WHERE user_id = '$userId'";
$ordersResult = $conn->query($ordersSql);

ob_start();
?>

<style>
     body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    .center {
        display: flex;
        justify-content: center;
        align-items: flex-start; 
        height: 100vh;
    }

    .register-form {
        width: 350px;
        padding: 30px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #FFF;
        text-align: center;
        margin-top: 20px; 
    }

    .register-form input[type="password"] {
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 100%;
    }

    .register-form button {
        padding: 10px 20px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        background-color: #808080;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }
</style>

<div class="center">
    <div class="register-form">
        <h2 style='color: #808080;'>Личный кабинет</h2>
        <p>Имя пользователя: <?php echo $_SESSION['username']; ?></p>
        <form method='POST'>
            <label for='new_password'>Введите новый пароль:</label><br>
            <input type='password' id='new_password' name='new_password' required><br><br>
            <button type='submit'>Изменить пароль</button>
        </form>
        <form method='POST'>
            <button type='submit' name='logout'>Выход</button>
        </form>
        <h3>Ваши заказы:</h3>
        <ul>
            <?php
            if ($ordersResult->num_rows > 0) {
                while ($order = $ordersResult->fetch_assoc()) {
                    echo "<li> " . $order['product_name'] . " (Цена: " . $order['price'] . ")</li>";
                }
            } else {
                echo "<p>У вас пока нет заказов.</p>";
            }
            ?>
        </ul>
        <p style='color: #E4717A;'><?php if(isset($message)) { echo $message; } ?></p>
    </div>
</div>
<?php
$body_content = ob_get_clean();

$page_title = "Личный кабинет - Интернет магазин электроники";
$site_title = "Личный кабинет";
$menu_content = "<a href='main.php'>Главная</a> | <a href='contacts.php'>Контакты</a>";
$footer_content = "© 2024 Интернет магазин электроники";

include 'base.html';

$conn->close();
?>