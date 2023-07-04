<?php

class Viatura {
    private $id;
    private $id_categoria;
    private $id_motorista;
    
    public function getId() {
        return $this->id;
    }

    public function getId_categoria() {
        return $this->id_categoria;
    }

    public function getId_motorista() {
        return $this->id_motorista;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setId_categoria($id_categoria): void {
        $this->id_categoria = $id_categoria;
    }

    public function setId_motorista($id_motorista): void {
        $this->id_motorista = $id_motorista;
    }


}
