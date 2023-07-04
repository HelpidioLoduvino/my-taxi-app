<?php

require_once 'DB.php';
include_once 'User.php';
include_once '../model/Viagem.php';
require_once '../model/Pedido.php';
require_once '../model/Viatura.php';
require_once '../model/CategoriaViatura.php';

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

    public function aceitarPedido($id_motorista, $id_pedido) {
        $query = 'call iniciar_viagem(' . $id_motorista . ',' . $id_pedido . ')';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function buscarClienteAceite() {
        $query = "SELECT u.nome, u.localizacao, p.id
          FROM pedido p
          INNER JOIN viagem v ON p.id = v.id_pedido
          INNER JOIN utilizador u ON u.id = p.id_cliente
          WHERE v.id_motorista = " . $_SESSION['id'] . " AND p.estado = 'ACEITE'
          ORDER BY v.data_inicio ASC
          LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $buscar_cliente = new Viagem();
            $buscar_cliente->setPedido_id($row['id']);
            $buscar_cliente->setNomeCliente($row['nome']);
            $buscar_cliente->setLocalizacao($row['localizacao']);
            return $buscar_cliente;
        }
    }

    public function iniciarCorrida($id_motorista, $id_pedido) {
        $query = 'call iniciar_viagem(' . $id_motorista . ', ' . $id_pedido . ')';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function verPedido() {
        $query = 'select u.nome, v.* from viagem v inner join pedido p on v.id_pedido = p.id
            inner join utilizador u on u.id = v.id_motorista limit 1';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $query2 = 'select (st_distance(p.destino ::geography, p.origem::geography) / 1000) * (st_distance(p.destino ::geography, p.origem::geography) / 1000) /cv.velocidade_media as preco,

                (st_distance(p.destino ::geography, p.origem::geography) / 1000) /cv.velocidade_media as tempo_estimando
                     from viagem v
                              inner join pedido p on v.id_pedido = p.id  
                              inner join utilizador u on u.id = v.id_motorista
                              inner join viatura v2 on v.id_motorista = v2.id_motorista
                              inner join categoria_viatura cv on cv.id = v2.id_categoria
                     where v.id_pedido = 7';

        $stmt2 = $this->db->prepare($query2);
        $stmt2->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

        if ($row || $row2) {
            $ver_pedido = new Viagem();
            $ver_pedido->setPedido_id($row['id_pedido']);
            $ver_pedido->setNomeMotorista($row['nome']);
            $ver_pedido->setPreco($row2['preco']);
            $ver_pedido->setTempo_estimado($row2['tempo_estimando']);
            return $ver_pedido;
        }
    }

    public function finalizarViagem($pedido_id) {

        $query = 'select * from finalizar_viagem(7)';
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $finalizar_viagem = new Viagem();
            $finalizar_viagem->setPreco($row['preco']);
            $finalizar_viagem->setTempo_real($row['tempo']);
            return $finalizar_viagem;
        }
    }

    public function inserirViatura(Viatura $viatura) {
        $query = 'insert into viatura(id_categoria, id_motorista)VALUES (:id_categoria, :id_motorista)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_categoria', $viatura->getId_categoria());
        $stmt->bindParam(':id_motorista', $viatura->getId_motorista());
        $stmt->execute();
    }
    
    public function inserirCategoriaViatura(CategoriaViatura $categoria_viatura){
        $query = 'insert into categoria_viatura(velocidade_media, fiabilidade, descricao) values(:velocidade_media, :fiabilidade, :descricao)';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':velocidade_media', $categoria_viatura->getVelocidade_media());
        $stmt->bindParam(':fiabilidade', $categoria_viatura->getFiabilidade());
        $stmt->bindParam(':descricao', $categoria_viatura->getDescricao());
        $stmt->execute();
    }

}
