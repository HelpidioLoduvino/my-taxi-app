<?php

class CategoriaViatura {
    private $id;
    private $velocidade_media;
    private $fiabilidade;
    private $descricao;
    
    public function getId() {
        return $this->id;
    }

    public function getVelocidade_media() {
        return $this->velocidade_media;
    }

    public function getFiabilidade() {
        return $this->fiabilidade;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setVelocidade_media($velocidade_media): void {
        $this->velocidade_media = $velocidade_media;
    }

    public function setFiabilidade($fiabilidade): void {
        $this->fiabilidade = $fiabilidade;
    }

    public function setDescricao($descricao): void {
        $this->descricao = $descricao;
    }




}
