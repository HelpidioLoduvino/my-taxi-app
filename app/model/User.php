<?php

class User {

    private $id;
    private $nome;
    private $email;
    private $morada;
    private $data_nascimento;
    private $tipo;
    private $password;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMorada() {
        return $this->morada;
    }

    public function getData_nascimento() {
        return $this->data_nascimento;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }

    public function setMorada($morada): void {
        $this->morada = $morada;
    }

    public function setData_nascimento($data_nascimento): void {
        $this->data_nascimento = $data_nascimento;
    }

    public function setTipo($tipo): void {
        $this->tipo = $tipo;
    }

    public function setPassword($password): void {
        $this->password = $password;
    }

}
