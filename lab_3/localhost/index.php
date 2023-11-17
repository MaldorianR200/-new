<?php
session_start();

// Проверка сессии и токена "Запомнить меня"
if (!isset($_SESSION['id']) && isset($_COOKIE['remember_token'])) {
    $remember_token = $_COOKIE['remember_token'];

    // Проверка токена в базе данных
    $sql = "SELECT id FROM users WHERE remember_token = '$remember_token'";
    // Выполнение SQL-запроса, используя ваш метод работы с базой данных
    $result = $conn->query($sql);
    
    if ($result) {
        $row = $result->fetch_assoc();
        $user_id = $row['id'];

         // Установка сессии
        $_SESSION['id'] = $user_id;
    }
}

// Если сессии нет, перенаправление на страницу входа
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Далее ваш код страницы приветствия
?>


<?php include("logout.php")?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Заголовок -->
    <title>Программирование на PHP с нуля</title>
    <!-- Кодировка и тип страницы -->
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <meta name="description" content="Изучаем PHP">
    <!-- Ключевые слова, запросы, которые вводит пользователь -->
    <meta name="keywords" content="PHP, изучаем PHP,  язык программирвания - PHP">
    <!-- favicon -->
    <link rel="shortcut icon" href="/icons8-favicon-96.png" type="image/x-icon">
    <!-- Подключение таблицы стилей CSS -->
    <link type="text/css" rel="stylesheet" href="index.css">
    <!-- Подключение внешего php файла -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.scss">
    
</head>
<body>
  
  <header>
    <h1>Пользователь в системе</h1>
    <h3>Добро пожаловать <?php echo $_COOKIE['name']?> !</h3>
  </header>
   
    <div class="logout-container">
    <label for="logout">Выход из системы</label>
        <form action="index.php" method="get">
            <button class="logout-button" type="submit" name="logout" value="Logout">Выход</button>
        </form>  
    </div>

   
    <footer>
        <p>Автор: MaldorianR200</p>
        <small>&copy; 2023 Мой сайт. Все права защищены.</small>
    </footer>
    </body>
</html>





