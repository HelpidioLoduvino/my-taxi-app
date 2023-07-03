<?php

class BuscarCliente {
    private $pedido_id;
    private $nome;
    private $localizacao;

    public function getPedido_id() {
        return $this->pedido_id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function setPedido_id($pedido_id): void {
        $this->pedido_id = $pedido_id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setLocalizacao($localizacao): void {
        $this->localizacao = $localizacao;
    }



}
