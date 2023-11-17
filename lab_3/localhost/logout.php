<?php
session_start();


// Обработка выхода
if (isset($_GET['logout'])) {
    setcookie("remember_token", "", time() - 3600, "/");
    session_destroy(); // Уничтожение сессии
    header("Location: login.php"); // Перенаправление на страницу входа после выхода
    exit();
}
?>