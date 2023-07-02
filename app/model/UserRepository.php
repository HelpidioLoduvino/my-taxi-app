<?php

require_once 'DB.php';
include_once 'User.php';
include_once '../model/BuscarCliente.php';
require_once '../model/Pedido.php';
class UserRepository {

    private $db;

    public function __construct() {
        $this->db = DB::getConnection();
    }

    public function inserirUtilizador(User $user, $localizacao_x, $localizacao_y) {
        try {
            $query = 'INSERT INTO utilizador(nome, email, password, data_nascimento, tipo, morada, localizacao) VALUES (:nome, :email, :password, :data_nascimento, :tipo, :morada, st_setsrid(st_makepoint(:localizacao_x, :localizacao_y), 4326))';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nome', $user->getNome());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':password', $user->getPassword());
            $stmt->bindParam(':data_nascimento', $user->getData_nascimento());
            $stmt->bindParam(':tipo', $user->getTipo());
            $stmt->bindParam(':morada', $user->getMorada());
            $stmt->bindParam(':localizacao_x', $localizacao_x);
            $stmt->bindParam(':localizacao_y', $localizacao_y);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $query = 'SELECT * FROM utilizador WHERE email = :email and password = :password';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $obj = new User();
                $obj->setId($user['id']);
                $obj->setNome($user['nome']);
                $obj->setEmail($user['email']);
                $obj->setTipo($user['tipo']);
                $obj->setData_nascimento($user['data_nascimento']);
                $obj->setMorada($user['morada']);
                $obj->setPassword($user['password']);
                return $obj;
            }
            return null;
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function solicitarMaisProximo($id_cliente, $origem_x, $origem_y, $destino_x, $destino_y) {

        $query = 'INSERT INTO pedido (origem, destino, id_cliente) VALUES (st_setsrid(st_makepoint(' .
                $origem_x . ',' . $origem_y . '), 4326), st_setsrid(st_makepoint(' .
                $destino_x . ',' . $destino_y . '), 4326), ' . $id_cliente . ');';

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function getPedidosProximos() {
        $query = 'select * from get_pedidos_proximos(' . $_SESSION['id'] . ')';
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $todosPedidos = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pedido = new Pedido();
            $pedido->setPedido_id($row["pedido_id"]);
            $pedido->setNome($row["nome"]);
            $pedido->setOrigem($row["origem"]);
            $pedido->setDestino($row["destino"]);
            $todosPedidos[] = $pedido;
        }

        return $todosPedidos;
    }

    public function aceitarPedido($pedido_id) {
        $query = 'call iniciar_viagem(2,' . $pedido_id . ')';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function buscarClienteAceite() {
        $query = 'select u.nome ,u.localizacao  from pedido p inner join viagem v on p.id = v.id_pedido
           inner join utilizador u on  u.id =p.id_cliente where v.id_motorista=2 order by v.data_inicio asc limit 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row){
            $buscar_cliente = new BuscarCliente();
            $buscar_cliente->setNome($row['nome']);
            $buscar_cliente->setLocalizacao($row['localizacao']);
            return $buscar_cliente;
        }
    }

}
