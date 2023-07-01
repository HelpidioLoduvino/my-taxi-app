<?php
require_once '../controller/UserController.php';
$userController = new UserController();
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
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Taxi</a>
            <div class="">

                <ul class="navbar-nav ml-2 flex-row">
                    <li class="nav-item ">
                        <a class="nav-link mr-2" data-target="#verPedido">Ver Pedidos</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link mr-2" href="LoginView.php">Login</a>
                    </li>
                    <li class="nav-item mr-2">
                        <a class="nav-link" data-target="#registerModal">Sign Up</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="modal" id="verPedido" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Ver Pedidos</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Origem</th>
                                        <th>Destino</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $userController->buscarPedidosProximos();
                                    ?>
                                </tbody>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script src="../content/bootstrap/script/bootstrap.min.js"></script>
        <script src="../content/scripts/modalDriver.js"></script>
    </body>
</html>
