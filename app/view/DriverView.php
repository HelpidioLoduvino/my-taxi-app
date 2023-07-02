<?php
require_once '../controller/UserController.php';
require_once '../model/Pedido.php';
include_once '../model/User.php';
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
                    if (isset($_POST['finalizar_corrida'])) {
                        
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="modal" id="registerModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Register</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="tipo" value="MOTORISTA">

                            <div class="">
                                <label for="nome">Nome:</label><br>
                                <input type="text" name="nome" class="form-control" placeholder="Nome"><br>
                            </div>

                            <div class="col">
                                <label for="email">Email:</label><br>
                                <input type="text" name="email" class="form-control" placeholder="Email"><br>
                            </div>

                            <div class="col">
                                <label for="data_nascimento">Data de Nascimento:</label><br>
                                <input type="date" name="data_nascimento" class="form-control" placeholder="Data de Nascimento"><br>
                            </div>

                            <div class="col">
                                <label for="morada">Morada:</label><br>
                                <input type="text" name="morada" class="form-control" placeholder="Morada"><br>
                            </div>

                            <label>Localizacao:</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="localizacao_x" class="form-control" placeholder="Coordenada x">
                                </div>
                                <div class="col">
                                    <input type="text" name="localizacao_y" class="form-control" placeholder="Coordenada y">
                                </div>
                            </div><br>

                            <div class="col">
                                <label for="password">Password:</label><br>
                                <input type="password" name="password" class="form-control" placeholder="Password"><br>
                            </div>
                            <button type="submit" class="btn btn-outline-dark" name="inserir_motorista">Registrar</button>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['inserir_motorista'])) {
                        $user = new User();
                        $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);
                        $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
                        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
                        $data_nascimento = filter_input(INPUT_POST, 'data_nascimento', FILTER_SANITIZE_SPECIAL_CHARS);
                        $morada = filter_input(INPUT_POST, 'morada', FILTER_SANITIZE_STRING);
                        $localizacao_x = filter_input(INPUT_POST, 'localizacao_x');
                        $localizacao_y = filter_input(INPUT_POST, 'localizacao_y');
                        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

                        $user->setTipo($tipo);
                        $user->setNome($nome);
                        $user->setEmail($email);
                        $user->setData_nascimento($data_nascimento);
                        $user->setMorada($morada);
                        $user->setPassword($password);
                        $userController = new UserController();
                        $userController->criarUtilizador($user, $localizacao_x, $localizacao_y);
                        echo "<meta http-equiv=\"refresh\" content=\"0;\">";
                    }
                    ?>
                </div>
            </div>
        </div>

        <script src="../content/bootstrap/script/bootstrap.min.js"></script>
        <script src="../content/scripts/driverModal.js"></script>
    </body>
</html>
