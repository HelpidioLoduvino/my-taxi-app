<?php

class Pedido {
    private $pedido_id;
    private $nome;
    private $origem;
    private $destino;
    
    public function getPedido_id() {
        return $this->pedido_id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getOrigem() {
        return $this->origem;
    }

    public function getDestino() {
        return $this->destino;
    }

    public function setPedido_id($pedido_id): void {
        $this->pedido_id = $pedido_id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setOrigem($origem): void {
        $this->origem = $origem;
    }

    public function setDestino($destino): void {
        $this->destino = $destino;
    }
}
