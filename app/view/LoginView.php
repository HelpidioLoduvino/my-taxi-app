<?php
require_once '../controller/UserController.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Taxi App</title>
        <link rel="stylesheet" href="../content/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../content/css/style.css"/>
    </head>
    <body>
        <div class="container justify-content-center">
            <form method="POST">

                <div class="col">
                    <label for="email">Email:</label><br>
                    <input type="text" name="email" class="form-control" placeholder="Email"><br>
                </div>

                <div class="col">
                    <label for="password">Password:</label><br>
                    <input type="password" name="password" class="form-control" placeholder="Password"><br>
                </div>

                <button type="submit" class="btn btn-outline-warning" name="login">Entrar</button>
                <a class="btn btn-outline-light" href="../view/ClientView.php">GUEST</a>

            </form>
        </div>
        <?php
        if (isset($_POST['login'])) {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $userController = new UserController();
            $userController->entrar($email, $password);
        }
        ?>

        <script src="../content/bootstrap/script/bootstrap.min.js"></script>
    </body>
</html>
