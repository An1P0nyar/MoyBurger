<?php
session_start();

// Проверка, авторизован ли пользователь
if (isset($_SESSION['username'])) {
    header("Location: account.php");
    exit();
}

// Подключение к базе данных
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "fastfood";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка отправки формы
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка имени пользователя и пароля в базе данных
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Авторизация успешна
        $_SESSION['username'] = $username;
        header("Location: account.php");
        exit();
    } else {
        // Ошибка авторизации
        $error = "Неверное имя пользователя или пароль";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>🍔Мой Бургер - Вход</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-4">
    <div class="login-container">
        <h2>Вход</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary" name="login">Войти</button>
        </form>
        <p class="mt-3">Еще нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
    </div>
</section>
<footer class="container mt-4">
    <p>&copy; 2023 🍔Мой Бургер</p>
</footer>
</body>
</html>