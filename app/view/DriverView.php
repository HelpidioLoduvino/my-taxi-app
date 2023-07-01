<?php
require_once '../controller/UserController.php';
require_once '../model/Pedido.php';
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
                        <a class="nav-link mr-2" data-target="#emAndamento">Em Andamaneto</a>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nome</th>
                                    <th>Origem</th>
                                    <th>Destino</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($userController->buscarPedidosProximos() as $pedido) {
                                    echo "<tr>";
                                    echo "<td>" . $pedido->getPedido_id() . "</td>";
                                    echo "<td>" . $pedido->getNome() . "</td>";
                                    echo "<td>" . $pedido->getOrigem() . "</td>";
                                    echo "<td>" . $pedido->getDestino() . "</td>";
                                    echo '<form method="POST">';
                                    echo '<input type="hidden" name="pedido_id" value="' . $pedido->getPedido_id() . '">';
                                    echo '<td><button class="btn btn-outline-warning" name="aceitar_pedido">Aceitar</button></td>';
                                    echo "</form>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        if (isset($_POST['aceitar_pedido'])) {
                            $pedido_id = $_POST['pedido_id'];
                            $userController->callAceitarPedido($pedido_id);
                            echo "<meta http-equiv=\"refresh\" content=\"0;\">";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal" id="emAndamento" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Em Andamento</h5>
                    </div>
                    <div class="modal-body">
                        <h5 class="">Em Andamento...</h5>
                        <form method="POST">
                            <button name="finalizar_corrida" class="btn btn-outline-dark">Finalizar Corrida</button>
                        </form>
                    </div>
                    <?php 
                    if(isset($_POST['finalizar_corrida'])){
                        
                    }
                    ?>
                </div>
            </div>
        </div>

        <script src="../content/bootstrap/script/bootstrap.min.js"></script>
        <script src="../content/scripts/mod.js"></script>
    </body>
</html>
