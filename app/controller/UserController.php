<?php

require_once '../model/UserRepository.php';
include_once '../model/User.php';
include_once '../model/BuscarCliente.php';
require_once '../model/Pedido.php';

class UserController {

    private $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository();
    }

    public function home() {
        header('Location: view/LoginView.php');
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
    
    public function callAceitarPedido($id_motorista,$id_pedido){
        $this->userRepository->aceitarPedido($id_motorista,$id_pedido);
    }
    
    public function catchClient(){
        return $this->userRepository->buscarClienteAceite();
    }
    
    public function iniciarViagem($id_motorista, $id_pedido){
        $this->userRepository->iniciarCorrida($id_motorista, $id_pedido);
    }

    public function entrar($email, $password) {
        $user = $this->userRepository->login($email, $password);
        if ($user) {
            $tipo = $user->getTipo();
            $id = $user->getId();
            session_start();
            $_SESSION['tipo'] = $tipo;
            
            switch ($tipo) {
                case 'MOTORISTA':
                    $_SESSION['id'] = $id;
                    header('Location: ../view/DriverView.php');
                    break;
                case 'CLIENTE':
                    $_SESSION['id'] = $id;
                    header('Location: ../view/ClientView.php');
                    break;
            }
        } else {
            echo 'User nao encontrado';
        }
    }

}
