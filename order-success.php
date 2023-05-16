<?php
session_start();

// Очистка информации о заказе
unset($_SESSION['cart']);

// Перенаправление на страницу успешного оформления заказа
header("Refresh: 1; URL=index.php");
$successMessage = "Заказ успешно оформлен";
?>
<div class="alert alert-success" role="alert">
    <?php echo $successMessage; ?>
</div>
<?php include 'index.php'; ?>