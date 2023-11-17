<?php
    session_start();

    $servername='localhost';
    $usernameBD='root';
    $passworD='';
    $dbname = "php_ZELENKOV";
    $conn=mysqli_connect($servername,$usernameBD,$passworD,"$dbname");
    
    // Проверка подключения
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
?>

