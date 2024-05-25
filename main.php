<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$page_title = "Интернет магазин электроники";
$site_title = "Добро пожаловать в Интернет магазин электроники!";

ob_start();

$servername = "mysql";
$username = "nuancce";
$password = "1";
$dbname = "database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

// Проверка входа пользователя
if (isset($_SESSION['username'])) {
    $menu_content = "<a href='#'>Главная</a> | <a href='#'>Контакты</a> | <a href='logout.php'>Выход</a>";
} else {
    $menu_content = "<a href='#'>Главная</a> | <a href='#'>Контакты</a> | <a href='register.php'>Регистрация</a> | <a href='login.php'>Вход</a>";
}

$search_query = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2),
    image_path VARCHAR(255)
)";
$conn->query($sql);

// Создание таблицы users
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
$conn->query($sql);

$search_query = isset($_GET['search']) ? $_GET['search'] : '';

// Создание таблицы "orders" (замените поля на необходимые)
$create_orders_table = "CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL
)";
$conn->query($create_orders_table);

$sql = "SELECT COUNT(*) as count FROM products";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$count = $row['count'];

if ($count == 0) {
    $sql = "INSERT INTO products (name, description, price, image_path) VALUES
            ('Ipad', 'Планшеты', 600.00, '1.jpeg'),
            ('Lenovo', 'Ноутбуки', 1000.00, '2.jpeg'),
            ('Xiaomi', 'Ноутбуки', 900.00, '3.jpeg'),
            ('Xiaomi', 'Планшеты', 1000.00, '5.jpeg'),
            ('Iphone', 'Смартфоны', 500.00, '6.jpg'),
            ('Monster', 'Мышки', 50.00, '7.jpg'),
            ('Logitech', 'Мышки', 50.00, '8.jpg'),
            ('Samsung', 'Смартфоны', 600.00, '4.jpeg')";
    $conn->query($sql);
}

$sql = "SELECT * FROM products";
$search_query = '';

if (isset($_GET['description']) && $_GET['description'] != '') {
    $selected_description = $conn->real_escape_string($_GET['description']);
    $sql .= " WHERE description = '" . $selected_description . "'";
}

if (isset($_GET['search']) && $_GET['search'] != '') {
    $search_query = $conn->real_escape_string($_GET['search']);
    $sql .= (strpos($sql, 'WHERE') === false ? ' WHERE' : ' AND') . " name LIKE '%" . $search_query . "%'";
}

$result = $conn->query($sql);
?>
<style>
    .pink-button {
        padding: 10px 20px;
        margin-top: 10px; /* Отступ над кнопкой */
        border: none;
        border-radius: 5px;
        background-color: #808080; /* Цвет кнопки */
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }
</style>



<div class='menu'>
    <div>
        <form method='GET'>
            <select name='description'>
                <option value=''>Выберите категорию</option>
                <option value='Смартфоны'>Смартфоны</option>
                <option value='Ноутбуки'>Ноутбуки</option>
                <option value='Мышки'>Мышки</option>
                <option value='Планшеты'>Планшеты</option>
            </select>
            <input type='text' name='search' placeholder='Поиск по имени'>
            <input type='submit'class='button' value='Применить фильтр и поиск'>
            <a href='cart.php'>Корзина</a>
        </form>
    </div>
</div>

<div class='container'>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='product'>";
            echo "<div class='product-info'>";
            echo "<h2>" . $row["name"] . "</h2>";
            echo "<p>" . $row["description"] . "</p>";
            echo "<p class='price'>Цена: $" . $row["price"] . "</p>";
            echo "<button class='pink-button' onclick='addToCart(" . $row["id"] . ", \"" . $row["name"] . "\", " . $row["price"] . ")'>Купить</button>";            echo "</div>";
            echo "<div class='product-image'>";
            echo "<img src='images/" . $row["image_path"] . "' alt='" . $row["name"] . "'>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Нет доступных товаров";
    }
    ?>
</div>

<script>
function addToCart(productId, productName, productPrice) {
    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id: productId, name: productName, price: productPrice})
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    });
}
</script>

<?php
$body_content = ob_get_clean();
$footer_content = "© 2024 Интернет магазин электроники";
include 'base.html';

$conn->close();
?>