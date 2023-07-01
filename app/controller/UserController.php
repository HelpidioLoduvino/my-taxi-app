<?php

require_once '../model/UserRepository.php';
include_once '../model/User.php';

class UserController {

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function home() {
        header('Location: ../view/ClientView.php');
    }

    public function criarUtilizador(User $user) {

        $this->userRepository->inserirUtilizador($user);
    }

    public function getTripClosedBy($id_cliente, $origem_x, $origem_y, $destino_x, $destino_y) {
        $this->userRepository->solicitarMaisProximo($id_cliente, $origem_x, $origem_y, $destino_x, $destino_y);
    }

    public function buscarPedidosProximos() {
        $this->userRepository->getPedidosProximos();
    }

    public function entrar($email, $password) {
        $user = $this->userRepository->login($email, $password);
        if ($user) {
            $tipo = $user->getTipo();
            echo $tipo;
            session_start();
            $_SESSION['tipo'] = $tipo;

            switch ($tipo) {
                case 'MOTORISTA':
                    header('Location: ../view/DriverView.php');
                    break;
                case 'CLIENTE':
                    header('Location: ../view/ClientView.php');
                    break;
            }
        } else {
            echo 'User nao encontrado';
        }
    }

}
