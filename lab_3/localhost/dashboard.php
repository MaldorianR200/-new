
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Info Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.scss">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Name :- <?php echo $_SESSION['name'] ?></h5>
                        <p class="card-text">Email :- <?php echo $_SESSION['email'] ?></p>
                        <a href="logout.php" class="btn btn-primary">Выход из системы</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>