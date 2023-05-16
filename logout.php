<?php
// Очистка сессии и перенаправление на страницу входа
session_start();
session_destroy();
header("Location: login.php");
exit;