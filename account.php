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
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Получение информации о пользователе из базы данных
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $address = $row['address'];
    $phone = $row['phone']; // Добавлено поле для номера телефона
} else {
    // Если информация не найдена, установите значения по умолчанию
    $name = '';
    $email = '';
    $address = '';
    $phone = '';
}

// Проверка, была ли отправлена форма
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone']; // Добавлено поле для номера телефона

    // Обновление информации в базе данных
    $updateSql = "UPDATE users SET name = '$name', email = '$email', address = '$address', phone = '$phone' WHERE username = '$username'";
    if ($conn->query($updateSql) === TRUE) {
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['address'] = $address;
        $_SESSION['phone'] = $phone; // Добавлено поле для номера телефона
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>🍔Мой Бургер</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-4">
    <div class="form-container">
        <h2>Личный кабинет</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="name">Имя:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Адрес:</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона:</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Обновить</button>
            <a href="logout.php" class="btn btn-danger">Выход</a>
        </form>
    </div>
</section>
<footer class="container mt-4">
    <p>&copy; 2023 🍔Мой Бургер</p>
</footer>
</body>
</html>
<?php
// Закрытие соединения с базой данных
$conn->close();
?>