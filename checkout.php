<?php
session_start();

// Подключение к базе данных MySQL
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "fastfood";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверка, авторизован ли пользователь
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Получение информации о пользователе из базы данных
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone'];
    } else {
        // Если информация не найдена, установите значения по умолчанию
        $name = '';
        $email = '';
        $address = '';
        $phone = '';
    }
} else {
    // Если пользователь не авторизован, установите значения по умолчанию
    $name = '';
    $email = '';
    $address = '';
    $phone = '';
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение данных из формы
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    // Сохранение информации о пользователе в сессии
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['address'] = $address;

    // Обновление информации в базе данных
    $updateSql = "UPDATE users SET name = '$name', email = '$email', address = '$address', phone = '$phone' WHERE username = '$username'";
    if ($conn->query($updateSql) === FALSE) {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Оформление заказа - 🍔Мой Бургер</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-4">
    <h2>Оформление заказа</h2>
    <form class="checkout-form" method="POST" action="order-success.php">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" required>
        </div>
        <div class="form-group">
            <label for="address">Адрес доставки:</label>
            <input type="address" id="address" name="address" value="<?php echo $address; ?>" required>
        </div>
        <div class="form-group">
            <label for="payment-method">Способ оплаты:</label>
            <select id="payment-method" name="payment_method" required>
                <option value="cash">Наличными при получении</option>
                <option value="card">Оплата картой курьеру</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Оформить заказ</button>
    </form>
</section>
<footer class="container mt-4">
    <p>&copy; 2023 🍔Мой Бургер</p>
</footer>
</body>
</html>