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

    public function criarUtilizador(User $user, $localizacao_x, $localizacao_y) {

        $this->userRepository->inserirUtilizador($user, $localizacao_x, $localizacao_y );
    }

    public function getTripClosedBy($id_cliente, $origem_x, $origem_y, $destino_x, $destino_y) {
        $this->userRepository->solicitarMaisProximo($id_cliente, $origem_x, $origem_y, $destino_x, $destino_y);
    }

    public function buscarPedidosProximos() {
        return $this->userRepository->getPedidosProximos();
    }
    
    public function callAceitarPedido($pedido_id){
        $this->userRepository->aceitarPedido($pedido_id);
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
