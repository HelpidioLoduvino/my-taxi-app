<?php
require_once '../controller/UserController.php';
require_once '../model/Viatura.php';
require_once '../model/CategoriaViatura.php';
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
            <a class="navbar-brand" href="#">Empresa de Taxi</a>
            <div class="">

                <ul class="navbar-nav ml-2 flex-row">

                    <li class="nav-item ">
                        <a class="nav-link mr-2" data-target="#inserirViatura">Inserir Viatura</a>
                    </li>

                    <li class="nav-item ">
                        <a class="nav-link mr-2" data-target="#inserirCategoria">Inserir Categoria da Viatura</a>
                    </li>

                </ul>
            </div>
        </nav>

        <div class="modal" id="inserirViatura" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Inserir Viatura</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="">
                                <label for="nome">id da Categoria:</label><br>
                                <input type="number" name="id_categoria" class="form-control" placeholder="id da Categoria"><br>
                            </div>

                            <div class="col">
                                <label for="email">id do Motorista:</label><br>
                                <input type="number" name="id_motorista" class="form-control" placeholder="id do Motorista"><br>
                            </div>
                            
                            <button type="submit" class="btn btn-outline-dark" name="inserir_viatura">Inserir Viatura</button>
                        </form>
                        <?php
                        if (isset($_POST['inserir_viatura'])) {
                            $viatura = new Viatura();
                            $id_categoria = filter_input(INPUT_POST, 'id_categoria');
                            $id_motorista = filter_input(INPUT_POST, 'id_motorista');
                            $viatura->setId_categoria($id_categoria);
                            $viatura->setId_motorista($id_motorista);
                            $userController->inserirAutomovel($viatura);
                            echo "<meta http-equiv=\"refresh\" content=\"0;\">";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="inserirCategoria" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5>Inserir Categoria</h5>
                    </div>
                    <div class="modal-body">
                        <form method="POST">
                            <div class="">
                                <label for="nome">Velocidade Media:</label><br>
                                <input type="number" name="velocidade_media" class="form-control" placeholder="Velocidade Media"><br>
                            </div>

                            <div class="col">
                                <label for="email">Fiabilidade:</label><br>
                                <input type="number" name="fiabilidade" class="form-control" placeholder="Fiabilidade"><br>
                            </div>

                            <div class="col">
                                <label for="data_nascimento">Descricao:</label><br>
                                <input type="text" name="descricao" class="form-control" placeholder="Descricao"><br>
                            </div>

                            <button type="submit" class="btn btn-outline-dark" name="inserir_categoria">Inserir Categoria</button>
                        </form>
                        <?php
                        if (isset($_POST['inserir_categoria'])) {
                            $$categoria_viatura = new CategoriaViatura();
                            $velocidade_media = filter_input(INPUT_POST, 'velocidade_media');
                            $fiabilidade = filter_input(INPUT_POST, 'fiabilidade');
                            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
                            $categoria_viatura->setVelocidade_media($velocidade_media);
                            $categoria_viatura->setFiabilidade($fiabilidade);
                            $categoria_viatura->setDescricao($descricao);
                            $userController->inserirCategoria($categoria_viatura);
                            echo "<meta http-equiv=\"refresh\" content=\"0;\">";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <script src="../content/bootstrap/script/bootstrap.min.js"></script>
        <script src="../content/scripts/empresa.js"></script>
    </body>
</html>
