<?php

class PedidoReserva {
    private $id;
    private $id_pedido;
    private $id_motorista;
    
    public function getId() {
        return $this->id;
    }

    public function getId_pedido() {
        return $this->id_pedido;
    }

    public function getId_motorista() {
        return $this->id_motorista;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setId_pedido($id_pedido): void {
        $this->id_pedido = $id_pedido;
    }

    public function setId_motorista($id_motorista): void {
        $this->id_motorista = $id_motorista;
    }


    
}
