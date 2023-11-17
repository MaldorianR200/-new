<?php
    // Подключение к базе данных
    include("db.php");
    // Переменная для хранения ошибок
    $login_error = "";
    // Обработка формы входа
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
        $login_email = $_POST["email"];
        $login_password = $_POST["password"];
        // Валидация данных (пример)
        if (empty($login_email)) {
            $login_error = "Требуется email! ";
        }
        if (empty($login_password)) {
            $login_error = "Требуется пароль";
        }
        // Если нет ошибок, проверяем в базе данных
        if (empty($login_error)) {
            // Проверка в базе данных
            $sql = "SELECT id, email, password FROM users WHERE email = '$login_email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($login_password, $row["password"])) {
                    // Успешный вход, устанавливаем сессию и перенаправляем на защищенную страницу
                    $_SESSION['id'] = $row["id"];
                    $_SESSION['email'] = $row["email"];

                    if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                        // Генерация случайного токена для cookie
                        $token = bin2hex(random_bytes(32));
                        $sql = "UPDATE users SET remember_token = '$token' WHERE username = '$login_username'";
                        // Выполнение SQL-запроса, используя ваш метод работы с базой данных
                        // Установка cookie с токеном
                        setcookie("remember_token", $token, time() + (86400 * 30), "/");
                        // Сохранение токена в сессии для последующей проверки
                        $_SESSION['remember_token'] = $token;
                    }

                    // переход на новую страницу(в случае успешной auth)
                    header("Location: index.php");
                    exit();
                } else {
                    $login_error = "Неверный пароль";
                }
            } 
        }
        else {
            $login_error = "Введённый email не найден";
        }
    }

    // Закрытие соединения с базой данных
    $conn->close();
?>




<!DOCTYPE html>
    <html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/lab_3/localhost/includes/login.scss">

    <style media="screen">
        
*,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #080710;
}
.background{
    width: 430px;
    height: 520px;
    position: absolute;
    transform: translate(-50%,-50%);
    left: 50%;
    top: 50%;
}
.background .shape{
    height: 200px;
    width: 200px;
    position: absolute;
    border-radius: 50%;
}
.shape:first-child{
    background: linear-gradient(
        #1845ad,
        #23a2f6
    );
    left: -80px;
    top: -80px;
}
.shape:last-child{
    background: linear-gradient(
        to right,
        #ff512f,
        #f09819
    );
    right: -30px;
    bottom: -80px;
}
form{
    height: 450px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 20px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 30px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 30px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 20px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.reg{
  margin-top: 10px;
  display: flex;
}
a {
   
    text-decoration: none;
}
.reg .go{
  background: red;
  width: 840px;
  border-radius: 3px;
  padding: 5px 10px 10px 5px;
  background-color: rgba(255,255,255,0.27);
  color: #eaf0fb;
  text-align: center;
  color: blue;
  text-decoration: none;
  transition: color 0.3s ease;
  
}
.reg div:hover{
  background-color: rgba(255,255,255,0.47);
  
}
.reg .fb{
  margin-left: 25px;
}
.reg i{
  margin-right: 4px;
}

    </style>
</head>

    <body>
    <div class="background">
                <div class="shape"></div>
                <div class="shape"></div>
            </div>
        <form method="post" name="signin-form" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h3>Вход в систему</h3>
        <div class="form-element">
            <label>Логин</label>
            <input type="email" id="username" name="email" value="" maxlength="30" required="" />
        </div>
        <div class="form-element">
            <label>Пароль</label>
            <input type="password" id="password" name="password" value="" maxlength="8" required="" />
        </div>
        <div class="form-element">
            <span class="text-danger"><?php echo $login_error; ?></span>
        </div>
        

        <button type="submit" name="login" value="">Войти</button>

        <div class="reg">
            <div class="go">
                <a href="reg.php">Ещё не зарегистрированы?</a>
            </div>
        </div>
        </form>
    </body>

</html>