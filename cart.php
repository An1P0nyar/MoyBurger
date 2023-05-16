<?php
// Подключение файла с данными о меню
include 'menu-data.php';
// Инициализация сессии для доступа к выбранным продуктам в корзине
session_start();

// Проверка, существует ли информация о выбранных продуктах в корзине
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Получение выбранных продуктов из сессии
    $cartItems = $_SESSION['cart'];
} else {
    // Если корзина пуста, устанавливаем пустой массив для выбранных продуктов
    $cartItems = array();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Корзина - 🍔Мой Бургер</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="container mt-4">
    <div class="cart-container">
        <h2>Корзина</h2>
        <?php if (!empty($cartItems)): ?>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Сумма</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $totalAmount = 0;
                foreach ($cartItems as $productId => $quantity):
                    // Получение информации о продукте из файла с данными о меню
                    $product = $products[$productId];
                    $subtotal = $product['price'] * $quantity;
                    $totalAmount += $subtotal;
                    ?>
                    <tr>
                        <th scope="row"><?php echo $product['id']; ?></th>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?> руб.</td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $subtotal; ?> руб.</td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-right"><strong>Общая сумма:</strong></td>
                    <td><?php echo $totalAmount; ?> руб.</td>
                </tr>
                </tbody>
            </table>
            <a href="menu.php" class="btn btn-primary">Продолжить покупки</a>
            <a href="checkout.php" class="btn btn-success">Оформить заказ</a>
        <?php else: ?>
        <p>Ваша корзина пуста.</p>
        <a href="menu.php" class="btn btn-primary">Перейти к меню</a>
        <?php endif; ?>
    </div>
</section>
<footer class="container mt-4">
    <p>&copy; 2023 🍔Мой Бургер</p>
</footer>
</body>
</html>