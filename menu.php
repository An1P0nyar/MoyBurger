<?php
// Подключение файла с данными о меню
include 'menu-data.php';

// Инициализация сессии для хранения выбранных продуктов
session_start();

// Проверка, была ли отправлена форма добавления продукта в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];

        // Добавление продукта и его количества в сессию
        $_SESSION['cart'][$productId] = $quantity;

        // Установка флага для отображения уведомления
        $_SESSION['show_notification'] = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Меню - 🍔Мой Бургер</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-4">
    <h2>Меню</h2>
    <div class="row">
        <?php foreach($products as $product): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                        <p class="card-text"><?php echo $product['description']; ?></p>
                        <div class="mt-auto">
                            <p class="card-price">Цена: <?php echo $product['price']; ?> руб.</p>
                            <form method="POST" action="menu.php">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <div class="form-group">
                                    <label for="quantity">Количество:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить в корзину</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<!-- Уведомление о добавлении в корзину -->
<div class="notification">
    <p>Товар успешно добавлен в корзину</p>
</div>
<footer class="container mt-4">
    <p>&copy; 2023 🍔Мой Бургер</p>
</footer>
</body>
</html>