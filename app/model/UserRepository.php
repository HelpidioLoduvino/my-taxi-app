<?php

require_once 'DB.php';
include_once 'User.php';

class UserRepository {

    private $db;

    public function __construct() {
        $this->db = DB::getConnection();
    }

    public function inserirUtilizador(User $user) {
        try {
            $query = 'INSERT INTO utilizador(nome, email, tipo, data_nascimento, morada, password) VALUES (:nome, :email, :tipo, :data_nascimento, :morada, :password)';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nome', $user->getNome());
            $stmt->bindParam(':email', $user->getEmail());
            $stmt->bindParam(':tipo', $user->getTipo());
            $stmt->bindParam(':data_nascimento', $user->getData_nascimento());
            $stmt->bindParam(':morada', $user->getMorada());
            $stmt->bindParam(':password', $user->getPassword());
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
                $destino_x . ',' . $destino_y . '), 4326), 1);';

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    }

    public function getPedidosProximos() {
        $query = 'select * from get_pedidos_proximos(2)';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<tr>';
            echo "<td>" . $row["nome"] . "</td>";
            echo "<td>" . $row["origem"] . "</td>";
            echo "<td>" . $row["destino"] . "</td>";
            echo '<td><button class="btn btn-warning" onclick="aceitarPedido(' . $row["pedido_id"] . ')">Aceitar</button></td>';
     
            echo '</tr>';
        }
    }

}
