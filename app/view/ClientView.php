<?php
require_once '../controller/UserController.php';
include_once '../model/User.php';
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Taxi App</title>
        <link rel="stylesheet" href="../content/css/style.css"/>
        <link rel="stylesheet" href="../content/bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
       
    </head>
    <body>
        <?php
        $isLoggedIn = isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'CLIENTE';
        ?>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">Taxi</a>
            <div class="">
                <ul class="navbar-nav ml-2 flex-row">
                    <li class="nav-item ">
                        <?php if (!$isLoggedIn): ?>
                            <a class="nav-link mr-2" href="LoginView.php">Login</a>
                        <?php endif; ?>
                    </li>
                    <li class="nav-item mr-2">
                        <?php if (!$isLoggedIn): ?>
                            <a class="nav-link" data-target="#registerModal">Sign Up</a>
                        <?php endif; ?>
                    </li>

                    <?php if ($isLoggedIn): ?>
                        <li class="nav-item ml-auto">
                            <a class="nav-link" href="../action/logout.php">Logout</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </nav>

        <div class="body-content">
            <ul class="body-items">
                <li>
                    <?php
                    if ($isLoggedIn) {
                        echo '
                            <a class="nav-link" href="#"> <i class="fas fa-taxi navbar-toggler" id="taxi-icon"></i> </a>
                            <button type="button" class="btn btn-success" data-target="#getTripModal">Solicitar</button> 
                         ';
                    } else {
                        echo '
                            <a class="nav-link" href="#"> <i class="fas fa-taxi navbar-toggler" id="taxi-icon"></i> </a>
                            <a type="button" class="btn btn-success" href="../view/LoginView.php">Solicitar</a> 
                         ';
                    }
                    ?>


                </li>
            </ul>
            <hr class="bordas-dashed"/>
            <hr class="bordas-solid"/>
            <hr class="bordas-dashed"/>

            <div class="footer">
                <p>© 2023 PSG. All rights reserved.</p>
            </div>

        </div>

        <!-- Modal to ask for a trip -->
        <div class="modal" id="getTripModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Solicitar Uma Viagem</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <?php 
                            echo '
                               <input type="hidden" name="id" value="'.$_SESSION['id'].'">
                            ';
                            ?>
                            <label>Origem:</label>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="origem_x" class="form-control" placeholder="Coordenada x">
                                </div>
                                <div class="col">
                                    <input type="text" name="origem_y" class="form-control" placeholder="Coordenada y">
                                </div>
                            </div>
                            <br>
                            <label>Destino:</label>
                            <div class="row">
                                <div class="col">
                                    <input type="text" name="destino_x" class="form-control" placeholder="Coordenada x">
                                </div>
                                <div class="col">
                                    <input type="text" name="destino_y" class="form-control" placeholder="Coordenada y">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-warning" name="specific_taxi">Taxi Especifico</button>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-success" name="close_by_taxi">Mais Proximo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['close_by_taxi'])) {
                        $id_cliente = filter_input(INPUT_POST, 'id');
                        $origem_x = filter_input(INPUT_POST, 'origem_x');
                        $origem_y = filter_input(INPUT_POST, 'origem_y');
                        $destino_x = filter_input(INPUT_POST, 'destino_x');
                        $destino_y = filter_input(INPUT_POST, 'destino_y');
                        $userController = new UserController();
                        $userController->getTripClosedBy($id_cliente, $origem_x, $origem_y, $destino_x, $destino_y);
                        echo "<meta http-equiv=\"refresh\" content=\"0;\">";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Modal to register a client -->
        <div class="modal" id="registerModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Register</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <input type="hidden" name="tipo" value="CLIENTE">

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
                            <button type="submit" class="btn btn-outline-dark" name="inserir_cliente">Registrar</button>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['inserir_cliente'])) {

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
        <script src="../content/scripts/modal.js"></script>
    </body>
</html>
