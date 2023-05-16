<?php
session_start();

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
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($password !== $confirmPassword) {
        $error = "Пароль и подтверждение пароля не совпадают";
    } else {
        // Проверка существования пользователя с таким же именем
        $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
        $checkUserResult = $conn->query($checkUserQuery);

        if ($checkUserResult->num_rows > 0) {
            // Пользователь с таким именем уже существует
            $error = "Пользователь с таким именем уже зарегистрирован";
        } else {
            // Добавление нового пользователя в базу данных
            $insertUserQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            $insertUserResult = $conn->query($insertUserQuery);

            if ($insertUserResult) {
                // Регистрация успешна
                $_SESSION['username'] = $username;
                header("Location: account.php");
                exit();
            } else {
                // Ошибка регистрации
                $error = "Ошибка при регистрации пользователя";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>🍔Мой Бургер - Регистрация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-4">
    <div class="register-container">
        <h2>Регистрация</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Подтвердите пароль:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary" name="register">Зарегистрироваться</button>
        </form>
        <p class="mt-3">Уже есть аккаунт? <a href="login.php">Войдите</a></p>
    </div>
</section>
<footer class="container mt-4">
    <p>&copy; 2023 🍔Мой Бургер</p>
</footer>
</body>
</html>
