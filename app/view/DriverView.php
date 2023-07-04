<?php
require_once '../controller/UserController.php';
require_once '../model/Pedido.php';
include_once '../model/User.php';
include_once '../model/Viagem.php';
$userController = new UserController();
session_start();
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
        <?php
        $isLoggedIn = isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'MOTORISTA';
        ?>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Taxi</a>
            <div class="">

                <ul class="navbar-nav ml-2 flex-row">
                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item ">
                            <a class="nav-link mr-2" data-target="#verPedido">Ver Pedidos</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item ">
                            <a class="nav-link mr-2" data-target="#buscarCliente">Buscar Cliente</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item ">
                            <a class="nav-link mr-2" data-target="#emAndamento">Em Andamaneto</a>
                        </li>
                    <?php endif; ?>

                    <?php if (!$isLoggedIn): ?>
                        <li class="nav-item ">
                            <a class="nav-link mr-2" href="LoginView.php">Login</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item mr-2">
                        <a class="nav-link" data-target="#registerModal">Inserir Motorista</a>
                    </li>

                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item ml-auto">
                            <a class="nav-link" href="../action/logout.php">Logout</a>
                        </li>
                    <?php endif; ?>

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
                                    echo '<input type="hidden" name="id_pedido" value="' . $pedido->getPedido_id() . '">';
                                    echo '<td> <input type="hidden" name="id_motorista" value=' . $_SESSION['id'] . '> </td>';
                                    echo '<td><button class="btn btn-outline-warning" name="aceitar_pedido">Aceitar</button></td>';
                                    echo "</form>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <?php
                        if (isset($_POST['aceitar_pedido'])) {
                            $id_pedido = filter_input(INPUT_POST, 'id_pedido');
                            $id_motorista = filter_input(INPUT_POST, 'id_motorista');
                            $userController->callAceitarPedido($id_motorista, $id_pedido);
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
                        <h5>Em Andamento...</h5>
                        <?php 
                        $pedido_id = $userController->verPedidoAceite();
                       
                            echo '<form method="POST">';
                            echo '<input type="hidden" name="id_pedido" value="'.$pedido_id->getPedido_id().'">';
                            echo '<button class="btn btn-outline-dark" name="finalizar_corrida">Finalizar Corriga</button>';
                            echo '</form>';
                     
                        ?>     
                    </div>
                    <?php
                    $finalizado = false;
                    if (isset($_POST['finalizar_corrida'])) {
                        $finalizado = true;
                        $id_pedido = filter_input(INPUT_POST, 'id_pedido');
                        $userController->verFinalizado($id_pedido);
                    
                    }
                    ?>

                    <?php
                    if ($finalizado) {
                        $pedido_finalizado = $userController->verFinalizado($pedido_id);
                        echo '
                                <table class="table">
                                <thead>
                                <tr>
                                <td>Preco</td>
                                <td>Tempo Real</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td>"'.$pedido_finalizado->getPreco().'"</td>
                                <td>"'.$pedido_finalizado->getTempo_real().'"</td>
                                </tr>
                                </tbody>
                                </table>
                            ';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="modal" id="buscarCliente" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>A Busca do Cliente</h5>
                    </div>
                    <div class="modal-body">

                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Nome</th>
                                    <th>Localizacao</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $buscar_cliente = $userController->catchClient();
                                if ($buscar_cliente) {
                                    echo "<tr>";
                                    echo "<td>" . $buscar_cliente->getPedido_id() . "</td>";
                                    echo "<td>" . $buscar_cliente->getNomeCliente() . "</td>";
                                    echo "<td>" . $buscar_cliente->getLocalizacao() . "</td>";
                                    echo '<form method="POST">';
                                    echo '<input type="hidden" name="id_pedido" value="' . $buscar_cliente->getPedido_id() . '">';
                                    echo '<td> <input type="hidden" name="id_motorista" value=' . $_SESSION['id'] . '> </td>';
                                    echo '<td><button class="btn btn-outline-warning" name="iniciar_viagem">Iniciar Viagem</button></td>';
                                    echo "</form>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <?php
                    if (isset($_POST['iniciar_viagem'])) {
                        $id_pedido = filter_input(INPUT_POST, 'id_pedido');
                        $id_motorista = filter_input(INPUT_POST, 'id_motorista');
                        $userController->iniciarViagem($id_motorista, $id_pedido);
                        echo "<meta http-equiv=\"refresh\" content=\"0;\">";
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
        <script src="../content/scripts/driver.js"></script>
        <script src="../content/scripts/driverModal.js"></script>
    </body>
</html>
