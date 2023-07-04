<?php

class Viagem {
    private $pedido_id;
    private $preco;
    private $nomeCliente;
    private $nomeMotorista;
    private $localizacao;
    private $tempo_estimado;
    private $tempo_real;
    
    public function getPedido_id() {
        return $this->pedido_id;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getNomeCliente() {
        return $this->nomeCliente;
    }

    public function getNomeMotorista() {
        return $this->nomeMotorista;
    }

    public function getLocalizacao() {
        return $this->localizacao;
    }

    public function getTempo_estimado() {
        return $this->tempo_estimado;
    }

    public function getTempo_real() {
        return $this->tempo_real;
    }

    public function setPedido_id($pedido_id): void {
        $this->pedido_id = $pedido_id;
    }

    public function setPreco($preco): void {
        $this->preco = $preco;
    }

    public function setNomeCliente($nomeCliente): void {
        $this->nomeCliente = $nomeCliente;
    }

    public function setNomeMotorista($nomeMotorista): void {
        $this->nomeMotorista = $nomeMotorista;
    }

    public function setLocalizacao($localizacao): void {
        $this->localizacao = $localizacao;
    }

    public function setTempo_estimado($tempo_estimado): void {
        $this->tempo_estimado = $tempo_estimado;
    }

    public function setTempo_real($tempo_real): void {
        $this->tempo_real = $tempo_real;
    }


    
}
