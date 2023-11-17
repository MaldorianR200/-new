<?php include("db.php")?>

<!-- Переменные для хранения ошибок -->
<?php
    $username_error = $email_error = $password_error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
    }

    if(empty($username)) {
        $username_error = "Требуется имя пользователя!";
    }
    if(empty($email)) {
        $email_error = "Требуется email!";
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Неверный формат email!";
    }

    if(empty($password)) {
        $password_error = "Требуется пароль";
    }

    // Если нет ошибок, продолжаем с вставкой данных в базу данных
    if (empty($email_error) && empty($password_error) && empty($username_error)) {
        // Хеширование пароля (рекомендуется использовать более безопасные методы)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Вставка данных в базу данных
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
        
        <style meadia="screen">
            
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
                height: 620px;
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

    <form method="post" action="" name="signin-form" action="<?php 
    echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <h3>Регистрация</h3>
  <div class="form-element">
    <label>Имя</label>
    <input type="text" name="username" class="form-control" value="" maxlength="50" required="">
    <span class="text-danger"> <?php echo $username_error; ?></span><br>
  </div>
  <div class="form-element">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
    <span class="text-danger"> <?php echo $email_error; ?></span><br>
  </div>

  <div class="form-element">
    <label>Пароль</label>
    <input type="password" name="password" class="form-control" value="" maxlength="8" required="">
    <span class="text-danger"> <?php echo $password_error; ?></span><br>
  </div>
 
  <button type="submit" class="btn btn-primary" name="register" >Зарегистрироваться</button>

  <div class="reg">
    <div class="go">
        <a href="login.php">Уже есть аккаунт?</a>
    </div>
  </div>
</form>
    </body>
</html>

